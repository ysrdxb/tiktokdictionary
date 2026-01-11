# TikTokDictionary.com - User Flow Documentation

## Overview
This document maps all user journeys through the TikTokDictionary.com platform, from first visit to active contribution.

---

## Flow 1: First-Time Visitor Discovery

### 1.1 Landing on Homepage

**Trigger**: User navigates to tiktokdictionary.com

**User Sees**:
1. Fixed glassmorphic header with logo and "Drop the Lore" CTA
2. Hero section with tagline: "The People's Slang Bible"
3. Large pill-shaped search bar
4. Bento Grid of word cards with varying sizes

**User Actions**:
- Scroll through word cards
- Read definitions and examples
- Observe vote counts and categories

**Visual Feedback**:
- Cards animate on scroll (fade-in-up effect)
- Hover effects on cards (lift + glow)
- Smooth transitions on all interactions

---

### 1.2 Exploring Word Cards

**User Observes**:
- **Large Viral Cards** (2x2): Featured trending words with high engagement
- **Medium Cards** (1x1): Regular definitions with basic info
- **Tall Cards** (1x2): Words with examples and context
- **Wide Cards** (2x1): Classic terms with established definitions

**Card Components**:
1. Category badge (colored pill: VIRAL, NEW, TRENDING, etc.)
2. Timestamp (e.g., "2h ago")
3. Term (large, bold typography)
4. Definition (clear, concise explanation)
5. Submitted by username (e.g., "@smoothoperator")
6. Voting counter (No Cap / Cap buttons with counts)
7. Vote progress bar (visual representation)

**User Emotional Response**:
- Feels engaged by modern, TikTok-inspired design
- Recognizes familiar slang terms
- Curious about new terms discovered

---

## Flow 2: Searching for a Specific Word

### 2.1 Initiating Search

**Trigger**: User clicks into search bar

**Step 1**: User types query (e.g., "rizz")

**System Response** (300ms debounce):
1. Loading spinner appears in search bar
2. Livewire component queries database
3. Results dropdown appears below search bar

**Search Algorithm**:
- Checks for exact match first
- Then checks for partial matches (starts with, contains)
- Applies phonetic matching (SOUNDEX)
- Searches within definitions
- Orders by velocity_score

---

### 2.2 Search Results Display

**Scenario A: Results Found**

**User Sees**:
- Dropdown with up to 5 matching words
- Each result shows:
  - Term (bold, large)
  - Category badge
  - Truncated definition (80 chars)
  - Vote counts (agree/disagree icons + numbers)
  
**User Actions**:
- Hover over result (background lightens)
- Click on result
  
**System Response**:
- Search bar populates with selected term
- Dropdown closes
- Page scrolls to word detail (future: opens detail modal)

---

**Scenario B: No Results Found**

**User Sees**:
- Dropdown with "No results found" message
- Thinking face emoji (🤔)
- Message: "This slang isn't in the dictionary yet!"
- "Drop the Lore" CTA button

**User Actions**:
- Click "Drop the Lore" button

**System Response**:
- Opens submission modal
- Pre-fills term field with search query

---

### 2.3 Clearing Search

**Trigger**: User clicks X button in search bar

**System Response**:
- Query resets to empty
- Dropdown closes
- Search bar returns to placeholder state

---

## Flow 3: Voting on a Definition

### 3.1 Reading and Evaluating

**Trigger**: User lands on a word card and reads definition

**User Mental Process**:
- "Is this definition accurate?"
- "Do I agree with this explanation?"
- Decides to vote

---

### 3.2 Casting a Vote (First Time)

**Trigger**: User clicks "No Cap" (Agree) button

**Optimistic UI Update** (Instant):
1. Button changes color to cyan (#25F4EE)
2. Button scales up slightly (scale-105)
3. Button gets cyan glow shadow
4. Agree count increments by 1
5. Progress bar animates to new percentage

**Server Persistence** (Background):
1. Livewire sends vote to backend
2. Database increments agrees count
3. Velocity score recalculates
4. Cookie set: `vote_word_{id} = 'agree'` (7-day expiry)

**Loading State**:
- Small loading spinner appears briefly
- User can continue browsing immediately

**Success Confirmation**:
- Vote persists across page refreshes
- Button remains highlighted on return visits

---

### 3.3 Casting a Vote (Alternative: Cap/Disagree)

**Trigger**: User clicks "Cap" (Disagree) button

**Optimistic UI Update** (Instant):
1. Button changes color to pink (#FE2C55)
2. Button scales up slightly
3. Button gets pink glow shadow
4. Disagree count increments by 1
5. Progress bar animates to new percentage

**Backend Logic**: Same as agree flow

---

### 3.4 Changing Vote

**Scenario**: User previously voted "No Cap" but now clicks "Cap"

**System Response**:
1. Previous "No Cap" button returns to default state
2. Agree count decrements by 1
3. "Cap" button becomes active (pink)
4. Disagree count increments by 1
5. Progress bar updates
6. Cookie updates to new vote
7. Database updates both counts

**Animation**: Smooth transition (300ms ease-out)

---

### 3.5 Removing Vote

**Scenario**: User clicks same button they already voted on

**System Response**:
1. Button returns to default state (gray)
2. Vote count decrements by 1
3. Progress bar updates
4. Cookie deleted
5. Database decrements count

**User Intent**: "I changed my mind" or "I'm not sure anymore"

---

## Flow 4: Submitting a New Word

### 4.1 Opening Submission Modal

**Triggers**:
- User clicks "Drop the Lore" in header
- User clicks "Drop the Lore" from no-search-results screen
- User clicks "Add to existing" from duplicate warning (alternative flow)

**System Response**:
1. Dark overlay appears (backdrop blur)
2. Modal slides in from center with scale animation
3. Form fields are empty (or term pre-filled from search)

---

### 4.2 Filling Out Form

**Step 1: Enter Term**

**User Types**: "Delulu"

**System Response** (500ms debounce):
- Fuzzy search activates
- Checks for similar words in database
- If similar words found: Shows yellow warning banner

**Duplicate Warning Banner**:
- ⚠️ Icon + "Similar Words Found"
- Lists up to 3 similar words with:
  - Term
  - Truncated definition
  - "Add to this" button
- User can choose to:
  - Continue with submission (new word)
  - Add to existing word (future feature)

---

**Step 2: Enter Definition**

**User Types**: "Being delusional about a situation, especially in romance."

**System Response**:
- Character counter updates: "68/500 characters"
- No validation errors (meets 10 char minimum)

---

**Step 3: Add Example (Optional)**

**User Types**: "She's so delulu thinking he likes her back."

**System Response**:
- Field accepts input (no character counter for optional field)

---

**Step 4: Select Category**

**User Clicks**: Dropdown menu

**Options Displayed**:
- TikTok (default selected)
- Instagram
- Twitter / X
- Snapchat
- Gen-Z
- AAVE
- Gaming
- Anime
- Other

**User Selects**: "TikTok"

---

**Step 5: Enter Username**

**User Types**: "@dictionarygirl"

**System Response**:
- Field accepts alphanumeric + underscore
- No authentication required (anonymous submission)

---

### 4.3 Validation Errors

**Scenario A: Missing Required Field**

**User Action**: Clicks "Drop the Lore 📖" without filling term

**System Response**:
1. Form does not submit
2. Error message appears below term field (pink text)
3. Message: "What's the word? 🤔"
4. Field border turns pink
5. Form focuses on error field

**Other Validation Messages**:
- Term too short: "Too short! Give us at least 2 characters."
- Definition too short: "Definition too short! Give us more details."
- Definition too long: "Keep it under 500 characters, fam."
- Username missing: "Who's dropping this knowledge? Drop your @"

---

**Scenario B: Exact Duplicate**

**User Action**: Submits word that exactly matches existing term

**System Response**:
1. Form submits to server
2. Server checks for exact duplicate (case-insensitive)
3. Pink error banner appears at top
4. Message: "This word already exists! Vote on it or add to the existing definition."
5. Form does not reset
6. User can edit and resubmit

---

### 4.4 Successful Submission

**Trigger**: All validation passes, no exact duplicates found

**System Response**:
1. Loading state: Button text changes to "Dropping... 🚀"
2. Button becomes disabled (prevents double submission)
3. Form submits via Livewire
4. Database creates new word record:
   - Generates slug from term
   - Sets agrees/disagrees to 0
   - Calculates initial velocity_score
   - Timestamps created_at
5. Success banner appears (green/cyan background)
6. Success message: "Lore Dropped Successfully! Your word is now live. No cap! 💯"
7. Form fields reset
8. After 2 seconds: Modal auto-closes
9. Homepage refreshes with new word visible in grid

---

**Emotional Response**:
- User feels accomplished
- Sees immediate impact (word is live)
- Motivated to share or submit more

---

## Flow 5: Browsing by Category

### 5.1 Selecting Category Filter

**Trigger**: User clicks category badge or navigation link

**Available Categories** (from header nav or filters):
- Trending (velocity algorithm)
- Viral (most agrees)
- New (recent submissions)
- TikTok, Instagram, Twitter, etc.

**System Response**:
1. Page navigates to `/category/{category}`
2. Grid repopulates with filtered words
3. Header highlights active category
4. URL updates for shareability

---

## Flow 6: Mobile User Experience

### 6.1 Mobile-Specific Interactions

**Layout Differences**:
- Single column grid (stacked cards)
- Hamburger menu for navigation (if implemented)
- Larger touch targets (buttons 48x48px minimum)
- Search bar full width
- Modal takes full screen on small devices

**Touch Gestures**:
- Tap to vote (larger hit area)
- Swipe to close modal
- Pull to refresh (future)

**Performance**:
- Cards lazy load as user scrolls
- Images optimized for mobile
- Reduced animations on low-end devices

---

## Flow 7: Returning User Experience

### 7.1 Persistent State

**Cookies Stored**:
- `vote_word_{id}`: User's vote on each word (7-day expiry)

**User Experience**:
- Previous votes are highlighted in correct color
- User can continue voting on new words
- Search history not persisted (privacy-focused)

---

## User Journey Map

```
First Visit → Discover Words → Search → Vote → Submit → Share
    ↓            ↓              ↓       ↓       ↓        ↓
 (Curious)   (Engaged)      (Active) (Contrib) (Creator) (Advocate)
```

---

## Success Metrics by Flow

### Discovery Flow:
- Average time on page: 2+ minutes
- Cards scrolled: 10+
- Bounce rate: < 40%

### Search Flow:
- Search initiated: 60%+ of visitors
- Results clicked: 40%+ of searches
- No results leading to submission: 10%

### Voting Flow:
- Vote cast: 30%+ of visitors
- Multiple votes: 15%+ of voters
- Vote changed: 5% of voters

### Submission Flow:
- Modal opened: 10% of visitors
- Form completed: 50% of modal opens
- Successful submission: 80% of completions

---

## Edge Cases and Error Handling

### Network Errors:
- Voting: Retry automatically, show "Vote may not have saved" if retry fails
- Search: Show "Search unavailable" message
- Submission: Keep form data, show "Connection lost" banner

### Browser Compatibility:
- No backdrop-filter: Fallback to solid dark background
- No JavaScript: Show static word list (no voting, no search)
- Slow connection: Show skeleton loaders

### User Errors:
- Accidental click: Easy to undo vote
- Form abandonment: Modal closes without saving
- Invalid input: Clear, friendly error messages

---

## Future Flow Enhancements

### Phase 2:
- User authentication flow
- Profile creation and management
- Word history (submitted, voted on)
- Notification preferences

### Phase 3:
- Social sharing flow
- Embed widgets for external sites
- API access for developers
- Mobile app download flow

---

## Accessibility Flows

### Keyboard Navigation:
1. Tab through search bar → word cards → vote buttons → submit CTA
2. Enter to activate buttons
3. Escape to close modal
4. Arrow keys to navigate results

### Screen Reader Flow:
1. Hear page title and description
2. Hear card count and layout structure
3. Hear word term, definition, and vote counts
4. Clear button labels ("Vote agree", "Vote disagree")
5. Form field labels and validation errors announced

---

## Conversion Funnel

```
100 Visitors
   ↓
70 Scroll & Engage (70%)
   ↓
45 Search for Word (45%)
   ↓
30 Cast a Vote (30%)
   ↓
10 Open Submit Modal (10%)
   ↓
5 Complete Submission (5%)
   ↓
1 Submit Multiple Words (1%)
```

**Optimization Goals**:
- Increase scroll engagement to 80%
- Increase voting to 40%
- Increase submission completion to 60%
