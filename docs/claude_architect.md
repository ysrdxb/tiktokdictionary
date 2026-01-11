# TikTokDictionary - Senior Architect Report

**Last Updated**: January 11, 2026
**Architect**: Claude (Senior Software Architect)
**Project**: TikTokDictionary.com
**Framework**: Laravel 11 + Livewire 3 + Alpine.js + Tailwind CSS

---

## FOR AI ASSISTANTS - READ THIS FIRST

### Step 1: Check the Task Board
**Open `docs/TASKS.md` immediately** - This is the task management system.

### Step 2: Find a Task
- Look for tasks with `Status: TODO`
- Check "Depends On" - don't start if dependencies aren't done
- Pick from "Next Available Tasks" section at bottom

### Step 3: Claim the Task
Before writing any code:
1. Change `Status: TODO` to `Status: IN_PROGRESS`
2. Add your session identifier to `Claimed By:`
3. Add today's date to `Started:`

### Step 4: Build It
- Follow the step-by-step instructions in the task
- Create/modify only the files listed
- Meet all acceptance criteria

### Step 5: Mark Complete
When done:
1. Change `Status: IN_PROGRESS` to `Status: DONE`
2. Add completion date
3. Check all acceptance criteria boxes
4. Add entry to CHANGE LOG at bottom

### DO NOT:
- Work on `IN_PROGRESS` tasks (another AI is on it)
- Skip dependencies
- Create files not listed in the task
- Forget to update status

---

### Quick Links
| Document | Purpose |
|----------|---------|
| **`docs/TASKS.md`** | Task board - START HERE |
| `docs/claude_architect.md` | Architecture overview (this file) |
| `docs/readme.md` | Original client requirements |

### Quick Task Reference

| Task | Priority | Location | What To Do |
|------|----------|----------|------------|
| **Advanced Admin Panel** | CRITICAL | See Section 4 | Full rebuild with Filament PHP |
| Word of the Day | CRITICAL | `HomeController.php`, `welcome.blade.php` | Add new section at top of homepage |
| Show Lore Timeline | CRITICAL | `word/show.blade.php` | Display `$word->lore` entries |
| Show RFCI Badge | HIGH | `bento-grid.blade.php` | Add `$word->rfci_score` to cards |
| Remove Fake Votes | HIGH | `welcome.blade.php:132` | Remove `+ rand(1000, 3000)` |
| Live View Pulse | MEDIUM | New Alpine component | Add `wire:poll` for real-time views |
| Domain Checker | LOW | New Livewire component | GoDaddy affiliate integration |

### Admin Panel Modules (Section 4)

| Module | Status | Priority |
|--------|--------|----------|
| Dashboard with Analytics | NOT BUILT | CRITICAL |
| Words Management (bulk actions, merge) | BASIC ONLY | CRITICAL |
| Definitions Moderation Queue | NOT BUILT | CRITICAL |
| User Management (roles, ban) | NOT BUILT | CRITICAL |
| Categories CRUD | NOT BUILT | CRITICAL |
| Trending Algorithm Control | NOT BUILT | HIGH |
| Content Moderation & Flags | NOT BUILT | HIGH |
| Settings & Configuration | NOT BUILT | HIGH |

### Full Site Gaps (Section 5)

| Category | Items Missing | Priority |
|----------|---------------|----------|
| **Database Tables** | 6 tables (categories, flags, activity_logs, settings, bookmarks, sessions) | CRITICAL |
| **User Columns** | 9 columns (role, banned_at, avatar, bio, reputation, etc.) | CRITICAL |
| **Frontend Features** | 11 features (Word of Day, Lore display, Report button, Profile, etc.) | HIGH |
| **Backend Features** | 8 features (Rate limiting, Password reset, API, Queues, etc.) | HIGH |
| **Middleware** | 4 middleware (throttle, banned, track-activity) | HIGH |
| **Scheduled Jobs** | 5 cron commands (polar trends, view sync, velocity calc) | MEDIUM |

### OVERALL PROJECT COMPLETION

```
CURRENT STATE:
├── Core Features (voting, search, submit) ............... 90% DONE
├── Admin Panel .......................................... 15% DONE (only basic CRUD)
├── User Management ...................................... 5% DONE (only is_admin flag)
├── Database Schema ...................................... 60% DONE (6 tables missing)
├── Frontend Polish ...................................... 70% DONE
├── Backend Infrastructure ............................... 40% DONE
└── TOTAL PROJECT ........................................ ~55% COMPLETE
```

### MASTER CHECKLIST - FROM docs/readme.md

**CORE FEATURES (Client's Fundamental Requirements)**
| Feature | Status | Notes |
|---------|--------|-------|
| Word submission | DONE | Full form working |
| Agree/Disagree voting | DONE | Facts/Cap labels |
| Hierarchical definition ranking | DONE | Auto-promotes top definition |
| Timeframe sorting (Now/Week/Month) | DONE | Filters working |
| Duplicate handling (fuzzy search) | DONE | SOUNDEX + modal warning |
| Categories page | PARTIAL | Hardcoded, needs DB table |
| Username-only auth | DONE | No email required |
| Admin panel | BASIC | Only word CRUD, needs full rebuild |

**WORD CARD REQUIREMENTS (readme.md lines 69-119)**
| Field | Status | What's Missing |
|-------|--------|----------------|
| 1. Word Title (clickable) | DONE | - |
| 2. Live view counter + green dot | PARTIAL | No wire:poll, no live pulse animation |
| 3. "Possible Polar Trend" badge | PARTIAL | Field exists, no auto-detection logic |
| 4. Description with "Read more" | DONE | Truncation working |
| 5. Agree button + popularity indicator | DONE | Facts/Cap working |
| 6. Category tag/pill | DONE | Shows on cards |
| 7. **Domain Availability Checker** | NOT DONE | MONETIZATION FEATURE - Critical! |
| 8. Submit alternate definition | DONE | AddDefinition component |
| 9. **RFCI Score display** | NOT DONE | Field in DB, not shown on frontend |
| 10. **AI Combined Summary (OpenAI)** | NOT DONE | Top of word page should have AI summary |

**GEMINI'S 5 UNCONVENTIONAL FEATURES (readme.md lines 156-214)**
| Feature | Status | Priority |
|---------|--------|----------|
| 1. Viral Velocity Heatmap (pulsing colors) | PARTIAL | Cards don't pulse based on velocity |
| 2. **Slang-to-Sticker Generator** | NOT DONE | html2canvas share image |
| 3. Lore Timeline | PARTIAL | Model exists, NOT displayed on word page |
| 4. **Vibe-Check Search (emotion tags)** | NOT DONE | AI assigns vibe tags |
| 5. **Investor Dashboard (Domain flip)** | NOT DONE | Trending words + available domains |

**TECHNICAL REQUIREMENTS (readme.md lines 311-318)**
| Feature | Status | Notes |
|---------|--------|-------|
| wire:poll for live view counters | NOT DONE | Currently static |
| Redis view buffering | NOT DONE | Direct DB writes (won't scale) |
| Polar trend auto-detection | NOT DONE | Manual only via admin |
| Search-to-Submit inline form | PARTIAL | Redirects to page, should be inline |
| Vertical Feed (TikTok scroll) | IN PROGRESS | AI building now |

**VISUAL STANDARDS (readme.md lines 284-292)**
| Feature | Status | Notes |
|---------|--------|-------|
| Dark Mode option | NOT DONE | Only light theme exists |
| TikTok Pink (#fe2c55) accent | NOT DONE | Using navy/blue only |
| Cyan (#25f4ee) accent | NOT DONE | Not implemented |
| Hover reveals vote buttons | NOT DONE | Always visible |

---

### PRIORITY BUILD ORDER (What to Tell AI Next)

**IMMEDIATE (Monetization + Core):**
```
1. Domain Availability Checker (GoDaddy affiliate) - THIS IS HOW SITE MAKES MONEY
2. RFCI Score display on cards and word page
3. Lore Timeline display on word/show.blade.php
4. Live view counter with wire:poll
```

**HIGH (Unconventional Features):**
```
5. Slang-to-Sticker Generator (share to TikTok/Instagram)
6. AI Combined Summary (OpenAI integration)
7. Polar trend auto-detection logic
8. Vertical Feed (IN PROGRESS)
```

**MEDIUM (Polish):**
```
9. Vibe-Check Search (AI emotion tags)
10. Investor Dashboard (trending + domain combo)
11. Dark mode toggle
12. Hover-reveal interactions
```

---

### RECOMMENDED BUILD ORDER

**Phase 1: Database Foundation (Do First)**
```
1. Create categories migration & model
2. Create flags migration & model
3. Create activity_logs migration & model
4. Create settings migration & model
5. Update users migration (add role, banned_at, etc.)
6. Run migrations
```

**Phase 2: Admin Panel Rebuild (Use Livewire)**
```
1. Create Livewire components:
   - Admin/Dashboard.php (stats, charts, activity feed)
   - Admin/WordsTable.php (search, filter, bulk actions)
   - Admin/DefinitionsTable.php (moderation queue)
   - Admin/UsersTable.php (roles, ban management)
   - Admin/CategoriesManager.php (CRUD)
   - Admin/Settings.php (site configuration)
2. Create admin blade views with dark theme
3. Add sidebar navigation component
4. Add bulk action functionality with Alpine.js
5. Add inline editing with wire:model
6. Add toast notifications
```

**Phase 3: User Features**
```
1. Add user profile page
2. Add edit/delete own definitions
3. Add report/flag button
4. Add password reset flow
5. Add rate limiting middleware
```

**Phase 4: Frontend Polish**
```
1. Add Word of the Day section
2. Display Lore Timeline on word page
3. Show RFCI badges
4. Remove fake vote inflation
5. Add share buttons
```

### Related Documentation

| File | Purpose |
|------|---------|
| `docs/readme.md` | Original client requirements |
| `docs/REQUIREMENTS.md` | Detailed feature specs |
| `docs/BACKEND_CONCEPT.md` | Technical architecture |
| `docs/USER_FLOW.md` | User journey maps |
| `docs/AUDIT_AND_IMPROVEMENT_PLAN.md` | Previous audit (Jan 10) |

---

## Executive Summary

TikTokDictionary is a user-powered slang dictionary targeting social media creators. The project is approximately **75% complete** for the initial $400 AUD milestone. Core functionality is working, but several key features from the client brief remain unimplemented.

---

## 1. Feature Status Dashboard

### CORE FEATURES (from docs/readme.md)

| Feature | Status | Implementation | Notes |
|---------|--------|----------------|-------|
| **Word Submission** | DONE | `SubmitWordForm.php`, `word/create.blade.php` | Full form with term, definition, example, category, origin |
| **Agree/Disagree Voting** | DONE | `VotingCounter.php` | Cookie-based persistence, "Facts/Cap" labels |
| **Hierarchical Definition Ranking** | DONE | `Definition::checkIfPrimary()` | Most-agreed auto-promoted to primary |
| **Timeframe Sorting (Now/Week/Month)** | DONE | `Word::getTrending()` | Filters working in homepage |
| **Duplicate Detection** | DONE | `Word::findSimilar()` | SOUNDEX fuzzy + LIKE matching |
| **Search Bar** | DONE | `SearchBar.php` | Live search with results dropdown |
| **Word Detail Page** | DONE | `word/show.blade.php` | Shows all definitions, voting, related words |
| **Browse/Categories Page** | DONE | `word/browse.blade.php` | Filter by category |
| **Admin Panel** | BASIC | `AdminController.php` | Only basic CRUD - **NEEDS FULL REBUILD (See Section 4)** |
| **Username-Only Auth** | DONE | `Auth/Login.php`, `Register.php` | No email required |

### ADVANCED FEATURES (from client creative brief)

| Feature | Status | Priority | Notes |
|---------|--------|----------|-------|
| **Live View Counter** | PARTIAL | HIGH | View increment works, but no real-time UI pulse |
| **"Polar Trend" Badge** | PARTIAL | HIGH | `is_polar_trend` field exists, no auto-detection logic |
| **Viral Velocity Heatmap** | NOT STARTED | MEDIUM | Bento grid exists but no color intensity based on velocity |
| **Domain Availability Check** | NOT STARTED | LOW | GoDaddy affiliate integration planned |
| **RFCI Score Display** | PARTIAL | LOW | Field exists in admin, not shown on frontend |
| **AI Combined Summary** | NOT STARTED | LOW | OpenAI integration not implemented |
| **Lore Timeline** | DONE | MEDIUM | Model + admin form exists, not shown on word page |
| **Slang-to-Sticker Generator** | NOT STARTED | LOW | html2canvas social sharing |
| **Vibe-Check Search** | NOT STARTED | LOW | Emotion-based search with AI tags |
| **Word of the Day** | NOT STARTED | HIGH | Client specifically requested this |

### UNCONVENTIONAL UI FEATURES

| Feature | Status | Notes |
|---------|--------|-------|
| **Kinetic Bento Grid** | DONE | Working with velocity-based card sizes |
| **Glass Morphism** | DONE | Backdrop blur effects throughout |
| **Live Pulse Animation** | DONE | "LIVE UPDATES" indicator in trending section |
| **Creator-Native Copy** | PARTIAL | "Facts/Cap" labels done, some robotic copy remains |
| **Vertical Feed (TikTok-style)** | NOT STARTED | Currently using grid layout |
| **Swipe Gestures (Mobile)** | NOT STARTED | Traditional button voting only |

---

## 2. Technical Architecture

### Database Schema

```
users
├── id, username, password (no email!)
├── is_admin (boolean)
└── timestamps

words
├── id, term, slug, category
├── origin_source, first_seen_date
├── velocity_score, admin_boost, rfci_score
├── views, views_buffer (for Redis strategy)
├── is_polar_trend, is_verified
├── vibes (JSON - for future AI tagging)
└── timestamps

definitions
├── id, word_id, user_id (nullable)
├── definition, example, source_type, source_url
├── agrees, disagrees, velocity_score
├── is_primary (auto-updated)
└── timestamps

lore_entries
├── id, word_id
├── title, description, date_event, source_url
└── timestamps
```

### Velocity Algorithm (IMPLEMENTED)

**Location**: `app/Models/Definition.php:39-52`

```php
Score = (Agrees - Disagrees) / (HoursOld + 2)^1.5
```

- Newer content with votes rises faster
- Old content naturally decays unless re-voted
- Admin boost adds manual override capability

### Key Services

| Service | Purpose | Status |
|---------|---------|--------|
| `TrendingService` | Calculates velocity scores, cached queries | DONE |
| `Word::getTrending()` | Timeframe-filtered trending | DONE |
| `Definition::checkIfPrimary()` | Auto-promote top definition | DONE |
| `Word::findSimilar()` | Duplicate prevention | DONE |

---

## 3. Gap Analysis - What's Missing

### CRITICAL (Must Have for Milestone)

| Gap | Impact | Effort | File(s) |
|-----|--------|--------|---------|
| Word of the Day section | Client requirement | 2 hrs | `HomeController.php`, `welcome.blade.php` |
| Show Lore Timeline on word page | Feature exists but hidden | 30 min | `word/show.blade.php` |
| Display RFCI score on cards | Data exists, not shown | 15 min | `bento-grid.blade.php` |

### HIGH PRIORITY

| Gap | Impact | Effort | File(s) |
|-----|--------|--------|---------|
| Auto-detect Polar Trends | Core differentiator | 2 hrs | `TrendingService.php`, scheduled job |
| Live view pulse animation | "Feels alive" requirement | 1 hr | Alpine.js + Livewire poll |
| Remaining robotic copy | Client explicitly flagged | 30 min | Multiple blade files |

### MEDIUM PRIORITY

| Gap | Impact | Effort | File(s) |
|-----|--------|--------|---------|
| Domain availability checker | Monetization feature | 4 hrs | New Livewire component, GoDaddy API |
| Vertical feed layout option | TikTok-style UX | 3 hrs | New blade component |
| Animated number counters | Polish | 1 hr | Alpine.js |

### LOW PRIORITY (Phase 2)

| Gap | Impact | Effort | File(s) |
|-----|--------|--------|---------|
| AI Combined Summary | Nice to have | 4 hrs | OpenAI integration |
| Slang-to-Sticker | Marketing feature | 2 hrs | html2canvas |
| Vibe-Check Search | Unique differentiator | 6 hrs | AI tagging system |
| Mobile swipe gestures | UX polish | 4 hrs | Hammer.js |

---

## 4. ADVANCED ADMIN PANEL - REQUIRED BUILD

**Status**: CURRENT ADMIN IS TOO BASIC - NEEDS COMPLETE REBUILD

The current admin panel (`admin/dashboard.blade.php`) only has basic CRUD. Client requires a **full-featured admin control center**.

---

### CURRENT STATE AUDIT (What Actually Exists)

#### Admin Routes (Only 5 routes exist)
```php
// THIS IS ALL THAT EXISTS:
Route::get('/admin', 'dashboard')           // List words with basic stats
Route::get('/admin/words/{word}/edit')      // Edit single word
Route::put('/admin/words/{word}')           // Update word
Route::delete('/admin/words/{word}')        // Delete word
Route::post('/admin/words/{word}/lore')     // Add lore entry
```

#### Admin Controller (Only 5 methods)
| Method | What It Does | What's Missing |
|--------|--------------|----------------|
| `index()` | Lists words with pagination | No search, no bulk actions |
| `edit()` | Edit form for single word | No inline editing |
| `update()` | Updates word fields | No validation feedback |
| `destroy()` | Deletes word | No soft delete option |
| `storeLore()` | Adds lore entry | No edit/delete lore |

#### Admin Views (Only 2 views)
```
resources/views/admin/
├── dashboard.blade.php   # Words table only
└── edit.blade.php        # Single word edit form
```

#### User Model (Minimal)
```php
// CURRENT STATE:
- is_admin (boolean)     // Only admin flag, no roles

// MISSING:
- role (enum)            // admin/moderator/trusted/regular/banned
- banned_at              // Ban timestamp
- ban_reason             // Why banned
- last_active_at         // Activity tracking
- ip_address             // For multi-account detection
```

#### What Does NOT Exist At All
| Feature | Status | Impact |
|---------|--------|--------|
| **User Management Page** | NOT EXISTS | Cannot manage users, ban spammers |
| **Definitions Management** | NOT EXISTS | Cannot edit/delete user definitions |
| **Moderation Queue** | NOT EXISTS | No way to approve/reject content |
| **Categories Management** | NOT EXISTS | Categories are HARDCODED in blade |
| **Settings Page** | NOT EXISTS | No way to configure site |
| **Activity Logs** | NOT EXISTS | No audit trail |
| **Flags/Reports** | NOT EXISTS | Users cannot report content |
| **Search in Admin** | NOT EXISTS | Cannot search words in dashboard |
| **Bulk Actions** | NOT EXISTS | Must edit words one by one |
| **Analytics Dashboard** | NOT EXISTS | Only 4 stat cards, no charts |
| **Export Data** | NOT EXISTS | Cannot export to CSV/Excel |

#### Categories Are Hardcoded!
```php
// In admin/edit.blade.php line 28-30:
@foreach(['Slang', 'TikTok', 'Memes', 'Gaming', 'Internet', 'Gen-Z'] as $cat)
    // This should be from database, not hardcoded!
@endforeach
```

---

### WHAT NEEDS TO BE BUILT

### 4.1 Required Admin Modules

#### A. DASHBOARD (Home)
| Feature | Description | Priority |
|---------|-------------|----------|
| Analytics Overview | Total words, definitions, votes, users, views today/week/month | CRITICAL |
| Live Activity Feed | Real-time stream of submissions, votes, registrations | HIGH |
| Trending Graph | Chart showing velocity trends over time | HIGH |
| Quick Stats Cards | Words pending review, flagged content, new users today | CRITICAL |
| System Health | Cache status, queue jobs, error logs summary | MEDIUM |

#### B. WORDS MANAGEMENT
| Feature | Description | Priority |
|---------|-------------|----------|
| Advanced Data Table | Sortable, filterable, searchable with pagination | CRITICAL |
| Bulk Actions | Select multiple → Delete / Verify / Boost / Change Category | CRITICAL |
| Inline Editing | Click to edit term, category, RFCI without page reload | HIGH |
| Boost Slider | Visual slider 0-10000 with instant save | CRITICAL |
| Merge Duplicates | Select 2+ words → Merge into one (combine definitions) | HIGH |
| Export CSV/Excel | Download all words data | MEDIUM |
| View Analytics | Per-word stats: views, votes over time, traffic sources | MEDIUM |

#### C. DEFINITIONS MANAGEMENT
| Feature | Description | Priority |
|---------|-------------|----------|
| Moderation Queue | New definitions pending approval (if moderation enabled) | HIGH |
| Flag Review | User-reported inappropriate definitions | CRITICAL |
| Edit Any Definition | Admin can edit user-submitted content | CRITICAL |
| Set as Primary | Manually override which definition shows first | HIGH |
| Vote Manipulation | Admin can adjust agree/disagree counts (for testing/fixing) | MEDIUM |
| Definition History | See edit history, who changed what when | LOW |

#### D. USER MANAGEMENT
| Feature | Description | Priority |
|---------|-------------|----------|
| User List | All users with search, sort, filter | CRITICAL |
| User Roles | Admin, Moderator, Trusted Contributor, Regular, Banned | CRITICAL |
| Ban/Suspend User | Temporary or permanent with reason | CRITICAL |
| User Activity | See all submissions, votes, reports by user | HIGH |
| IP Tracking | View IP addresses, detect multi-accounts | MEDIUM |
| Promote to Admin | Grant admin access to trusted users | HIGH |

#### E. CATEGORIES MANAGEMENT
| Feature | Description | Priority |
|---------|-------------|----------|
| CRUD Categories | Add, edit, delete, reorder categories | CRITICAL |
| Category Icons | Upload or select icon for each category | MEDIUM |
| Category Colors | Set brand color per category | MEDIUM |
| Merge Categories | Combine two categories into one | LOW |
| Category Stats | Words count, trending words per category | MEDIUM |

#### F. TRENDING & ALGORITHM CONTROL
| Feature | Description | Priority |
|---------|-------------|----------|
| Algorithm Tuning | Adjust gravity, decay rate, view weight | HIGH |
| Manual Trending | Force words to trending section | CRITICAL |
| Polar Trend Override | Manually set/unset polar trend status | HIGH |
| Blacklist Words | Words that should never trend (offensive, etc.) | CRITICAL |
| Trending Preview | See how algorithm changes affect rankings | MEDIUM |

#### G. CONTENT MODERATION
| Feature | Description | Priority |
|---------|-------------|----------|
| Flagged Content Queue | All user-reported content in one place | CRITICAL |
| Auto-Moderation Rules | Block words containing profanity, spam patterns | HIGH |
| Approval Mode Toggle | Enable/disable pre-approval for new submissions | HIGH |
| Shadow Ban | User's content only visible to them | MEDIUM |
| Audit Log | Who approved/rejected what, when | HIGH |

#### H. LORE TIMELINE MANAGEMENT
| Feature | Description | Priority |
|---------|-------------|----------|
| Add Lore Entries | Form to add timeline events to any word | DONE |
| Edit/Delete Lore | Manage existing entries | HIGH |
| Bulk Import | Upload CSV of lore entries | LOW |
| Verify Sources | Mark lore entries as verified | MEDIUM |

#### I. DOMAIN MONETIZATION (GoDaddy)
| Feature | Description | Priority |
|---------|-------------|----------|
| Affiliate Settings | GoDaddy affiliate ID, commission tracking | HIGH |
| Domain Cache | Store availability results to reduce API calls | MEDIUM |
| Revenue Dashboard | Track clicks, conversions, estimated earnings | MEDIUM |
| Featured Domains | Highlight specific domain opportunities | LOW |

#### J. SETTINGS & CONFIGURATION
| Feature | Description | Priority |
|---------|-------------|----------|
| Site Settings | Site name, tagline, meta descriptions | CRITICAL |
| Feature Toggles | Enable/disable features (voting, submissions, etc.) | HIGH |
| Email Settings | SMTP config for future notifications | LOW |
| API Keys | OpenAI, GoDaddy, analytics keys | MEDIUM |
| Maintenance Mode | Take site offline with custom message | HIGH |
| Backup/Restore | Database backup and restore | MEDIUM |

### 4.2 Admin UI Requirements

```
DESIGN SPECS:
- Dark theme (matches brand navy #002B5B)
- Sidebar navigation with icons
- Responsive (works on tablet)
- Data tables with: search, sort, filter, pagination, bulk select
- Modal confirmations for destructive actions
- Toast notifications for success/error
- Loading states for async operations
```

### 4.3 Tech Stack for Admin

**REQUIRED**: Build with **Livewire 3 + Alpine.js** (same as frontend)

| Why Livewire? |
|---------------|
| Consistent with existing codebase |
| No additional dependencies |
| Full control over UI/UX |
| Matches site design language |
| Team already familiar with it |

**DO NOT USE**: Filament, Nova, Backpack, or any admin package. Build custom with Livewire.

### 4.4 Livewire Components to Create

```
app/Livewire/Admin/
├── Dashboard.php              # Stats cards, charts, activity feed
├── WordsTable.php             # Searchable, sortable, bulk actions
├── WordEditor.php             # Edit word with all fields
├── DefinitionsTable.php       # All definitions with moderation
├── ModerationQueue.php        # Pending/flagged content
├── UsersTable.php             # User list with role management
├── UserEditor.php             # Edit user, ban/unban
├── CategoriesManager.php      # CRUD for categories
├── Settings/
│   ├── GeneralSettings.php    # Site name, tagline, etc.
│   ├── ModerationSettings.php # Auto-mod rules, approval mode
│   └── ApiSettings.php        # API keys (OpenAI, GoDaddy)
├── ActivityLog.php            # Audit trail viewer
└── Components/
    ├── StatsCard.php          # Reusable stat card
    ├── DataTable.php          # Reusable table with search/sort/pagination
    ├── BulkActions.php        # Select all, bulk delete/verify
    └── Toast.php              # Success/error notifications
```

```
resources/views/livewire/admin/
├── dashboard.blade.php
├── words-table.blade.php
├── word-editor.blade.php
├── definitions-table.blade.php
├── moderation-queue.blade.php
├── users-table.blade.php
├── user-editor.blade.php
├── categories-manager.blade.php
├── settings/
│   ├── general.blade.php
│   ├── moderation.blade.php
│   └── api.blade.php
├── activity-log.blade.php
└── components/
    ├── sidebar.blade.php      # Admin navigation
    ├── stats-card.blade.php
    ├── data-table.blade.php
    └── toast.blade.php
```

### 4.5 Admin Routes Structure

```php
// routes/web.php - Add these routes

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('dashboard');

    // Words
    Route::get('/words', \App\Livewire\Admin\WordsTable::class)->name('words');
    Route::get('/words/{word}/edit', \App\Livewire\Admin\WordEditor::class)->name('words.edit');

    // Definitions
    Route::get('/definitions', \App\Livewire\Admin\DefinitionsTable::class)->name('definitions');
    Route::get('/moderation', \App\Livewire\Admin\ModerationQueue::class)->name('moderation');

    // Users
    Route::get('/users', \App\Livewire\Admin\UsersTable::class)->name('users');
    Route::get('/users/{user}/edit', \App\Livewire\Admin\UserEditor::class)->name('users.edit');

    // Categories
    Route::get('/categories', \App\Livewire\Admin\CategoriesManager::class)->name('categories');

    // Settings
    Route::get('/settings', \App\Livewire\Admin\Settings\GeneralSettings::class)->name('settings');
    Route::get('/settings/moderation', \App\Livewire\Admin\Settings\ModerationSettings::class)->name('settings.moderation');
    Route::get('/settings/api', \App\Livewire\Admin\Settings\ApiSettings::class)->name('settings.api');

    // Activity Log
    Route::get('/activity', \App\Livewire\Admin\ActivityLog::class)->name('activity');
});
```

### 4.6 Database Additions Needed

```sql
-- New tables for advanced admin

CREATE TABLE activity_logs (
    id, user_id, action, model_type, model_id,
    old_values (JSON), new_values (JSON), ip_address,
    created_at
);

CREATE TABLE flags (
    id, reporter_id, flaggable_type, flaggable_id,
    reason, status (pending/reviewed/dismissed),
    reviewed_by, reviewed_at, created_at
);

CREATE TABLE categories (
    id, name, slug, icon, color, sort_order,
    words_count, is_active, created_at, updated_at
);

CREATE TABLE settings (
    id, key, value (JSON), group, created_at, updated_at
);

-- Add to users table
ALTER TABLE users ADD COLUMN role ENUM('admin', 'moderator', 'trusted', 'regular', 'banned');
ALTER TABLE users ADD COLUMN banned_at TIMESTAMP NULL;
ALTER TABLE users ADD COLUMN ban_reason TEXT NULL;
```

### 4.5 Admin Routes Structure

```php
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Words
    Route::resource('words', AdminWordController::class);
    Route::post('words/bulk-action', [AdminWordController::class, 'bulkAction']);
    Route::post('words/{word}/merge', [AdminWordController::class, 'merge']);

    // Definitions
    Route::resource('definitions', AdminDefinitionController::class);
    Route::get('moderation-queue', [AdminModerationController::class, 'queue']);
    Route::post('definitions/{definition}/approve', ...);
    Route::post('definitions/{definition}/reject', ...);

    // Users
    Route::resource('users', AdminUserController::class);
    Route::post('users/{user}/ban', [AdminUserController::class, 'ban']);
    Route::post('users/{user}/promote', [AdminUserController::class, 'promote']);

    // Categories
    Route::resource('categories', AdminCategoryController::class);
    Route::post('categories/reorder', [AdminCategoryController::class, 'reorder']);

    // Settings
    Route::get('settings', [AdminSettingsController::class, 'index']);
    Route::post('settings', [AdminSettingsController::class, 'update']);

    // Reports & Analytics
    Route::get('analytics', [AdminAnalyticsController::class, 'index']);
    Route::get('activity-log', [AdminActivityController::class, 'index']);
    Route::get('flags', [AdminFlagController::class, 'index']);
});
```

---

---

## 5. FULL SITE GAPS - BEYOND ADMIN

### 5.1 Frontend Features Missing

| Feature | Location Needed | Priority | Notes |
|---------|-----------------|----------|-------|
| **Word of the Day** | Homepage top | CRITICAL | Client explicitly requested |
| **Lore Timeline Display** | `word/show.blade.php` | CRITICAL | Backend exists, not shown |
| **RFCI Badge on Cards** | `bento-grid.blade.php` | HIGH | Data exists, not displayed |
| **Report/Flag Button** | Word & Definition cards | HIGH | Users can't report bad content |
| **User Profile Page** | New page | HIGH | See own submissions, votes |
| **Edit Own Definition** | `word/show.blade.php` | MEDIUM | Users can't edit their submissions |
| **Delete Own Definition** | `word/show.blade.php` | MEDIUM | Users can't remove their content |
| **Share Buttons** | Word detail page | MEDIUM | Social sharing to TikTok, Twitter |
| **Bookmark/Save Words** | Throughout site | LOW | Save favorites |
| **Dark Mode Toggle** | Header | LOW | User preference |
| **Notification System** | Throughout | LOW | When someone votes on your definition |

### 5.2 Backend/API Features Missing

| Feature | Purpose | Priority |
|---------|---------|----------|
| **Rate Limiting** | Prevent vote spam, submission abuse | CRITICAL |
| **Email Verification** | Optional email for password reset | MEDIUM |
| **Password Reset** | Users locked out forever currently | HIGH |
| **API Endpoints** | Mobile app, third-party integrations | MEDIUM |
| **Scheduled Jobs** | Auto-calculate polar trends, sync views | HIGH |
| **Queue System** | Background processing for velocity calc | MEDIUM |
| **Redis Caching** | Performance at scale | MEDIUM |
| **Soft Deletes** | Recover accidentally deleted content | HIGH |

### 5.3 Database Tables Missing

```sql
-- THESE TABLES DO NOT EXIST YET:

-- 1. Categories (currently hardcoded!)
CREATE TABLE categories (
    id BIGINT PRIMARY KEY,
    name VARCHAR(100),
    slug VARCHAR(100) UNIQUE,
    icon VARCHAR(50),
    color VARCHAR(7),
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- 2. Flags/Reports
CREATE TABLE flags (
    id BIGINT PRIMARY KEY,
    reporter_id BIGINT,           -- User who reported
    flaggable_type VARCHAR(50),   -- 'word' or 'definition'
    flaggable_id BIGINT,
    reason ENUM('spam', 'offensive', 'incorrect', 'duplicate', 'other'),
    details TEXT,
    status ENUM('pending', 'reviewed', 'dismissed') DEFAULT 'pending',
    reviewed_by BIGINT,
    reviewed_at TIMESTAMP,
    created_at TIMESTAMP
);

-- 3. Activity Logs (Audit Trail)
CREATE TABLE activity_logs (
    id BIGINT PRIMARY KEY,
    user_id BIGINT,
    action VARCHAR(50),           -- 'created', 'updated', 'deleted', 'voted'
    model_type VARCHAR(50),
    model_id BIGINT,
    old_values JSON,
    new_values JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP
);

-- 4. Settings (Site Configuration)
CREATE TABLE settings (
    id BIGINT PRIMARY KEY,
    key VARCHAR(100) UNIQUE,
    value JSON,
    group VARCHAR(50),            -- 'general', 'moderation', 'api', etc.
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- 5. Saved/Bookmarks
CREATE TABLE bookmarks (
    id BIGINT PRIMARY KEY,
    user_id BIGINT,
    word_id BIGINT,
    created_at TIMESTAMP,
    UNIQUE(user_id, word_id)
);

-- 6. User Sessions (For "logged in devices")
CREATE TABLE user_sessions (
    id BIGINT PRIMARY KEY,
    user_id BIGINT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    last_active_at TIMESTAMP,
    created_at TIMESTAMP
);
```

### 5.4 User Table Needs These Columns

```sql
ALTER TABLE users ADD COLUMN role ENUM('admin', 'moderator', 'trusted', 'regular', 'banned') DEFAULT 'regular';
ALTER TABLE users ADD COLUMN banned_at TIMESTAMP NULL;
ALTER TABLE users ADD COLUMN ban_reason TEXT NULL;
ALTER TABLE users ADD COLUMN last_active_at TIMESTAMP NULL;
ALTER TABLE users ADD COLUMN avatar VARCHAR(255) NULL;
ALTER TABLE users ADD COLUMN bio TEXT NULL;
ALTER TABLE users ADD COLUMN total_submissions INT DEFAULT 0;
ALTER TABLE users ADD COLUMN total_votes_received INT DEFAULT 0;
ALTER TABLE users ADD COLUMN reputation_score INT DEFAULT 0;
```

### 5.5 Missing Middleware

| Middleware | Purpose | Status |
|------------|---------|--------|
| `throttle:votes` | Limit votes per minute | NOT EXISTS |
| `throttle:submissions` | Limit submissions per hour | NOT EXISTS |
| `banned` | Block banned users | NOT EXISTS |
| `track-activity` | Update last_active_at | NOT EXISTS |

### 5.6 Missing Scheduled Commands

```php
// These should run via Laravel Scheduler (cron)

// Every 5 minutes: Calculate polar trends
$schedule->command('trends:calculate-polar')->everyFiveMinutes();

// Every 10 minutes: Sync view counts from cache to DB
$schedule->command('views:sync-buffer')->everyTenMinutes();

// Every hour: Recalculate all velocity scores
$schedule->command('velocity:recalculate')->hourly();

// Daily: Clean up old activity logs
$schedule->command('logs:cleanup --days=90')->daily();

// Daily: Generate daily stats snapshot
$schedule->command('stats:snapshot')->dailyAt('00:05');
```

---

## 6. Known Issues / Technical Debt

### BUGS

| Issue | Severity | Location | Fix |
|-------|----------|----------|-----|
| Vote counts show inflated numbers | LOW | `welcome.blade.php:132` | Remove `+ rand(1000, 3000)` |
| Missing closing `</section>` tag | LOW | `welcome.blade.php:247` | Add missing tag |
| No CSRF on logout form if not auth | LOW | `welcome.blade.php:17` | Handled by `@auth` |

### TECHNICAL DEBT

| Issue | Impact | Recommendation |
|-------|--------|----------------|
| Direct DB view increment | Performance at scale | Implement Redis buffer strategy |
| No rate limiting on votes | Abuse potential | Add throttle middleware |
| Cookie-based vote persistence | Can be cleared | Consider fingerprinting or IP logging |
| No tests written | Maintainability | Add PHPUnit tests for core services |
| No API endpoints | Future mobile app | Consider Laravel Sanctum API |

### SECURITY CONSIDERATIONS

| Item | Status | Notes |
|------|--------|-------|
| XSS Protection | OK | Blade escapes by default |
| CSRF Protection | OK | Livewire handles automatically |
| SQL Injection | OK | Using Eloquent ORM |
| Rate Limiting | MISSING | Should add to voting/submission |
| Admin Auth | OK | Middleware checks `is_admin` |

---

## 5. Recommendations

### Immediate Actions (Before Milestone Delivery)

1. **Add Word of the Day** - Client explicitly requested this as "unconventional"
   ```php
   // HomeController.php
   $wordOfTheDay = Word::whereDate('created_at', today())
       ->orderByDesc('velocity_score')
       ->first() ?? Word::orderByDesc('velocity_score')->first();
   ```

2. **Display Lore Timeline** - Already built, just needs frontend
   ```blade
   @if($word->lore->count() > 0)
       <div class="lore-timeline">
           @foreach($word->lore as $entry)
               <!-- Timeline entry -->
           @endforeach
       </div>
   @endif
   ```

3. **Show RFCI Badge** - Field exists, add to card UI
   ```blade
   @if($word->rfci_score)
       <span class="rfci-badge">{{ $word->rfci_score }}</span>
   @endif
   ```

4. **Fix Inflated Vote Display** - Remove random number addition
   ```php
   // BEFORE
   {{ number_format((int)$def->agrees + rand(1000, 3000)) }} agreed

   // AFTER
   {{ number_format($def->agrees) }} agreed
   ```

### Architectural Improvements (Phase 2)

1. **Implement Caching Strategy**
   - Cache homepage queries for 2 minutes
   - Use Redis for view counting buffer
   - Cache word detail pages for 5 minutes

2. **Add Event-Driven Architecture**
   - Dispatch events on vote, submission
   - Queue jobs for velocity recalculation
   - Enable real-time updates with Laravel Echo

3. **API Layer**
   - Add `/api/v1/` endpoints for future mobile app
   - Implement rate limiting per IP
   - Add pagination to all list endpoints

4. **Testing**
   - Unit tests for `TrendingService`
   - Feature tests for voting flow
   - Browser tests for Livewire components

---

## 6. Project File Structure

```
tiktokdictionary/
├── app/
│   ├── Http/Controllers/
│   │   ├── HomeController.php      # Homepage data
│   │   ├── WordController.php      # Word CRUD
│   │   ├── AdminController.php     # Admin panel
│   │   └── AuthController.php      # Login/logout
│   ├── Livewire/
│   │   ├── SearchBar.php           # Live search
│   │   ├── SubmitWordForm.php      # Word submission
│   │   ├── VotingCounter.php       # Agree/Disagree
│   │   ├── AddDefinition.php       # Alt definitions
│   │   └── Auth/Login.php, Register.php
│   ├── Models/
│   │   ├── Word.php                # Core model
│   │   ├── Definition.php          # With velocity logic
│   │   ├── LoreEntry.php           # Timeline entries
│   │   └── User.php                # Username auth
│   └── Services/
│       └── TrendingService.php     # Velocity calculations
├── database/migrations/            # 11 migration files
├── resources/views/
│   ├── welcome.blade.php           # Homepage
│   ├── word/show.blade.php         # Word detail
│   ├── word/browse.blade.php       # Browse/filter
│   ├── admin/                      # Admin views
│   ├── auth/                       # Login/register
│   ├── livewire/                   # Livewire components
│   └── components/ui/              # Reusable UI
├── routes/web.php                  # All routes
└── docs/                           # Documentation
    ├── README.md                   # Client brief
    ├── REQUIREMENTS.md             # Detailed specs
    ├── BACKEND_CONCEPT.md          # Technical design
    ├── USER_FLOW.md                # UX flows
    └── PROJECT_STATUS.md           # Progress tracking
```

---

## 7. Quick Reference Commands

```bash
# Clear caches after changes
php artisan cache:clear && php artisan view:clear && php artisan route:clear

# Run migrations
php artisan migrate

# Seed sample data
php artisan db:seed

# Generate Vite assets
npm run build

# Start dev server
php artisan serve
```

---

## 8. Milestone Completion Checklist

### $400 AUD Initial Milestone

- [x] Homepage UI complete
- [x] Submission flow working
- [x] Voting system functional
- [x] Timeframe filtering (Now/Week/Month)
- [x] Duplicate detection
- [x] Admin panel basics
- [x] Documentation folder
- [ ] **Word of the Day section** - NOT DONE
- [ ] **Lore Timeline displayed** - NOT DONE (backend ready)
- [ ] **Domain availability check** - NOT DONE
- [x] Creator-native copy (mostly done)
- [x] Unconventional UI elements

**Estimated Completion**: 3-4 hours of focused work to close remaining gaps.

---

## 9. Contact Points

| Area | File | Line |
|------|------|------|
| Trending algorithm | `Definition.php` | 39-52 |
| Timeframe filter | `Word.php` | 85-104 |
| Vote persistence | `VotingCounter.php` | 32-58 |
| Duplicate check | `SubmitWordForm.php` | 48-52 |
| Admin boost | `AdminController.php` | 27-51 |
| Lore entries | `LoreEntry.php` | Model |

---

## 10. Version History

| Date | Version | Changes |
|------|---------|---------|
| 2026-01-10 | 0.1.0 | Initial audit created |
| 2026-01-10 | 0.2.0 | Fixed Livewire forms, added Facts/Cap labels |
| 2026-01-11 | 0.3.0 | Livewire subdirectory routing fixed by user |
| 2026-01-11 | 0.4.0 | Created claude_architect.md for ongoing tracking |
| 2026-01-11 | 0.5.0 | Added Section 4: Advanced Admin Panel requirements (10 modules) |
| 2026-01-11 | 0.6.0 | Added detailed CURRENT STATE AUDIT showing exact gaps |
| 2026-01-11 | 0.7.0 | Added Section 5: Full Site Gaps (frontend, backend, database, middleware, cron) |
| 2026-01-11 | 0.8.0 | Changed admin tech stack: USE LIVEWIRE (not Filament). Added component structure. |
| 2026-01-11 | 0.9.0 | Added MASTER CHECKLIST comparing readme.md requirements vs current state |
| 2026-01-11 | 1.0.0 | Created TASKS.md - full task board with 21 tasks, step-by-step instructions, claim system |

---

*This document should be read whenever project status is requested. Update the "Last Updated" date and version history when making significant changes.*
