# TikTokDictionary.com - Backend Concept & Architecture

## Overview
This document provides a deep dive into the technical architecture, algorithms, and backend strategies that power TikTokDictionary.com. The focus is on the Velocity Trending Algorithm and Livewire Optimistic UI implementation.

---

## 1. The Velocity Trending Algorithm

### 1.1 Problem Statement

**Challenge**: How do we surface the best content while giving new submissions a fair chance?

**Traditional Approaches & Their Flaws**:
- **Most Popular (Agrees DESC)**: Old content dominates forever, new content buried
- **Most Recent (created_at DESC)**: Poor quality content appears first, no merit consideration
- **Simple Score (Agrees - Disagrees)**: Time-insensitive, doesn't account for post age

**Our Solution**: Time-decay weighted scoring that balances popularity with recency.

---

### 1.2 The Formula

```
Velocity Score = (Agrees - Disagrees) / (HoursOld + 2)^1.5
```

**Components Explained**:

#### Net Votes (Agrees - Disagrees)
- Represents community consensus
- Positive = more agrees than disagrees
- Negative = controversial or inaccurate
- Zero = neutral or no votes yet

#### Hours Old
- Time since word was created
- Calculated: `now() - created_at` in hours
- Ensures older content gradually loses prominence

#### The "+2" Buffer
- **Purpose**: Prevents division by very small numbers
- **Effect**: Gives brand new content (0-2 hours) a boost
- **Example**: 
  - Post at 0 hours: `score / 2^1.5 = score / 2.83`
  - Post at 10 hours: `score / 12^1.5 = score / 41.57`

#### The "^1.5" Decay Exponent
- **Why 1.5?** Balanced decay curve
  - **Too low (^1.0)**: Content decays too slowly
  - **Too high (^2.0)**: Content decays too quickly
  - **Just right (^1.5)**: Smooth, natural decay
  
**Decay Curve Visualization**:
```
Hours Old | Decay Factor | % of Original Score
---------------------------------------------
0         | 2.83         | 100%
1         | 5.20         | 54%
2         | 8.00         | 35%
6         | 22.63        | 13%
12        | 41.57        | 7%
24        | 74.66        | 4%
48        | 129.45       | 2%
```

---

### 1.3 Example Calculations

**Scenario A: Viral New Word**
- Agrees: 500
- Disagrees: 20
- Hours Old: 3
- Calculation: `(500 - 20) / (3 + 2)^1.5 = 480 / 11.18 = 42.93`
- **Result**: High velocity score, trends at top

**Scenario B: Old Popular Word**
- Agrees: 5000
- Disagrees: 200
- Hours Old: 72
- Calculation: `(5000 - 200) / (72 + 2)^1.5 = 4800 / 636.68 = 7.54`
- **Result**: Lower velocity score, moves down over time

**Scenario C: Controversial Word**
- Agrees: 300
- Disagrees: 280
- Hours Old: 5
- Calculation: `(300 - 280) / (5 + 2)^1.5 = 20 / 18.52 = 1.08`
- **Result**: Low velocity, not trending despite many votes

**Scenario D: Brand New Word**
- Agrees: 5
- Disagrees: 0
- Hours Old: 0.5
- Calculation: `(5 - 0) / (0.5 + 2)^1.5 = 5 / 3.95 = 1.27`
- **Result**: Decent visibility despite low vote count

---

### 1.4 Implementation in Code

**Model Method** (`app/Models/Word.php`):

```php
public function updateVelocityScore()
{
    // Calculate net votes (community consensus)
    $netVotes = $this->agrees - $this->disagrees;
    
    // Calculate age in hours
    $hoursOld = Carbon::parse($this->created_at)
                      ->diffInHours(Carbon::now());
    
    // Apply velocity formula
    // +2 prevents division by zero and boosts new content
    // ^1.5 creates smooth decay curve
    $velocity = $netVotes / pow(($hoursOld + 2), 1.5);
    
    // Store in database for efficient querying
    $this->velocity_score = $velocity;
    $this->save();
    
    return $velocity;
}
```

**When It Runs**:
1. Every time a vote is cast (real-time update)
2. On word creation (initial score of 0)
3. Optionally: Scheduled job every hour to recalculate all scores

**Database Query**:
```php
// Get trending words
Word::orderByDesc('velocity_score')
    ->limit(20)
    ->get();
```

---

### 1.5 Algorithm Tuning Parameters

**Adjustable Variables**:
- **Time Buffer**: Currently 2, could be 1-5
- **Decay Exponent**: Currently 1.5, could be 1.2-2.0
- **Minimum Votes**: Could add threshold (e.g., require 5+ votes to trend)

**A/B Testing Opportunities**:
```php
// Version A: Aggressive decay (favor newer content)
$velocity = $netVotes / pow(($hoursOld + 1), 2.0);

// Version B: Slow decay (favor popular content)
$velocity = $netVotes / pow(($hoursOld + 5), 1.2);

// Version C: Minimum vote threshold
if ($this->agrees + $this->disagrees < 10) {
    $velocity = 0; // Don't trend until 10 votes
}
```

---

### 1.6 Edge Cases & Handling

**Negative Scores**:
- If disagrees > agrees, velocity is negative
- These words sink to bottom naturally
- Could auto-hide words with score < -10

**Division by Zero**:
- Prevented by "+2" buffer
- Even at hour 0, denominator is 2^1.5 = 2.83

**Integer Overflow**:
- MySQL DECIMAL(10,4) supports up to 999,999.9999
- Unlikely to exceed with our formula

**Controversial Content**:
- High total votes but low net score
- Could add "controversy score": `(agrees + disagrees) / |agrees - disagrees|`

---

## 2. Livewire Optimistic UI Strategy

### 2.1 Problem: Traditional Form Submission is Slow

**Bad UX Flow**:
1. User clicks vote button
2. Page shows loading spinner
3. Wait 500-1000ms for server response
4. Page reloads or updates
5. User sees result

**User Perception**: "This site is slow and unresponsive"

---

### 2.2 Solution: Optimistic Updates

**Optimistic UX Flow**:
1. User clicks vote button
2. UI updates **instantly** (assume success)
3. Background AJAX request to server
4. Server confirms (or rolls back if failed)

**User Perception**: "This site is fast and smooth!"

---

### 2.3 Implementation Architecture

**Frontend (Livewire Component)**:

```php
class VotingCounter extends Component
{
    public $agrees = 0;
    public $disagrees = 0;
    
    // Optimistic local state
    public $localAgrees = 0;
    public $localDisagrees = 0;
    
    public function mount($wordId, $agrees, $disagrees)
    {
        // Load initial state from database
        $this->agrees = $agrees;
        $this->disagrees = $disagrees;
        
        // Clone to local state for optimistic updates
        $this->localAgrees = $agrees;
        $this->localDisagrees = $disagrees;
    }
    
    public function vote($type)
    {
        // OPTIMISTIC UPDATE (instant)
        if ($type === 'agree') {
            $this->localAgrees++;
        } else {
            $this->localDisagrees++;
        }
        
        // BACKGROUND PERSISTENCE (async)
        $this->persistVote($type);
        
        // Update trending score
        $this->emit('voteRecorded', $this->wordId);
    }
}
```

**View Template** (`resources/views/livewire/voting-counter.blade.php`):

```blade
<button wire:click="vote('agree')">
    No Cap: {{ number_format($localAgrees) }}
</button>
```

**Key Insight**: Display `$localAgrees` (instant), persist `$agrees` (background).

---

### 2.4 State Management

**Three Layers of State**:

1. **UI State** (`$localAgrees`): What user sees (instant updates)
2. **Component State** (`$agrees`): Server-confirmed count
3. **Database State** (`words.agrees`): Source of truth

**Sync Strategy**:
```
User Click → Update UI State → Background Persist → Sync Component State
```

**Error Handling**:
```php
protected function persistVote($type)
{
    try {
        $word = Word::find($this->wordId);
        $word->increment($type === 'agree' ? 'agrees' : 'disagrees');
        $word->updateVelocityScore();
        
        // Success: Component state catches up
        $this->agrees = $word->agrees;
        $this->disagrees = $word->disagrees;
        
    } catch (\Exception $e) {
        // Error: Rollback UI state
        if ($type === 'agree') {
            $this->localAgrees--;
        } else {
            $this->localDisagrees--;
        }
        
        // Show error message
        session()->flash('error', 'Vote failed. Please try again.');
    }
}
```

---

### 2.5 Cookie-Based Vote Tracking

**Why Cookies, Not Sessions?**
- No authentication required (anonymous voting)
- Persistent across browser sessions
- No server-side session storage needed
- Privacy-friendly (no user tracking)

**Implementation**:

```php
// Store vote in cookie (7 days)
Cookie::queue("vote_word_{$this->wordId}", 'agree', 10080);

// Check vote on page load
$this->userVote = Cookie::get("vote_word_{$this->wordId}");

// Remove vote
Cookie::queue(Cookie::forget("vote_word_{$this->wordId}"));
```

**Cookie Structure**:
```
vote_word_1 = "agree"
vote_word_2 = "disagree"
vote_word_5 = "agree"
```

**Security Considerations**:
- Cookies can be cleared (user can vote again)
- Could add IP-based rate limiting in future
- Not critical: Voting is low-stakes, not financial

---

### 2.6 Alpine.js Micro-Interactions

**Purpose**: Add visual feedback without full component re-render

**Button Click Animation**:
```blade
<button 
    wire:click="vote('agree')"
    @click="voting = true; setTimeout(() => voting = false, 300)"
    :class="{ 'scale-95': voting }">
```

**Progress Bar Animation**:
```blade
<div 
    x-transition:enter="transition ease-out duration-500"
    style="width: {{ $votePercentage }}%">
</div>
```

**Benefit**: Smooth, native-feeling interactions without complex JavaScript.

---

## 3. Fuzzy Search & Duplicate Prevention

### 3.1 Search Strategies

**Multi-Strategy Approach**:

1. **Exact Match** (Highest Priority)
   ```sql
   WHERE LOWER(term) = 'rizz'
   ```

2. **Prefix Match**
   ```sql
   WHERE LOWER(term) LIKE 'rizz%'
   ```

3. **Contains Match**
   ```sql
   WHERE LOWER(term) LIKE '%rizz%'
   ```

4. **Phonetic Match** (SOUNDEX)
   ```sql
   WHERE SOUNDEX(term) = SOUNDEX('rizz')
   ```
   - Matches: "riz", "riss", "rice" (sounds similar)
   - Prevents: "totally different word"

5. **Definition Search**
   ```sql
   WHERE LOWER(definition) LIKE '%charisma%'
   ```

---

### 3.2 SOUNDEX Algorithm

**How It Works**:
- Converts word to phonetic code
- "Rizz" → R200
- "Riz" → R200
- "Rice" → R200
- "Smith" → S530

**MySQL Implementation**:
```sql
SELECT * FROM words 
WHERE SOUNDEX(term) = SOUNDEX('rizz')
```

**Limitations**:
- English-only (doesn't work for non-Latin scripts)
- Not perfect (some false positives/negatives)
- Supplement with other strategies

---

### 3.3 Duplicate Detection Flow

**Real-Time Duplicate Warning**:

```php
public function updatedTerm()
{
    if (strlen($this->term) >= 3) {
        // Fuzzy search as user types
        $this->duplicateWords = Word::findSimilar($this->term)
            ->limit(3)
            ->get();
        
        $this->showDuplicateWarning = count($this->duplicateWords) > 0;
    }
}
```

**Visual Feedback**:
- Yellow warning banner appears
- Shows similar words with "Add to this" button
- User can choose to continue or contribute to existing

**Submission Blocker**:
```php
public function submit()
{
    // Hard block exact duplicates
    $existingWord = Word::whereRaw('LOWER(term) = ?', [strtolower($this->term)])
        ->first();
    
    if ($existingWord) {
        session()->flash('error', 'This word already exists!');
        return;
    }
    
    // Allow submission if not exact match
    Word::create([...]);
}
```

---

### 3.4 Database Indexing Strategy

**Required Indexes**:

```php
Schema::create('words', function (Blueprint $table) {
    $table->index('velocity_score'); // For trending queries
    $table->index('agrees');         // For viral queries
    $table->index('category');       // For category filters
    $table->index('created_at');     // For new queries
    $table->fullText(['term', 'definition']); // For search
});
```

**Query Performance**:
- Without indexes: 500ms+ for search
- With indexes: <50ms for search

**Trade-off**:
- Faster reads (queries)
- Slightly slower writes (inserts/updates)
- Justified: More reads than writes

---

## 4. Data Flow Architecture

### 4.1 System Architecture Diagram

```
┌─────────────┐
│   Browser   │
└──────┬──────┘
       │ (1) HTTP Request
       ↓
┌─────────────────┐
│  Laravel Router │
└────────┬────────┘
         │ (2) Route to Controller
         ↓
┌──────────────────┐
│ Livewire Runtime │
└────────┬─────────┘
         │ (3) Mount Component
         ↓
┌────────────────────┐
│ VotingCounter.php  │  ← Optimistic UI Logic
└────────┬───────────┘
         │ (4) Persist Vote
         ↓
┌──────────────┐
│  Word Model  │  ← Velocity Algorithm
└──────┬───────┘
       │ (5) Database Query
       ↓
┌──────────────┐
│    MySQL     │  ← Indexed Tables
└──────────────┘
```

---

### 4.2 Request Lifecycle

**Initial Page Load**:
1. Browser requests `/`
2. Router loads `welcome.blade.php`
3. Blade compiles Livewire directives (`@livewire`)
4. Livewire mounts components with initial state
5. Components query database for word data
6. HTML rendered and sent to browser
7. Livewire JavaScript hydrates components

**Vote Interaction**:
1. User clicks "No Cap" button
2. Alpine.js triggers animation (instant)
3. Livewire `wire:click` fires `vote('agree')`
4. Component updates `$localAgrees` (instant)
5. View re-renders with new count (instant)
6. Background AJAX to server
7. Server increments database count
8. Server recalculates velocity score
9. Server sets cookie
10. Response confirms success
11. Component syncs `$agrees` with database

**Total User-Perceived Time**: ~100ms (optimistic UI)
**Total Server Time**: ~300ms (background)

---

### 4.3 Scaling Considerations

**Caching Strategy**:
```php
// Cache trending words for 5 minutes
$trending = Cache::remember('trending_words', 300, function () {
    return Word::getTrending(20);
});
```

**Database Optimization**:
- Use read replicas for heavy search traffic
- Offload velocity calculations to queue workers
- Cache velocity scores (update every 15 minutes, not every vote)

**CDN Integration**:
- Serve static assets (CSS, JS, images) from CDN
- Edge caching for anonymous users
- Real-time updates via Livewire for voting

---

## 5. Security & Rate Limiting

### 5.1 Input Validation

**Laravel Validation Rules**:
```php
protected $rules = [
    'term' => 'required|min:2|max:50|regex:/^[\pL\pN\s\-]+$/u',
    'definition' => 'required|min:10|max:500',
    'submitted_by' => 'required|min:2|max:50|regex:/^@?[\w]+$/',
];
```

**XSS Prevention**:
- Blade automatically escapes output: `{{ $term }}`
- Manual escaping for attributes: `{!! strip_tags($definition) !!}`

**SQL Injection Prevention**:
- Eloquent ORM uses prepared statements
- Never concatenate raw SQL: `whereRaw('LOWER(term) = ?', [$term])`

---

### 5.2 Rate Limiting (Future Implementation)

**Voting Limits**:
```php
// Max 20 votes per minute per IP
RateLimiter::for('voting', function (Request $request) {
    return Limit::perMinute(20)->by($request->ip());
});
```

**Submission Limits**:
```php
// Max 5 submissions per hour per IP
RateLimiter::for('submit', function (Request $request) {
    return Limit::perHour(5)->by($request->ip());
});
```

**Search Limits**:
```php
// Max 60 searches per minute per IP
RateLimiter::for('search', function (Request $request) {
    return Limit::perMinute(60)->by($request->ip());
});
```

---

## 6. Testing Strategy

### 6.1 Unit Tests

**Velocity Algorithm**:
```php
public function test_velocity_score_calculation()
{
    $word = Word::factory()->create([
        'agrees' => 100,
        'disagrees' => 10,
        'created_at' => now()->subHours(5),
    ]);
    
    $score = $word->updateVelocityScore();
    
    // Expected: (100-10) / (5+2)^1.5 = 90 / 18.52 ≈ 4.86
    $this->assertEqualsWithDelta(4.86, $score, 0.1);
}
```

**Fuzzy Search**:
```php
public function test_soundex_search()
{
    Word::create(['term' => 'Rizz', 'definition' => '...']);
    
    $results = Word::fuzzySearch('Riz');
    
    $this->assertCount(1, $results);
    $this->assertEquals('Rizz', $results->first()->term);
}
```

---

### 6.2 Feature Tests

**Optimistic Voting**:
```php
public function test_optimistic_voting_updates_ui()
{
    Livewire::test(VotingCounter::class, ['wordId' => 1, 'agrees' => 10])
        ->call('vote', 'agree')
        ->assertSet('localAgrees', 11); // Instant update
}
```

**Duplicate Prevention**:
```php
public function test_duplicate_word_blocked()
{
    Word::create(['term' => 'Rizz', 'definition' => '...']);
    
    Livewire::test(SubmitWordForm::class)
        ->set('term', 'rizz')
        ->call('submit')
        ->assertHasErrors(['term']);
}
```

---

## 7. Performance Metrics

### 7.1 Target Benchmarks

- **Page Load**: < 2 seconds (LCP)
- **Search Results**: < 300ms
- **Vote Update**: < 100ms (optimistic), < 500ms (server)
- **Form Submission**: < 1 second
- **Database Queries**: < 50ms average

### 7.2 Monitoring

**Key Metrics to Track**:
- Velocity score distribution
- Vote frequency (votes per minute)
- Search query patterns
- Duplicate detection accuracy
- Server response times

---

## Summary

**Core Innovations**:
1. **Velocity Algorithm**: Balanced, fair trending system
2. **Optimistic UI**: Instant feedback, background persistence
3. **Fuzzy Search**: Multi-strategy duplicate prevention
4. **Cookie Voting**: Anonymous, persistent, privacy-friendly

**Technical Stack**:
- Laravel 10.x: Backend framework
- Livewire 3.x: Reactive components
- Alpine.js 3.x: Micro-interactions
- MySQL 8.x: Indexed relational data
- Tailwind CSS: Utility-first styling

**Scalability Path**:
- Cache trending calculations
- Queue velocity updates
- CDN for static assets
- Read replicas for search
