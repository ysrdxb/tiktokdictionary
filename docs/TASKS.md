# TikTokDictionary - AI Task Board

**Last Updated**: 2026-01-12
**Purpose**: Central task management for multiple AI assistants
**Total Tasks**: 39 | **Completed**: 27 | **In Progress**: 0 | **TODO**: 12

> **AI ASSISTANTS**: Read the STRICT RULES section below before starting ANY work!

---

## STRICT RULES FOR AI ASSISTANTS

### MANDATORY - READ BEFORE DOING ANYTHING

```
╔═══════════════════════════════════════════════════════════════════╗
║  STOP! YOU MUST FOLLOW THESE RULES EXACTLY. NO EXCEPTIONS.        ║
╚═══════════════════════════════════════════════════════════════════╝
```

### Rule 1: CLAIM BEFORE CODING
Before writing ANY code:
1. Find a task with `Status: TODO`
2. **IMMEDIATELY** change status to `IN_PROGRESS`
3. Add your identifier to `Claimed By:`
4. Add today's date to `Started:`
5. **ONLY THEN** start coding

### Rule 2: ONE TASK AT A TIME
- Complete ONE task fully before starting another
- Do NOT work on multiple tasks simultaneously
- Do NOT skip steps within a task

### Rule 3: FOLLOW INSTRUCTIONS EXACTLY
- Create ONLY the files listed in "Files To Create/Modify"
- Follow the step-by-step instructions in ORDER
- Use the EXACT code snippets provided
- Do NOT add extra features not in the task
- Do NOT refactor code outside the task scope

### Rule 4: MARK COMPLETE PROPERLY
When task is 100% done:
1. Change `Status: IN_PROGRESS` to `Status: DONE`
2. Add completion date to `Completed:`
3. Check ALL acceptance criteria boxes
4. Add entry to CHANGE LOG at bottom
5. List actual files you created/modified

### Rule 5: RESPECT DEPENDENCIES
- Check "Depends On" field before starting
- If dependency is not DONE, you CANNOT start the task
- Pick a different task with no dependencies

### Rule 6: DO NOT TOUCH OTHER TASKS
- NEVER modify `IN_PROGRESS` tasks (another AI is working)
- NEVER modify `DONE` tasks (already completed)
- NEVER change task descriptions or requirements

### Rule 7: QUALITY STANDARDS
- Test your code before marking complete
- Ensure no PHP/JS errors in console
- Follow existing code style in the project
- Use Livewire 3 syntax (not Livewire 2)
- Use Tailwind CSS classes (no custom CSS unless specified)

### Rule 8: ASK IF UNCLEAR
If instructions are unclear:
- Add a `Notes:` field to the task with your question
- Mark task as `BLOCKED` with reason
- Move to another task

---

## WHAT'S LEFT TO BUILD (SUMMARY)

### COMPLETED (27 Tasks) - DO NOT REDO THESE!
| Task | Feature | Status |
|------|---------|--------|
| TASK-001 to TASK-005 | Database Foundation | DONE - All tables exist |
| TASK-006 | Domain Checker | DONE - GoDaddy affiliate working |
| TASK-007 | RFCI Score Display | DONE - Badge component exists |
| TASK-008 | Lore Timeline | DONE - Displayed on word page |
| TASK-009 | Live View Counter | DONE - Basic version |
| TASK-010 | Report/Flag Button | DONE - ReportModal working |
| TASK-011 | Sticker Generator | DONE - Share component exists |
| TASK-012 to TASK-016 | Admin Panel | DONE - Modern UI with toast notifications, collapsible sidebar |
| TASK-018 | AI Summary | DONE - OpenAI integration |
| TASK-019 | Vertical Feed | DONE - TikTok scroll working |
| TASK-021 | Investor Dashboard | DONE - Component exists |
| TASK-022 | Puter.js Audio | DONE - Listen button working |
| TASK-024 | Search-to-Submit | DONE - Inline form exists |

### REMAINING TASKS (12 TODO)
| Task | Feature | Priority |
|------|---------|----------|
| TASK-017 | Moderation Queue | HIGH - Needs dedicated queue view |
| TASK-020 | Vibe-Check Search | MEDIUM - Partial (vibes in search) |
| TASK-023 | Download Sound Bite | MEDIUM - Audio download feature |
| TASK-025 | Hover Reveal Interactions | LOW |
| TASK-026 | Dark Mode Toggle | MEDIUM - Toggle hidden, needs UI button |
| TASK-027 | Word of the Day | MEDIUM |
| TASK-028 | Rising Stars | MEDIUM |
| TASK-029 | Definition Battle | LOW |
| TASK-030 | User Badges | LOW |
| TASK-031 | Skeleton Loading | HIGH - Better UX |
| TASK-032 | Celebration Animations | LOW |
| TASK-033 | Keyboard Shortcuts | LOW |
| TASK-034 | Mobile Swipe Gestures | MEDIUM |
| TASK-035 | Empty States | MEDIUM |
| TASK-036 | Animated Counters | HIGH - Count up effect |
| TASK-037 | Card Animations | MEDIUM |
| TASK-038 | Input Animations | MEDIUM |
| TASK-039 | Live Notifications | HIGH - Freelancer-style toasts |

---

## TASK STATUS LEGEND

| Status | Meaning | Can Work On? |
|--------|---------|--------------|
| `TODO` | Not started | YES |
| `IN_PROGRESS` | Someone working | NO - DO NOT TOUCH |
| `DONE` | Completed | NO - DO NOT TOUCH |
| `BLOCKED` | Waiting on dependency | NO - Fix dependency first |

---

## PHASE 1: DATABASE FOUNDATION

### TASK-001: Create Categories Table
```
Status: DONE
Priority: CRITICAL
Claimed By: Claude AI
Started: 2026-01-12
Completed: 2026-01-12
```

**What To Build:**
A database table to store categories (currently hardcoded in blade files).

**Step-by-Step:**
1. Create migration:
   ```bash
   php artisan make:migration create_categories_table
   ```

2. Migration schema:
   ```php
   Schema::create('categories', function (Blueprint $table) {
       $table->id();
       $table->string('name', 100);
       $table->string('slug', 100)->unique();
       $table->string('icon', 50)->nullable();        // e.g., 'fire', 'music', 'game'
       $table->string('color', 7)->default('#002B5B'); // hex color
       $table->integer('sort_order')->default(0);
       $table->boolean('is_active')->default(true);
       $table->integer('words_count')->default(0);    // cached count
       $table->timestamps();
   });
   ```

3. Create model:
   ```bash
   php artisan make:model Category
   ```

4. Model file `app/Models/Category.php`:
   ```php
   <?php
   namespace App\Models;

   use Illuminate\Database\Eloquent\Model;
   use Illuminate\Support\Str;

   class Category extends Model
   {
       protected $fillable = [
           'name', 'slug', 'icon', 'color',
           'sort_order', 'is_active', 'words_count'
       ];

       protected $casts = [
           'is_active' => 'boolean',
       ];

       public function words()
       {
           return $this->hasMany(Word::class);
       }

       protected static function booted()
       {
           static::creating(function ($category) {
               if (empty($category->slug)) {
                   $category->slug = Str::slug($category->name);
               }
           });
       }
   }
   ```

5. Create seeder with default categories:
   ```bash
   php artisan make:seeder CategorySeeder
   ```

   ```php
   // database/seeders/CategorySeeder.php
   $categories = [
       ['name' => 'TikTok Trends', 'icon' => 'trending', 'color' => '#fe2c55'],
       ['name' => 'Slang', 'icon' => 'chat', 'color' => '#25f4ee'],
       ['name' => 'Gaming', 'icon' => 'game', 'color' => '#9333ea'],
       ['name' => 'Memes', 'icon' => 'emoji', 'color' => '#f59e0b'],
       ['name' => 'Music', 'icon' => 'music', 'color' => '#10b981'],
       ['name' => 'Fashion', 'icon' => 'shirt', 'color' => '#ec4899'],
       ['name' => 'Internet Culture', 'icon' => 'globe', 'color' => '#3b82f6'],
       ['name' => 'Gen-Z', 'icon' => 'zap', 'color' => '#8b5cf6'],
   ];
   ```

6. Update `Word` model - add relationship:
   ```php
   public function category()
   {
       return $this->belongsTo(Category::class);
   }
   ```

7. Run migration:
   ```bash
   php artisan migrate
   php artisan db:seed --class=CategorySeeder
   ```

**Files To Create/Modify:**
- `database/migrations/xxxx_create_categories_table.php` (CREATE)
- `app/Models/Category.php` (CREATE)
- `database/seeders/CategorySeeder.php` (CREATE)
- `app/Models/Word.php` (MODIFY - add relationship)

**Acceptance Criteria:**
- [ ] Migration runs without errors
- [ ] Category model exists with all methods
- [ ] 8 default categories seeded
- [ ] Word model has category() relationship

---

### TASK-002: Create Flags Table (Report System)
```
Status: DONE
Priority: CRITICAL
Claimed By: Claude AI
Started: 2026-01-12
Completed: 2026-01-12
```

**What To Build:**
Allow users to report inappropriate content.

**Step-by-Step:**
1. Create migration:
   ```bash
   php artisan make:migration create_flags_table
   ```

2. Migration schema:
   ```php
   Schema::create('flags', function (Blueprint $table) {
       $table->id();
       $table->foreignId('reporter_id')->nullable()->constrained('users')->nullOnDelete();
       $table->string('reporter_ip', 45);             // for anonymous reports
       $table->morphs('flaggable');                   // flaggable_type, flaggable_id
       $table->enum('reason', [
           'spam',
           'offensive',
           'incorrect',
           'duplicate',
           'other'
       ]);
       $table->text('details')->nullable();
       $table->enum('status', ['pending', 'reviewed', 'dismissed'])->default('pending');
       $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
       $table->timestamp('reviewed_at')->nullable();
       $table->timestamps();

       $table->index(['flaggable_type', 'flaggable_id']);
       $table->index('status');
   });
   ```

3. Create model `app/Models/Flag.php`:
   ```php
   <?php
   namespace App\Models;

   use Illuminate\Database\Eloquent\Model;

   class Flag extends Model
   {
       protected $fillable = [
           'reporter_id', 'reporter_ip', 'flaggable_type', 'flaggable_id',
           'reason', 'details', 'status', 'reviewed_by', 'reviewed_at'
       ];

       protected $casts = [
           'reviewed_at' => 'datetime',
       ];

       public function flaggable()
       {
           return $this->morphTo();
       }

       public function reporter()
       {
           return $this->belongsTo(User::class, 'reporter_id');
       }

       public function reviewer()
       {
           return $this->belongsTo(User::class, 'reviewed_by');
       }

       public function scopePending($query)
       {
           return $query->where('status', 'pending');
       }
   }
   ```

4. Add trait to Word and Definition models:
   ```php
   // app/Traits/Flaggable.php
   <?php
   namespace App\Traits;

   use App\Models\Flag;

   trait Flaggable
   {
       public function flags()
       {
           return $this->morphMany(Flag::class, 'flaggable');
       }

       public function flag($reason, $details = null, $userId = null)
       {
           return $this->flags()->create([
               'reporter_id' => $userId,
               'reporter_ip' => request()->ip(),
               'reason' => $reason,
               'details' => $details,
           ]);
       }
   }
   ```

5. Add trait to models:
   ```php
   // In Word.php and Definition.php
   use App\Traits\Flaggable;

   class Word extends Model
   {
       use Flaggable;
       // ...
   }
   ```

**Files To Create/Modify:**
- `database/migrations/xxxx_create_flags_table.php` (CREATE)
- `app/Models/Flag.php` (CREATE)
- `app/Traits/Flaggable.php` (CREATE)
- `app/Models/Word.php` (MODIFY - add trait)
- `app/Models/Definition.php` (MODIFY - add trait)

**Acceptance Criteria:**
- [ ] Migration runs without errors
- [ ] Flag model with relationships
- [ ] Flaggable trait created
- [ ] Word and Definition can be flagged

---

### TASK-043: Flag Button (Report Functionality)
```
Status: DONE
Priority: LOW
Claimed By: Claude AI
Started: 2026-01-12
Completed: 2026-01-12
```

### TASK-003: Create Activity Logs Table
```
Status: DONE
Priority: HIGH
Claimed By: Claude AI
Started: 2026-01-12
Completed: 2026-01-12
```

**What To Build:**
Audit trail for admin to see all actions.

**Step-by-Step:**
1. Create migration:
   ```bash
   php artisan make:migration create_activity_logs_table
   ```

2. Migration schema:
   ```php
   Schema::create('activity_logs', function (Blueprint $table) {
       $table->id();
       $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
       $table->string('action', 50);                  // created, updated, deleted, voted, etc.
       $table->string('model_type', 100);             // App\Models\Word
       $table->unsignedBigInteger('model_id');
       $table->json('old_values')->nullable();
       $table->json('new_values')->nullable();
       $table->string('ip_address', 45);
       $table->text('user_agent')->nullable();
       $table->timestamps();

       $table->index(['model_type', 'model_id']);
       $table->index('user_id');
       $table->index('created_at');
   });
   ```

3. Create model and service - see full implementation in TASK-003-DETAILS.md

**Files To Create/Modify:**
- `database/migrations/xxxx_create_activity_logs_table.php` (CREATE)
- `app/Models/ActivityLog.php` (CREATE)
- `app/Services/ActivityLogger.php` (CREATE)

**Acceptance Criteria:**
- [ ] Migration runs
- [ ] ActivityLog model exists
- [ ] Can log activities from anywhere in app

---

### TASK-004: Create Settings Table
```
Status: DONE
Priority: HIGH
Claimed By: Claude AI
Started: 2026-01-12
Completed: 2026-01-12
```

**What To Build:**
Site configuration stored in database.

**Step-by-Step:**
1. Create migration:
   ```php
   Schema::create('settings', function (Blueprint $table) {
       $table->id();
       $table->string('key', 100)->unique();
       $table->json('value')->nullable();
       $table->string('group', 50)->default('general'); // general, moderation, api, appearance
       $table->string('type', 20)->default('string');   // string, boolean, integer, json
       $table->timestamps();

       $table->index('group');
   });
   ```

2. Create Settings model with helper methods:
   ```php
   // app/Models/Setting.php
   class Setting extends Model
   {
       protected $fillable = ['key', 'value', 'group', 'type'];

       protected $casts = [
           'value' => 'json',
       ];

       public static function get($key, $default = null)
       {
           $setting = static::where('key', $key)->first();
           return $setting ? $setting->value : $default;
       }

       public static function set($key, $value, $group = 'general')
       {
           return static::updateOrCreate(
               ['key' => $key],
               ['value' => $value, 'group' => $group]
           );
       }
   }
   ```

3. Create seeder with default settings:
   ```php
   $settings = [
       ['key' => 'site_name', 'value' => 'TikTokDictionary', 'group' => 'general'],
       ['key' => 'site_tagline', 'value' => 'The Internet\'s Language, Decoded', 'group' => 'general'],
       ['key' => 'moderation_enabled', 'value' => false, 'group' => 'moderation'],
       ['key' => 'auto_approve_trusted', 'value' => true, 'group' => 'moderation'],
       ['key' => 'godaddy_affiliate_id', 'value' => '', 'group' => 'api'],
       ['key' => 'openai_api_key', 'value' => '', 'group' => 'api'],
   ];
   ```

**Files To Create/Modify:**
- `database/migrations/xxxx_create_settings_table.php` (CREATE)
- `app/Models/Setting.php` (CREATE)
- `database/seeders/SettingsSeeder.php` (CREATE)

**Acceptance Criteria:**
- [ ] Migration runs
- [ ] Setting::get() and Setting::set() work
- [ ] Default settings seeded

---

### TASK-005: Update Users Table
```
Status: DONE
Priority: CRITICAL
Claimed By: Claude AI
Started: 2026-01-12
Completed: 2026-01-12
```

**What To Build:**
Add role system, ban functionality, and profile fields.

**Step-by-Step:**
1. Create migration:
   ```bash
   php artisan make:migration add_profile_fields_to_users_table
   ```

2. Migration:
   ```php
   Schema::table('users', function (Blueprint $table) {
       $table->enum('role', ['admin', 'moderator', 'trusted', 'regular', 'banned'])
             ->default('regular')->after('is_admin');
       $table->timestamp('banned_at')->nullable()->after('role');
       $table->text('ban_reason')->nullable()->after('banned_at');
       $table->string('avatar', 255)->nullable()->after('ban_reason');
       $table->text('bio')->nullable()->after('avatar');
       $table->integer('total_submissions')->default(0)->after('bio');
       $table->integer('total_votes_received')->default(0)->after('total_submissions');
       $table->integer('reputation_score')->default(0)->after('total_votes_received');
       $table->timestamp('last_active_at')->nullable()->after('reputation_score');
   });
   ```

3. Update User model:
   ```php
   protected $fillable = [
       'name', 'username', 'email', 'password',
       'role', 'banned_at', 'ban_reason', 'avatar', 'bio',
       'total_submissions', 'total_votes_received', 'reputation_score', 'last_active_at'
   ];

   protected $casts = [
       // ... existing casts
       'banned_at' => 'datetime',
       'last_active_at' => 'datetime',
   ];

   public function isBanned(): bool
   {
       return $this->role === 'banned' || $this->banned_at !== null;
   }

   public function isAdmin(): bool
   {
       return $this->role === 'admin' || $this->is_admin;
   }

   public function isModerator(): bool
   {
       return in_array($this->role, ['admin', 'moderator']);
   }

   public function ban($reason = null): void
   {
       $this->update([
           'role' => 'banned',
           'banned_at' => now(),
           'ban_reason' => $reason,
       ]);
   }

   public function unban(): void
   {
       $this->update([
           'role' => 'regular',
           'banned_at' => null,
           'ban_reason' => null,
       ]);
   }
   ```

4. Create CheckBanned middleware:
   ```php
   // app/Http/Middleware/CheckBanned.php
   public function handle($request, Closure $next)
   {
       if (auth()->check() && auth()->user()->isBanned()) {
           auth()->logout();
           return redirect()->route('login')
               ->with('error', 'Your account has been suspended.');
       }
       return $next($request);
   }
   ```

5. Register middleware in bootstrap/app.php

**Files To Create/Modify:**
- `database/migrations/xxxx_add_profile_fields_to_users_table.php` (CREATE)
- `app/Models/User.php` (MODIFY)
- `app/Http/Middleware/CheckBanned.php` (CREATE)
- `bootstrap/app.php` (MODIFY)

**Acceptance Criteria:**
- [ ] Migration runs
- [ ] User has role, ban methods
- [ ] Banned users redirected on login

---

## PHASE 2: FRONTEND FEATURES

### TASK-006: Domain Availability Checker
```
Status: DONE
Priority: CRITICAL (MONETIZATION)
Claimed By: Claude AI
Started: 2026-01-12
Completed: 2026-01-12
```

**What To Build:**
Show domain availability on word pages with GoDaddy affiliate link.

**Step-by-Step:**
1. Create Livewire component:
   ```bash
   php artisan make:livewire DomainChecker
   ```

2. Component `app/Livewire/DomainChecker.php`:
   ```php
   <?php
   namespace App\Livewire;

   use Livewire\Component;

   class DomainChecker extends Component
   {
       public $word;
       public $isChecking = false;
       public $isAvailable = null;
       public $showDetails = false;

       public function mount($word)
       {
           $this->word = $word;
       }

       public function checkAvailability()
       {
           $this->isChecking = true;

           // Simulate check (1.5s delay for UX)
           // In production, could use GoDaddy API or WHOIS
           sleep(1);

           // Simple mock logic - shorter words more likely taken
           $this->isAvailable = strlen($this->word) > 5;
           $this->isChecking = false;
           $this->showDetails = true;
       }

       public function getAffiliateUrl()
       {
           $affiliateId = \App\Models\Setting::get('godaddy_affiliate_id', 'default');
           $domain = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $this->word));
           return "https://www.godaddy.com/domainsearch/find?checkAvail=1&domainToCheck={$domain}.com&isc={$affiliateId}";
       }

       public function render()
       {
           return view('livewire.domain-checker');
       }
   }
   ```

3. Create view `resources/views/livewire/domain-checker.blade.php`:
   ```blade
   <div class="bg-gradient-to-br from-[#002B5B] to-[#001a3a] rounded-2xl p-6 text-white">
       <h3 class="text-lg font-bold mb-2">
           Get "{{ $word }}.com" For Your Business
       </h3>

       @if(!$showDetails)
           <button
               wire:click="checkAvailability"
               wire:loading.attr="disabled"
               class="w-full py-3 bg-white text-[#002B5B] font-bold rounded-xl hover:bg-slate-100 transition flex items-center justify-center gap-2"
           >
               <span wire:loading.remove wire:target="checkAvailability">
                   Check Domain Availability
               </span>
               <span wire:loading wire:target="checkAvailability">
                   <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                       <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                       <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                   </svg>
                   Checking...
               </span>
           </button>
       @else
           @if($isAvailable)
               <div class="bg-emerald-500/20 border border-emerald-400 rounded-xl p-4 mb-4">
                   <div class="flex items-center gap-2 text-emerald-300 font-bold">
                       <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                           <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                       </svg>
                       {{ $word }}.com is Available!
                   </div>
               </div>

               <a href="{{ $this->getAffiliateUrl() }}"
                  target="_blank"
                  class="block w-full py-3 bg-emerald-500 text-white font-bold rounded-xl hover:bg-emerald-600 transition text-center">
                   Get This Domain
               </a>
           @else
               <div class="bg-red-500/20 border border-red-400 rounded-xl p-4 mb-4">
                   <div class="text-red-300 font-bold">
                       {{ $word }}.com is Taken
                   </div>
               </div>

               <a href="{{ $this->getAffiliateUrl() }}"
                  target="_blank"
                  class="block w-full py-3 bg-white/20 text-white font-bold rounded-xl hover:bg-white/30 transition text-center">
                   Check Other Extensions
               </a>
           @endif

           <div class="mt-4 text-xs text-white/60 space-y-2">
               <p><strong>Why get this domain?</strong></p>
               <ul class="list-disc list-inside space-y-1">
                   <li>Built-in traffic from search terms</li>
                   <li>Instant brand credibility</li>
                   <li>Easy to remember and share</li>
                   <li>Domains appreciate in value</li>
               </ul>
               <p class="mt-3 text-[10px] text-white/40">
                   Affiliate Disclosure: We earn a commission from GoDaddy if you purchase.
               </p>
           </div>
       @endif
   </div>
   ```

4. Add to word/show.blade.php:
   ```blade
   <!-- After definitions section -->
   <div class="mt-8">
       @livewire('domain-checker', ['word' => $word->term])
   </div>
   ```

**Files To Create/Modify:**
- `app/Livewire/DomainChecker.php` (CREATE)
- `resources/views/livewire/domain-checker.blade.php` (CREATE)
- `resources/views/word/show.blade.php` (MODIFY - add component)

**Acceptance Criteria:**
- [ ] Component renders on word page
- [ ] Check button shows loading state
- [ ] Available/Taken result displays
- [ ] Affiliate link works
- [ ] Disclaimer shown

---

### TASK-007: RFCI Score Display
```
Status: DONE
Priority: HIGH
Claimed By: Claude AI
Started: 2026-01-12
Completed: 2026-01-12
```

**What To Build:**
Show RFCI score badge on word cards and detail page.

**Step-by-Step:**
1. Create badge component `resources/views/components/ui/rfci-badge.blade.php`:
   ```blade
   @props(['score'])

   @if($score)
       @php
           $letter = substr($score, -1);
           $number = substr($score, 0, -1);
           $colors = [
               'A' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
               'B' => 'bg-blue-100 text-blue-700 border-blue-200',
               'C' => 'bg-amber-100 text-amber-700 border-amber-200',
               'D' => 'bg-red-100 text-red-700 border-red-200',
           ];
           $colorClass = $colors[$letter] ?? 'bg-slate-100 text-slate-700 border-slate-200';
       @endphp

       <div class="inline-flex items-center gap-1 px-2 py-1 rounded-lg border {{ $colorClass }} text-xs font-bold" title="RFCI Score">
           <span>{{ $number }}</span>
           <span class="opacity-75">{{ $letter }}</span>
       </div>
   @endif
   ```

2. Add to bento-grid.blade.php cards:
   ```blade
   @if($word->rfci_score)
       <x-ui.rfci-badge :score="$word->rfci_score" />
   @endif
   ```

3. Add to word/show.blade.php header:
   ```blade
   <div class="flex items-center gap-3">
       <h1>{{ $word->term }}</h1>
       <x-ui.rfci-badge :score="$word->rfci_score" />
   </div>
   ```

**Files To Create/Modify:**
- `resources/views/components/ui/rfci-badge.blade.php` (CREATE)
- `resources/views/components/ui/bento-grid.blade.php` (MODIFY)
- `resources/views/word/show.blade.php` (MODIFY)

**Acceptance Criteria:**
- [ ] Badge renders with correct colors per grade
- [ ] Shows on bento grid cards
- [ ] Shows on word detail page

---

### TASK-008: Lore Timeline Display
```
Status: IN_PROGRESS
Priority: HIGH
Claimed By: Claude AI
Started: 2026-01-12
Completed: -
```

**What To Build:**
Show word origin timeline on detail page.

**Step-by-Step:**
1. Create component `resources/views/components/lore-timeline.blade.php`:
   ```blade
   @props(['entries'])

   @if($entries->count() > 0)
   <div class="bg-white rounded-2xl border border-slate-200 p-6">
       <h3 class="text-xl font-bold text-[#002B5B] mb-6 flex items-center gap-2">
           <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
           </svg>
           Origin Timeline
       </h3>

       <div class="relative">
           <!-- Timeline line -->
           <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-slate-200"></div>

           <div class="space-y-6">
               @foreach($entries as $entry)
               <div class="relative pl-10">
                   <!-- Dot -->
                   <div class="absolute left-2.5 top-1.5 w-3 h-3 rounded-full bg-[#002B5B] border-2 border-white"></div>

                   <!-- Content -->
                   <div>
                       <div class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">
                           {{ $entry->date_event->format('M d, Y') }}
                       </div>
                       <h4 class="font-bold text-[#002B5B]">{{ $entry->title }}</h4>
                       <p class="text-slate-600 text-sm mt-1">{{ $entry->description }}</p>
                       @if($entry->source_url)
                           <a href="{{ $entry->source_url }}" target="_blank"
                              class="inline-flex items-center gap-1 text-xs text-blue-600 hover:underline mt-2">
                               <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                               </svg>
                               View Source
                           </a>
                       @endif
                   </div>
               </div>
               @endforeach
           </div>
       </div>
   </div>
   @endif
   ```

2. Add to word/show.blade.php:
   ```blade
   <!-- After definitions, before domain checker -->
   <x-lore-timeline :entries="$word->lore" />
   ```

3. Ensure WordController loads lore:
   ```php
   public function show($slug)
   {
       $word = Word::with(['definitions', 'lore', 'primaryDefinition'])
           ->where('slug', $slug)
           ->firstOrFail();
       // ...
   }
   ```

**Files To Create/Modify:**
- `resources/views/components/lore-timeline.blade.php` (CREATE)
- `resources/views/word/show.blade.php` (MODIFY)
- `app/Http/Controllers/WordController.php` (MODIFY if needed)

**Acceptance Criteria:**
- [ ] Timeline renders with entries
- [ ] Dates formatted correctly
- [ ] Source links work
- [ ] Empty state handled (no timeline if no entries)

---

### TASK-009: Live View Counter with wire:poll
```
Status: DONE
Priority: HIGH
Claimed By: Claude AI
Started: 2026-01-12
Completed: 2026-01-12
```

**What To Build:**
Real-time view counter with pulsing animation.

**Step-by-Step:**
1. Create Livewire component:
   ```bash
   php artisan make:livewire LiveViewCounter
   ```

2. Component `app/Livewire/LiveViewCounter.php`:
   ```php
   <?php
   namespace App\Livewire;

   use Livewire\Component;
   use App\Models\Word;

   class LiveViewCounter extends Component
   {
       public $wordId;
       public $views;
       public $isPolarTrend = false;

       public function mount($wordId)
       {
           $this->wordId = $wordId;
           $this->refreshViews();

           // Increment view on mount
           Word::where('id', $wordId)->increment('views');
       }

       public function refreshViews()
       {
           $word = Word::find($this->wordId);
           if ($word) {
               $this->views = $word->views;
               $this->isPolarTrend = $word->is_polar_trend;
           }
       }

       public function render()
       {
           return view('livewire.live-view-counter');
       }
   }
   ```

3. View `resources/views/livewire/live-view-counter.blade.php`:
   ```blade
   <div wire:poll.5s="refreshViews" class="flex items-center gap-2">
       <!-- Pulsing green dot -->
       <span class="relative flex h-2.5 w-2.5">
           <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
           <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
       </span>

       <span class="text-sm font-bold text-slate-600">
           {{ number_format($views) }} views
       </span>

       @if($isPolarTrend)
           <span class="px-2 py-0.5 bg-cyan-100 text-cyan-700 text-xs font-bold rounded-full animate-pulse">
               Possible Polar Trend
           </span>
       @endif
   </div>
   ```

4. Add to word cards and detail page

**Files To Create/Modify:**
- `app/Livewire/LiveViewCounter.php` (CREATE)
- `resources/views/livewire/live-view-counter.blade.php` (CREATE)
- `resources/views/word/show.blade.php` (MODIFY)
- `resources/views/components/ui/bento-grid.blade.php` (MODIFY)

**Acceptance Criteria:**
- [ ] View count updates every 5 seconds
- [ ] Green dot pulses
- [ ] Polar trend badge shows when applicable
- [ ] Views increment on page load

---

### TASK-010: Report/Flag Button
```
Status: TODO
Priority: HIGH
Claimed By: -
Started: -
Completed: -
Depends On: TASK-002 (Flags table must exist)
```

**What To Build:**
Button for users to report inappropriate content.

**Step-by-Step:**
1. Create Livewire component:
   ```bash
   php artisan make:livewire FlagButton
   ```

2. Component with modal for selecting reason
3. Save to flags table
4. Show success message
5. Add to word cards and definition cards

**Files To Create/Modify:**
- `app/Livewire/FlagButton.php` (CREATE)
- `resources/views/livewire/flag-button.blade.php` (CREATE)
- Word/definition card views (MODIFY)

**Acceptance Criteria:**
- [ ] Button opens modal
- [ ] User can select reason
- [ ] Flag saved to database
- [ ] Success message shown
- [ ] Rate limited (1 flag per item per user)

---

### TASK-011: Slang-to-Sticker Generator
```
Status: TODO
Priority: MEDIUM
Claimed By: -
Started: -
Completed: -
```

**What To Build:**
Generate shareable image of word definition.

**Step-by-Step:**
1. Install html2canvas via npm:
   ```bash
   npm install html2canvas
   ```

2. Create Alpine component for generating image
3. Style a "sticker" template (vertical for stories)
4. Download button and share to socials

**Files To Create/Modify:**
- `resources/js/sticker-generator.js` (CREATE)
- `resources/views/components/sticker-template.blade.php` (CREATE)
- `resources/views/word/show.blade.php` (MODIFY)

**Acceptance Criteria:**
- [ ] Generates PNG image
- [ ] Vertical format (9:16 ratio)
- [ ] Includes word, definition, site branding
- [ ] Download works
- [ ] Share buttons for IG/TikTok

---

## PHASE 3: ADMIN PANEL (LIVEWIRE)

### TASK-012: Admin Dashboard Component
```
Status: DONE
Priority: CRITICAL
Claimed By: Claude AI
Started: 2026-01-12
Completed: 2026-01-12
Depends On: TASK-001, TASK-002, TASK-003
```

**What To Build:**
Main admin dashboard with stats and activity feed.

[Detailed specs in Section 4 of claude_architect.md]

**Implementation Notes (2026-01-12):**
- Dashboard with stat cards (gradient backgrounds, hover effects)
- Recent submissions table with status badges
- Quick actions panel with links to all admin sections
- Site status indicators (Database, Cache, Queue)
- Toast notification system integrated
- Collapsible sidebar with mobile overlay
- Modern dark theme with consistent styling

---

### TASK-013: Admin Words Table Component
```
Status: DONE
Priority: CRITICAL
Claimed By: Claude AI
Started: 2026-01-12
Completed: 2026-01-12
```

**What To Build:**
Searchable, sortable words table with bulk actions.

[Detailed specs in Section 4 of claude_architect.md]

**Implementation Notes (2026-01-12):**
- Full CRUD with search & filter by status
- Bulk actions (verify, delete)
- Toggle verification and polar trend status
- Sortable columns (term, category, views, viral score)
- Consistent header with gradient icon
- Toast notifications on actions

---

### TASK-014: Admin Users Table Component
```
Status: DONE
Priority: CRITICAL
Claimed By: Claude AI
Started: 2026-01-12
Completed: 2026-01-12
Depends On: TASK-005
```

**What To Build:**
User management with roles and ban functionality.

[Detailed specs in Section 4 of claude_architect.md]

**Implementation Notes (2026-01-12):**
- User listing with search and role filter
- Role management (admin/moderator/regular)
- Ban/unban functionality
- Role badges with color coding
- Consistent header with gradient icon

---

### TASK-015: Admin Categories Manager
```
Status: DONE
Priority: HIGH
Claimed By: Claude AI
Started: 2026-01-12
Completed: 2026-01-12
Depends On: TASK-001
```

**What To Build:**
CRUD interface for categories.

[Detailed specs in Section 4 of claude_architect.md]

**Implementation Notes (2026-01-12):**
- Create/Edit/Delete categories
- Color picker with hex input
- Optional icon field
- Table with color preview
- Consistent header with gradient icon

---

### TASK-016: Admin Settings Page
```
Status: DONE
Priority: HIGH
Claimed By: Claude AI
Started: 2026-01-12
Completed: 2026-01-12
Depends On: TASK-004
```

**What To Build:**
Site settings management interface.

[Detailed specs in Section 4 of claude_architect.md]

**Implementation Notes (2026-01-12):**
- Tabbed interface (General, Moderation, API Keys)
- Site name, tagline configuration
- Maintenance mode toggle
- Allow submissions toggle
- Consistent header with gradient icon

---

### TASK-017: Admin Moderation Queue
```
Status: TODO
Priority: HIGH
Claimed By: -
Started: -
Completed: -
Depends On: TASK-002
```

**What To Build:**
Queue for reviewing flagged content.

[Detailed specs in Section 4 of claude_architect.md]

---

## PHASE 4: ADVANCED FEATURES

### TASK-018: AI Combined Summary (OpenAI)
```
Status: TODO
Priority: MEDIUM
Claimed By: -
Started: -
Completed: -
```

**What To Build:**
AI-generated summary at top of word detail page combining all definitions.

**Step-by-Step:**
1. Add OpenAI API key to settings table
2. Create service `app/Services/OpenAIService.php`:
   ```php
   <?php
   namespace App\Services;

   use Illuminate\Support\Facades\Http;
   use App\Models\Setting;

   class OpenAIService
   {
       public static function generateSummary(string $word, array $definitions): ?string
       {
           $apiKey = Setting::get('openai_api_key');
           if (!$apiKey) return null;

           $definitionsText = collect($definitions)
               ->pluck('definition')
               ->implode("\n- ");

           $response = Http::withHeaders([
               'Authorization' => "Bearer {$apiKey}",
               'Content-Type' => 'application/json',
           ])->post('https://api.openai.com/v1/chat/completions', [
               'model' => 'gpt-3.5-turbo',
               'messages' => [
                   [
                       'role' => 'system',
                       'content' => 'You are a Gen-Z slang expert. Summarize these crowd-sourced definitions into one clear, fun explanation. Keep it under 100 words. Use casual language.'
                   ],
                   [
                       'role' => 'user',
                       'content' => "Word: {$word}\n\nDefinitions:\n- {$definitionsText}"
                   ]
               ],
               'max_tokens' => 150,
           ]);

           return $response->json('choices.0.message.content');
       }
   }
   ```

3. Create Livewire component `AISummary.php`:
   ```php
   <?php
   namespace App\Livewire;

   use Livewire\Component;
   use App\Services\OpenAIService;

   class AISummary extends Component
   {
       public $wordId;
       public $wordTerm;
       public $definitions;
       public $summary = null;
       public $isLoading = false;
       public $hasGenerated = false;

       public function mount($word)
       {
           $this->wordId = $word->id;
           $this->wordTerm = $word->term;
           $this->definitions = $word->definitions->toArray();
       }

       public function generateSummary()
       {
           $this->isLoading = true;
           $this->summary = OpenAIService::generateSummary(
               $this->wordTerm,
               $this->definitions
           );
           $this->isLoading = false;
           $this->hasGenerated = true;
       }

       public function render()
       {
           return view('livewire.ai-summary');
       }
   }
   ```

4. Create view `resources/views/livewire/ai-summary.blade.php`:
   ```blade
   <div class="bg-gradient-to-r from-purple-500/10 to-pink-500/10 border border-purple-200 rounded-2xl p-6 mb-6">
       <div class="flex items-center gap-2 mb-3">
           <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
               <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z"/>
           </svg>
           <h3 class="font-bold text-purple-800">AI-Powered Summary</h3>
       </div>

       @if($summary)
           <p class="text-slate-700 leading-relaxed">{{ $summary }}</p>
       @elseif($isLoading)
           <div class="flex items-center gap-2 text-purple-600">
               <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24">
                   <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                   <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
               </svg>
               Generating summary...
           </div>
       @else
           <button wire:click="generateSummary" class="text-purple-600 font-bold hover:underline">
               Generate AI Summary
           </button>
       @endif
   </div>
   ```

5. Add to word/show.blade.php at top of definitions section

**Files To Create/Modify:**
- `app/Services/OpenAIService.php` (CREATE)
- `app/Livewire/AISummary.php` (CREATE)
- `resources/views/livewire/ai-summary.blade.php` (CREATE)
- `resources/views/word/show.blade.php` (MODIFY)

**Acceptance Criteria:**
- [ ] Service calls OpenAI API
- [ ] Summary generates on button click
- [ ] Loading state shown
- [ ] Summary displayed in styled box
- [ ] Works when API key is set in settings

---

### TASK-019: Vertical Feed (TikTok Scroll)
```
Status: IN_PROGRESS
Priority: MEDIUM
Claimed By: External AI
Started: 2026-01-11
Completed: -
Notes: Building fullscreen /feed route with snap scroll
```

---

### TASK-020: Vibe-Check Search
```
Status: TODO
Priority: LOW
Claimed By: -
Started: -
Completed: -
```

**What To Build:**
Search by emotion/vibe tags assigned by AI.

**Step-by-Step:**
1. Add `vibes` JSON column to words table (already exists)
2. On word submission, call OpenAI to assign 3 vibe tags:
   ```php
   // Example vibes: ['funny', 'sarcastic', 'relatable']
   ```
3. Create vibe search endpoint that queries words by vibe tags
4. Add vibe filter chips to search/browse page
5. Display vibe tags on word cards

**Files To Create/Modify:**
- `app/Services/OpenAIService.php` (MODIFY - add assignVibes method)
- `app/Livewire/SubmitWordForm.php` (MODIFY - call vibe assignment)
- `app/Livewire/SearchBar.php` (MODIFY - add vibe filter)
- Word card views (MODIFY - show vibe tags)

**Acceptance Criteria:**
- [ ] Vibes assigned on submission
- [ ] Can filter/search by vibe
- [ ] Vibe tags displayed on cards

---

### TASK-021: Investor Dashboard
```
Status: TODO
Priority: LOW
Claimed By: -
Started: -
Completed: -
Depends On: TASK-006 (Domain Checker)
```

**What To Build:**
Page showing trending words with available .com domains.

**Step-by-Step:**
1. Create route `/invest` or `/domains`
2. Create Livewire component `InvestorDashboard.php`
3. Query top trending words
4. Check domain availability for each (cached)
5. Display grid with:
   - Word + definition
   - Velocity score
   - Domain status (available/taken)
   - "Get This Domain" affiliate link
6. Filter by: Available Only, Price Range, Category

**Files To Create/Modify:**
- `app/Livewire/InvestorDashboard.php` (CREATE)
- `resources/views/livewire/investor-dashboard.blade.php` (CREATE)
- `routes/web.php` (MODIFY)

**Acceptance Criteria:**
- [ ] Page shows trending words with domain status
- [ ] Filter for available domains only
- [ ] Affiliate links work
- [ ] Investment opportunity badges

---

### TASK-022: Puter.js Audio - Listen Button
```
Status: TODO
Priority: HIGH
Claimed By: -
Started: -
Completed: -
```

**What To Build:**
Text-to-speech "Listen" button on word cards using Puter.js AI voice.

**Step-by-Step:**
1. Add Puter.js script to layout `resources/views/components/layouts/app.blade.php`:
   ```html
   <!-- Before @livewireScripts -->
   <script src="https://js.puter.com/v2/"></script>
   ```

2. Create Alpine component for audio playback. Add to word cards:
   ```blade
   <div x-data="{
       playing: false,
       async playAudio(text) {
           this.playing = true;
           try {
               const audio = await puter.ai.txt2speech(text, {
                   voice: 'nova',
                   speed: 1.1
               });
               audio.onended = () => { this.playing = false; };
               audio.play();
           } catch (error) {
               console.error('Audio failed:', error);
               this.playing = false;
           }
       }
   }">
       <button
           @click="playAudio('{{ $word->term }}: {{ $word->primaryDefinition->definition ?? '' }}')"
           :class="playing ? 'bg-pink-500 animate-pulse' : 'bg-zinc-800 hover:bg-zinc-700'"
           class="flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold text-white transition"
       >
           <svg x-show="!playing" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
               <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
           </svg>
           <svg x-show="playing" class="w-4 h-4 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
               <path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z"/>
           </svg>
           <span x-text="playing ? 'Playing...' : 'Listen'"></span>
       </button>
   </div>
   ```

3. Add to these locations:
   - Bento grid word cards
   - Word detail page header
   - Vertical feed cards

**Files To Create/Modify:**
- `resources/views/components/layouts/app.blade.php` (MODIFY - add Puter.js script)
- `resources/views/components/ui/bento-grid.blade.php` (MODIFY - add listen button)
- `resources/views/word/show.blade.php` (MODIFY - add listen button)
- `resources/views/livewire/vertical-feed.blade.php` (MODIFY - if exists)

**Acceptance Criteria:**
- [ ] Puter.js script loads in layout
- [ ] Listen button on word cards
- [ ] Audio plays with 'nova' voice
- [ ] Button shows playing state with animation
- [ ] Works on mobile browsers

---

### TASK-023: Puter.js Audio - Download Sound Bite
```
Status: TODO
Priority: MEDIUM
Claimed By: -
Started: -
Completed: -
Depends On: TASK-022
```

**What To Build:**
Download audio as MP3 for TikTok creators.

**Step-by-Step:**
1. Add download function to Alpine component:
   ```javascript
   async downloadAudio(text, filename) {
       try {
           const audio = await puter.ai.txt2speech(text, { voice: 'nova' });
           const link = document.createElement('a');
           link.href = audio.src;
           link.download = `${filename}-tiktokdictionary.mp3`;
           document.body.appendChild(link);
           link.click();
           document.body.removeChild(link);
       } catch (error) {
           console.error('Download failed:', error);
       }
   }
   ```

2. Add download button next to listen button:
   ```blade
   <button
       @click="downloadAudio('{{ $word->term }}: {{ $definition }}', '{{ Str::slug($word->term) }}')"
       class="flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white transition"
   >
       <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
       </svg>
       Download
   </button>
   ```

3. Add to word detail page

**Files To Create/Modify:**
- `resources/views/word/show.blade.php` (MODIFY)
- `resources/views/components/ui/audio-buttons.blade.php` (CREATE - reusable component)

**Acceptance Criteria:**
- [ ] Download button appears on word page
- [ ] Clicking downloads MP3 file
- [ ] Filename includes word slug
- [ ] Works on desktop and mobile

---

### TASK-024: Search-to-Submit Inline Form
```
Status: TODO
Priority: HIGH
Claimed By: -
Started: -
Completed: -
```

**What To Build:**
When search returns no results, the search bar morphs into a submission form inline.

**Step-by-Step:**
1. Update `app/Livewire/SearchBar.php`:
   ```php
   public $noResults = false;
   public $showInlineSubmit = false;

   public function updatedQuery()
   {
       // ... existing search logic

       if ($this->query && $this->results->isEmpty()) {
           $this->noResults = true;
       } else {
           $this->noResults = false;
       }
   }

   public function showSubmitForm()
   {
       $this->showInlineSubmit = true;
   }
   ```

2. Update search bar view to show inline form:
   ```blade
   @if($noResults && !$showInlineSubmit)
       <div class="p-4 text-center">
           <p class="text-slate-600 mb-3">No results for "{{ $query }}"</p>
           <button wire:click="showSubmitForm" class="px-4 py-2 bg-[#002B5B] text-white font-bold rounded-full">
               Be the first to define "{{ $query }}"
           </button>
       </div>
   @endif

   @if($showInlineSubmit)
       <div class="p-4 border-t">
           @livewire('submit-word-form', ['word' => $query, 'inline' => true])
       </div>
   @endif
   ```

3. Update SubmitWordForm to support inline mode (compact version)

**Files To Create/Modify:**
- `app/Livewire/SearchBar.php` (MODIFY)
- `resources/views/livewire/search-bar.blade.php` (MODIFY)
- `app/Livewire/SubmitWordForm.php` (MODIFY - add inline mode)
- `resources/views/livewire/submit-word-form.blade.php` (MODIFY - inline variant)

**Acceptance Criteria:**
- [ ] "No results" message shows when empty
- [ ] "Be the first to define" button appears
- [ ] Clicking shows inline submission form
- [ ] Form submits successfully
- [ ] User never leaves the page

---

### TASK-025: Hover Reveal Interactions
```
Status: TODO
Priority: LOW
Claimed By: -
Started: -
Completed: -
```

**What To Build:**
Vote buttons and domain availability hidden by default, revealed on hover.

**Step-by-Step:**
1. Wrap vote buttons and domain section in Alpine hover state:
   ```blade
   <div x-data="{ hovered: false }"
        @mouseenter="hovered = true"
        @mouseleave="hovered = false"
        class="relative">

       <!-- Card content always visible -->
       <h3>{{ $word->term }}</h3>
       <p>{{ $definition }}</p>

       <!-- Hidden until hover -->
       <div x-show="hovered"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="mt-4">
           @livewire('voting-counter', ['definition' => $def])
           <button>Check Domain</button>
       </div>
   </div>
   ```

2. Keep always visible on mobile (no hover):
   ```blade
   <div x-show="hovered || window.innerWidth < 768">
   ```

**Files To Create/Modify:**
- `resources/views/components/ui/bento-grid.blade.php` (MODIFY)

**Acceptance Criteria:**
- [ ] Vote buttons hidden by default on desktop
- [ ] Smooth reveal on hover
- [ ] Always visible on mobile
- [ ] Domain check hidden until hover

---

### TASK-042: Dark Mode Polish
```
Status: TODO
Priority: LOW
Claimed By: -
Started: -
Completed: -
```

**What To Build:**
Refine dark mode styling, ensure all components look good, and address any contrast or visibility issues.

**Step-by-Step:**
1. Review all existing components in dark mode.
2. Adjust `dark:` classes for better contrast and aesthetics.
3. Ensure SVGs and icons have appropriate dark mode colors.
4. Test on various screen sizes and devices.

**Files To Create/Modify:**
- Multiple blade files (MODIFY - adjust dark: classes)
- `tailwind.config.js` (MODIFY - if new colors/shades are needed)

**Acceptance Criteria:**
- [ ] All components are visually appealing in dark mode
- [ ] No unreadable text or invisible elements
- [ ] Consistent dark mode aesthetic across the app
- [ ] Icons and SVGs adapt correctly

---

### TASK-026: Dark Mode Toggle
```
Status: TODO
Priority: LOW
Claimed By: -
Started: -
Completed: -
```

**What To Build:**
Toggle between light and dark theme with TikTok colors.

**Step-by-Step:**
1. Add dark mode classes to Tailwind config:
   ```javascript
   // tailwind.config.js
   module.exports = {
       darkMode: 'class',
       theme: {
           extend: {
               colors: {
                   'tiktok-pink': '#fe2c55',
                   'tiktok-cyan': '#25f4ee',
                   'dark-bg': '#09090b',
               }
           }
       }
   }
   ```

2. Create dark mode toggle component:
   ```blade
   <div x-data="{
       dark: localStorage.getItem('darkMode') === 'true',
       toggle() {
           this.dark = !this.dark;
           localStorage.setItem('darkMode', this.dark);
           document.documentElement.classList.toggle('dark', this.dark);
       }
   }" x-init="document.documentElement.classList.toggle('dark', dark)">
       <button @click="toggle()" class="p-2 rounded-full">
           <svg x-show="!dark" class="w-5 h-5"><!-- sun icon --></svg>
           <svg x-show="dark" class="w-5 h-5"><!-- moon icon --></svg>
       </button>
   </div>
   ```

3. Add dark: variants to all components
4. Update brand colors for dark mode:
   - Background: #09090b (zinc-950)
   - Accents: TikTok pink #fe2c55, cyan #25f4ee

**Files To Create/Modify:**
- `tailwind.config.js` (MODIFY)
- `resources/views/components/layouts/app.blade.php` (MODIFY - add toggle to header)
- `resources/views/components/ui/dark-mode-toggle.blade.php` (CREATE)
- Multiple blade files (MODIFY - add dark: classes)

**Acceptance Criteria:**
- [ ] Toggle button in header
- [ ] Persists to localStorage
- [ ] All sections have dark variants
- [ ] TikTok colors used in dark mode

---

## QUICK REFERENCE

### Total Tasks: 26

| Phase | Tasks | Status |
|-------|-------|--------|
| Phase 1: Database | TASK-001 to TASK-005 | 0/5 Done |
| Phase 2: Frontend | TASK-006 to TASK-011 | 0/6 Done |
| Phase 3: Admin | TASK-012 to TASK-017 | 0/6 Done |
| Phase 4: Advanced | TASK-018 to TASK-026 | 0/9 Done (1 in progress) |

### Next Available Tasks (TODO) - No Dependencies:
| Task | Name | Priority |
|------|------|----------|
| TASK-001 | Categories Table | CRITICAL |
| TASK-004 | Settings Table | HIGH |
| TASK-005 | Update Users Table | CRITICAL |
| TASK-007 | RFCI Score Display | HIGH |
| TASK-008 | Lore Timeline Display | HIGH |
| TASK-009 | Live View Counter | HIGH |
| TASK-022 | Puter.js Audio - Listen Button | HIGH |
| TASK-024 | Search-to-Submit Inline | HIGH |

### In Progress:
| Task | Name | Claimed By |
|------|------|------------|
| TASK-019 | Vertical Feed (TikTok Scroll) | External AI |

### Blocked (Waiting on Dependencies):
| Task | Waiting For |
|------|-------------|
| TASK-002 | - (can start) |
| TASK-003 | - (can start) |
| TASK-006 | - (can start, MONETIZATION!) |
| TASK-010 | TASK-002 (Flags table) |
| TASK-015 | TASK-001 (Categories table) |
| TASK-016 | TASK-004 (Settings table) |
| TASK-017 | TASK-002 (Flags table) |
| TASK-021 | TASK-006 (Domain checker) |
| TASK-023 | TASK-022 (Listen button) |

### Priority Order (Recommended):
```
1. TASK-001 (Categories) ─────────────> Unlocks TASK-015
2. TASK-002 (Flags) ──────────────────> Unlocks TASK-010, TASK-017
3. TASK-004 (Settings) ───────────────> Unlocks TASK-016
4. TASK-005 (Users update) ───────────> Enables user management
5. TASK-006 (Domain Checker) ─────────> MONETIZATION - Critical!
6. TASK-022 (Puter.js Audio) ─────────> NEW FEATURE from README
7. TASK-007 (RFCI Display)
8. TASK-008 (Lore Timeline)
9. TASK-009 (Live View Counter)
10. TASK-024 (Search-to-Submit Inline)
```

---

## FEATURE CHECKLIST (from README.md)

### Core Features
- [x] Word submission
- [x] Agree/Disagree voting (Facts/Cap)
- [x] Hierarchical definition ranking
- [x] Timeframe sorting (Now/Week/Month)
- [x] Duplicate handling
- [ ] Categories from database (TASK-001)
- [x] Username-only auth
- [ ] Full admin panel (TASK-012 to TASK-017)

### Word Card Requirements (README lines 69-119)
- [x] Word Title (clickable)
- [ ] Live view counter + green dot (TASK-009)
- [ ] "Possible Polar Trend" badge (TASK-009)
- [x] Description with "Read more"
- [x] Agree/Disagree buttons
- [x] Category tag
- [ ] Domain Availability Checker (TASK-006) - MONETIZATION!
- [x] Submit alternate definition
- [ ] RFCI Score display (TASK-007)
- [ ] AI Combined Summary (TASK-018)

### Gemini's 5 Unconventional Features
- [x] Viral Velocity Heatmap (Bento grid)
- [ ] Slang-to-Sticker Generator (TASK-011)
- [ ] Lore Timeline Display (TASK-008)
- [ ] Vibe-Check Search (TASK-020)
- [ ] Investor Dashboard (TASK-021)

### NEW FEATURES (README update)
- [ ] Puter.js Audio - Listen Button (TASK-022)
- [ ] Puter.js Audio - Download Sound Bite (TASK-023)
- [ ] Search-to-Submit Inline Form (TASK-024)
- [ ] Hover Reveal Interactions (TASK-025)
- [ ] Dark Mode with TikTok Colors (TASK-026)
- [ ] Vertical Feed TikTok Scroll (TASK-019 - IN PROGRESS)

### Technical Requirements
- [ ] wire:poll for live counters (TASK-009)
- [ ] Redis view buffering (future)
- [ ] Polar trend auto-detection (future)

---

## CHANGE LOG

| Date | Task | Action | By |
|------|------|--------|-----|
| 2026-01-11 | TASK-019 | Started | External AI |
| 2026-01-11 | ALL | Created task board with 26 tasks | Claude Architect |

---

## PHASE 5: CREATIVE FEATURES & UX ENHANCEMENTS

### TASK-027: Word of the Day Feature
```
Status: TODO
Priority: MEDIUM
Claimed By: -
Started: -
Completed: -
```

**What To Build:**
Featured word section on homepage that changes daily with special styling.

**Step-by-Step:**
1. Create Livewire component `app/Livewire/WordOfTheDay.php`:
   ```php
   <?php
   namespace App\Livewire;

   use Livewire\Component;
   use App\Models\Word;
   use Illuminate\Support\Facades\Cache;

   class WordOfTheDay extends Component
   {
       public $word;

       public function mount()
       {
           $this->word = Cache::remember('word_of_the_day', now()->endOfDay(), function () {
               // Pick word with high agrees, decent age, and hasn't been WOTD recently
               return Word::with('primaryDefinition')
                   ->where('total_agrees', '>', 10)
                   ->whereDate('created_at', '<', now()->subDays(3))
                   ->orderByRaw('RAND(FLOOR(UNIX_TIMESTAMP(CURDATE()) / 86400))')
                   ->first();
           });
       }

       public function render()
       {
           return view('livewire.word-of-the-day');
       }
   }
   ```

2. Create view `resources/views/livewire/word-of-the-day.blade.php`:
   ```blade
   @if($word)
   <div class="relative overflow-hidden bg-gradient-to-br from-[#002B5B] via-purple-900 to-pink-900 rounded-3xl p-8 text-white mb-8">
       <!-- Animated background orbs -->
       <div class="absolute top-0 right-0 w-64 h-64 bg-pink-500/20 rounded-full blur-3xl animate-pulse"></div>
       <div class="absolute bottom-0 left-0 w-48 h-48 bg-cyan-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 0.5s;"></div>

       <div class="relative z-10">
           <div class="flex items-center gap-2 mb-4">
               <span class="px-3 py-1 bg-yellow-500/20 text-yellow-300 text-xs font-bold rounded-full uppercase tracking-wider">
                   ⭐ Word of the Day
               </span>
               <span class="text-white/50 text-xs">{{ now()->format('M d, Y') }}</span>
           </div>

           <a href="{{ route('word.show', $word->slug) }}" class="block group">
               <h2 class="text-4xl md:text-5xl font-black mb-3 group-hover:text-cyan-300 transition">
                   {{ $word->term }}
               </h2>
           </a>

           <p class="text-lg text-white/80 mb-6 max-w-2xl">
               {{ Str::limit($word->primaryDefinition->definition ?? 'No definition yet', 200) }}
           </p>

           <div class="flex items-center gap-6">
               <a href="{{ route('word.show', $word->slug) }}"
                  class="px-6 py-3 bg-white text-[#002B5B] font-bold rounded-full hover:bg-cyan-100 transition">
                   Explore Full Entry →
               </a>
               <div class="flex items-center gap-4 text-white/60">
                   <span>👍 {{ number_format($word->total_agrees) }}</span>
                   <span>👎 {{ number_format($word->total_disagrees) }}</span>
               </div>
           </div>
       </div>
   </div>
   @endif
   ```

3. Add to homepage `resources/views/home.blade.php` (after header, before main grid):
   ```blade
   @livewire('word-of-the-day')
   ```

**Files To Create/Modify:**
- `app/Livewire/WordOfTheDay.php` (CREATE)
- `resources/views/livewire/word-of-the-day.blade.php` (CREATE)
- `resources/views/home.blade.php` (MODIFY - add component)

**Acceptance Criteria:**
- [ ] Component shows featured word daily
- [ ] Word changes at midnight (cached)
- [ ] Gradient background with animated orbs
- [ ] Links to full word page
- [ ] Shows agree/disagree counts

---

### TASK-028: Rising Stars Section
```
Status: TODO
Priority: MEDIUM
Claimed By: -
Started: -
Completed: -
```

**What To Build:**
Section showing words with highest momentum gain in last 24 hours.

**Step-by-Step:**
1. Create Livewire component `app/Livewire/RisingStars.php`:
   ```php
   <?php
   namespace App\Livewire;

   use Livewire\Component;
   use App\Models\Word;
   use App\Models\Vote;
   use Illuminate\Support\Facades\DB;

   class RisingStars extends Component
   {
       public $words;

       public function mount()
       {
           // Get words with most vote activity in last 24 hours
           $this->words = Word::with('primaryDefinition')
               ->select('words.*', DB::raw('(
                   SELECT COUNT(*) FROM votes
                   WHERE votes.definition_id IN (
                       SELECT id FROM definitions WHERE definitions.word_id = words.id
                   ) AND votes.created_at >= NOW() - INTERVAL 24 HOUR
               ) as recent_votes'))
               ->having('recent_votes', '>', 0)
               ->orderBy('recent_votes', 'desc')
               ->limit(5)
               ->get();
       }

       public function render()
       {
           return view('livewire.rising-stars');
       }
   }
   ```

2. Create view `resources/views/livewire/rising-stars.blade.php`:
   ```blade
   @if($words->count() > 0)
   <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-8">
       <div class="flex items-center gap-2 mb-4">
           <span class="text-2xl">🚀</span>
           <h3 class="text-xl font-bold text-[#002B5B]">Rising Stars</h3>
           <span class="text-xs text-slate-500">(last 24h)</span>
       </div>

       <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
           @foreach($words as $index => $word)
           <a href="{{ route('word.show', $word->slug) }}"
              class="group p-4 rounded-xl bg-gradient-to-br from-slate-50 to-slate-100 hover:from-purple-50 hover:to-pink-50 transition">
               <div class="flex items-center gap-2 mb-2">
                   <span class="text-lg font-bold text-slate-400">{{ $index + 1 }}</span>
                   @if($index === 0)
                       <span class="text-yellow-500">🔥</span>
                   @elseif($index < 3)
                       <span class="text-orange-500">📈</span>
                   @endif
               </div>
               <h4 class="font-bold text-[#002B5B] group-hover:text-purple-700 truncate">
                   {{ $word->term }}
               </h4>
               <p class="text-xs text-slate-500 mt-1">
                   +{{ $word->recent_votes }} votes
               </p>
           </a>
           @endforeach
       </div>
   </div>
   @endif
   ```

3. Add to homepage after Word of the Day

**Files To Create/Modify:**
- `app/Livewire/RisingStars.php` (CREATE)
- `resources/views/livewire/rising-stars.blade.php` (CREATE)
- `resources/views/home.blade.php` (MODIFY)

**Acceptance Criteria:**
- [ ] Shows top 5 trending words
- [ ] Based on last 24h vote activity
- [ ] Numbered ranking with fire emoji for #1
- [ ] Links to word pages
- [ ] Hidden if no recent activity

---

### TASK-029: Definition Battle Mode
```
Status: TODO
Priority: LOW
Claimed By: -
Started: -
Completed: -
```

**What To Build:**
Fun comparison mode where users vote between two definitions side-by-side.

**Step-by-Step:**
1. Create route `/battle`:
   ```php
   // routes/web.php
   Route::get('/battle', [BattleController::class, 'show'])->name('battle');
   ```

2. Create Livewire component `app/Livewire/DefinitionBattle.php`:
   ```php
   <?php
   namespace App\Livewire;

   use Livewire\Component;
   use App\Models\Definition;

   class DefinitionBattle extends Component
   {
       public $definition1;
       public $definition2;
       public $voted = false;
       public $winner = null;
       public $streak = 0;

       public function mount()
       {
           $this->loadNewBattle();
           $this->streak = session('battle_streak', 0);
       }

       public function loadNewBattle()
       {
           // Get two random definitions for the same word
           $definitions = Definition::with('word')
               ->whereHas('word', function($q) {
                   $q->whereHas('definitions', function($q2) {
                       $q2->havingRaw('COUNT(*) >= 2');
                   });
               })
               ->inRandomOrder()
               ->limit(2)
               ->get();

           if ($definitions->count() === 2) {
               $this->definition1 = $definitions[0];
               $this->definition2 = $definitions[1];
           }

           $this->voted = false;
           $this->winner = null;
       }

       public function vote($defId)
       {
           $this->voted = true;
           $this->winner = $defId;

           // Increment agree for winner
           Definition::where('id', $defId)->increment('agrees');

           // Update streak
           $this->streak++;
           session(['battle_streak' => $this->streak]);
       }

       public function nextBattle()
       {
           $this->loadNewBattle();
       }

       public function render()
       {
           return view('livewire.definition-battle');
       }
   }
   ```

3. Create view with VS-style layout:
   ```blade
   <div class="min-h-screen bg-gradient-to-br from-slate-900 to-purple-900 py-12">
       <div class="max-w-4xl mx-auto px-4">
           <div class="text-center mb-8">
               <h1 class="text-3xl font-black text-white mb-2">⚔️ Definition Battle</h1>
               <p class="text-white/60">Which definition hits different?</p>
               <p class="text-yellow-400 font-bold mt-2">🔥 Streak: {{ $streak }}</p>
           </div>

           @if($definition1 && $definition2)
           <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
               <!-- Definition 1 -->
               <button
                   wire:click="vote({{ $definition1->id }})"
                   @disabled($voted)
                   class="p-6 rounded-2xl text-left transition transform hover:scale-105 {{ $winner === $definition1->id ? 'bg-green-500 ring-4 ring-green-300' : 'bg-white' }} {{ $voted && $winner !== $definition1->id ? 'opacity-50' : '' }}"
               >
                   <h3 class="font-bold text-lg mb-2 {{ $winner === $definition1->id ? 'text-white' : 'text-[#002B5B]' }}">
                       {{ $definition1->word->term }}
                   </h3>
                   <p class="{{ $winner === $definition1->id ? 'text-white/90' : 'text-slate-600' }}">
                       {{ $definition1->definition }}
                   </p>
               </button>

               <!-- VS Badge -->
               <div class="hidden md:flex absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 z-10">
                   <span class="px-4 py-2 bg-pink-500 text-white font-black rounded-full text-xl">VS</span>
               </div>

               <!-- Definition 2 -->
               <button
                   wire:click="vote({{ $definition2->id }})"
                   @disabled($voted)
                   class="p-6 rounded-2xl text-left transition transform hover:scale-105 {{ $winner === $definition2->id ? 'bg-green-500 ring-4 ring-green-300' : 'bg-white' }} {{ $voted && $winner !== $definition2->id ? 'opacity-50' : '' }}"
               >
                   <!-- Same structure as def 1 -->
               </button>
           </div>

           @if($voted)
           <div class="text-center">
               <button
                   wire:click="nextBattle"
                   class="px-8 py-4 bg-pink-500 hover:bg-pink-600 text-white font-bold rounded-full text-lg transition"
               >
                   Next Battle →
               </button>
           </div>
           @endif
           @endif
       </div>
   </div>
   ```

**Files To Create/Modify:**
- `app/Livewire/DefinitionBattle.php` (CREATE)
- `resources/views/livewire/definition-battle.blade.php` (CREATE)
- `routes/web.php` (MODIFY)
- Navigation (MODIFY - add link)

**Acceptance Criteria:**
- [ ] Shows two definitions side-by-side
- [ ] User picks one to vote
- [ ] Winner highlighted in green
- [ ] Streak counter persists
- [ ] Next battle button loads new pair
- [ ] Mobile responsive (stacked)

---

### TASK-030: User Badges & Gamification
```
Status: TODO
Priority: LOW
Claimed By: -
Started: -
Completed: -
Depends On: TASK-005
```

**What To Build:**
Achievement badges for user contributions.

**Step-by-Step:**
1. Create badges migration:
   ```php
   Schema::create('badges', function (Blueprint $table) {
       $table->id();
       $table->string('name', 100);
       $table->string('slug', 100)->unique();
       $table->text('description');
       $table->string('icon', 50); // emoji or icon name
       $table->string('color', 7)->default('#8b5cf6');
       $table->enum('type', ['contribution', 'voting', 'streak', 'special']);
       $table->integer('requirement_count')->default(1);
       $table->timestamps();
   });

   Schema::create('user_badges', function (Blueprint $table) {
       $table->id();
       $table->foreignId('user_id')->constrained()->onDelete('cascade');
       $table->foreignId('badge_id')->constrained()->onDelete('cascade');
       $table->timestamp('earned_at');
       $table->unique(['user_id', 'badge_id']);
   });
   ```

2. Seed default badges:
   ```php
   $badges = [
       ['name' => 'First Words', 'icon' => '🎯', 'type' => 'contribution', 'requirement_count' => 1, 'description' => 'Submit your first definition'],
       ['name' => 'Wordsmith', 'icon' => '✍️', 'type' => 'contribution', 'requirement_count' => 10, 'description' => 'Submit 10 definitions'],
       ['name' => 'Dictionary Degen', 'icon' => '📚', 'type' => 'contribution', 'requirement_count' => 50, 'description' => 'Submit 50 definitions'],
       ['name' => 'Voter', 'icon' => '🗳️', 'type' => 'voting', 'requirement_count' => 10, 'description' => 'Cast 10 votes'],
       ['name' => 'Opinion Leader', 'icon' => '👑', 'type' => 'voting', 'requirement_count' => 100, 'description' => 'Cast 100 votes'],
       ['name' => 'Trendsetter', 'icon' => '🔥', 'type' => 'special', 'requirement_count' => 1, 'description' => 'Have a definition become #1'],
       ['name' => 'Week Warrior', 'icon' => '⚡', 'type' => 'streak', 'requirement_count' => 7, 'description' => 'Visit 7 days in a row'],
   ];
   ```

3. Create BadgeService to check and award badges automatically
4. Display badges on user profile and word cards

**Files To Create/Modify:**
- `database/migrations/xxxx_create_badges_tables.php` (CREATE)
- `app/Models/Badge.php` (CREATE)
- `app/Services/BadgeService.php` (CREATE)
- `database/seeders/BadgeSeeder.php` (CREATE)
- `app/Models/User.php` (MODIFY - add relationship)
- User profile views (MODIFY)

**Acceptance Criteria:**
- [ ] Badges table with default badges
- [ ] Users can earn badges automatically
- [ ] Badges display on user profile
- [ ] Toast notification when badge earned
- [ ] Badges show next to usernames

---

### TASK-031: Skeleton Loading States
```
Status: TODO
Priority: HIGH
Claimed By: -
Started: -
Completed: -
```

**What To Build:**
Animated skeleton placeholders while content loads.

**Step-by-Step:**
1. Create skeleton components:

   `resources/views/components/ui/skeleton-card.blade.php`:
   ```blade
   <div class="bg-white rounded-2xl p-6 animate-pulse">
       <div class="flex items-center gap-2 mb-4">
           <div class="h-3 w-20 bg-slate-200 rounded"></div>
           <div class="h-3 w-16 bg-slate-200 rounded"></div>
       </div>
       <div class="h-7 w-3/4 bg-slate-200 rounded mb-3"></div>
       <div class="space-y-2">
           <div class="h-4 w-full bg-slate-200 rounded"></div>
           <div class="h-4 w-5/6 bg-slate-200 rounded"></div>
           <div class="h-4 w-4/6 bg-slate-200 rounded"></div>
       </div>
       <div class="flex items-center gap-4 mt-6">
           <div class="h-8 w-16 bg-slate-200 rounded-full"></div>
           <div class="h-8 w-16 bg-slate-200 rounded-full"></div>
       </div>
   </div>
   ```

   `resources/views/components/ui/skeleton-grid.blade.php`:
   ```blade
   @props(['count' => 6])
   <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
       @for($i = 0; $i < $count; $i++)
           <x-ui.skeleton-card />
       @endfor
   </div>
   ```

2. Add to Livewire components with `wire:loading`:
   ```blade
   <div wire:loading.remove>
       <!-- Actual content -->
   </div>
   <div wire:loading>
       <x-ui.skeleton-grid :count="6" />
   </div>
   ```

3. Apply to:
   - BentoGrid component
   - Word detail page
   - Search results
   - Admin tables

**Files To Create/Modify:**
- `resources/views/components/ui/skeleton-card.blade.php` (CREATE)
- `resources/views/components/ui/skeleton-grid.blade.php` (CREATE)
- `resources/views/components/ui/skeleton-text.blade.php` (CREATE)
- Multiple Livewire views (MODIFY - add wire:loading)

**Acceptance Criteria:**
- [ ] Skeleton cards match real card proportions
- [ ] Smooth pulse animation
- [ ] Shows during Livewire loading
- [ ] Applied to all major components
- [ ] Different skeletons for different content types

---

### TASK-032: Celebration Animations
```
Status: TODO
Priority: LOW
Claimed By: -
Started: -
Completed: -
```

**What To Build:**
Confetti and celebration effects for successful actions.

**Step-by-Step:**
1. Install confetti library:
   ```bash
   npm install canvas-confetti
   ```

2. Create Alpine wrapper `resources/js/confetti.js`:
   ```javascript
   import confetti from 'canvas-confetti';

   window.celebrate = {
       vote() {
           confetti({
               particleCount: 30,
               spread: 60,
               origin: { y: 0.7 },
               colors: ['#fe2c55', '#25f4ee', '#002B5B']
           });
       },
       submit() {
           confetti({
               particleCount: 100,
               spread: 70,
               origin: { y: 0.6 }
           });
       },
       streak(count) {
           if (count % 5 === 0) {
               confetti({
                   particleCount: 150,
                   spread: 180,
                   startVelocity: 45
               });
           }
       }
   };
   ```

3. Trigger on:
   - First vote on a definition
   - Successful word submission
   - Reaching battle streaks of 5, 10, etc.
   - Earning a badge

4. Add to Livewire events:
   ```php
   // In VotingCounter.php
   $this->dispatch('celebrate-vote');
   ```

   ```blade
   <!-- In blade -->
   <div x-on:celebrate-vote.window="celebrate.vote()">
   ```

**Files To Create/Modify:**
- `resources/js/confetti.js` (CREATE)
- `resources/js/app.js` (MODIFY - import)
- `app/Livewire/VotingCounter.php` (MODIFY - dispatch event)
- `app/Livewire/SubmitWordForm.php` (MODIFY - dispatch event)

**Acceptance Criteria:**
- [ ] Confetti triggers on votes (subtle)
- [ ] Bigger celebration on submissions
- [ ] Mega celebration on milestones
- [ ] Uses TikTok brand colors
- [ ] Not annoying (once per action)

---

### TASK-033: Keyboard Shortcuts
```
Status: TODO
Priority: LOW
Claimed By: -
Started: -
Completed: -
```

**What To Build:**
Power user keyboard shortcuts for navigation and voting.

**Step-by-Step:**
1. Create Alpine shortcuts handler:
   ```javascript
   // resources/js/shortcuts.js
   document.addEventListener('alpine:init', () => {
       Alpine.data('shortcuts', () => ({
           init() {
               document.addEventListener('keydown', (e) => {
                   // Don't trigger if user is typing
                   if (['INPUT', 'TEXTAREA'].includes(e.target.tagName)) return;

                   switch(e.key) {
                       case '/':
                           e.preventDefault();
                           document.querySelector('[data-search-input]')?.focus();
                           break;
                       case 'n':
                           window.location.href = '/submit';
                           break;
                       case '?':
                           this.$dispatch('show-shortcuts-modal');
                           break;
                       case 'Escape':
                           document.activeElement.blur();
                           break;
                   }
               });
           }
       }));
   });
   ```

2. Create shortcuts modal `resources/views/components/ui/shortcuts-modal.blade.php`:
   ```blade
   <div x-data="{ open: false }"
        x-on:show-shortcuts-modal.window="open = true"
        x-show="open"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center">
       <div class="absolute inset-0 bg-black/50" @click="open = false"></div>
       <div class="relative bg-white rounded-2xl p-6 max-w-md w-full mx-4">
           <h3 class="text-xl font-bold mb-4">⌨️ Keyboard Shortcuts</h3>
           <div class="space-y-3">
               <div class="flex justify-between">
                   <span class="text-slate-600">Search</span>
                   <kbd class="px-2 py-1 bg-slate-100 rounded text-sm font-mono">/</kbd>
               </div>
               <div class="flex justify-between">
                   <span class="text-slate-600">New Submission</span>
                   <kbd class="px-2 py-1 bg-slate-100 rounded text-sm font-mono">N</kbd>
               </div>
               <div class="flex justify-between">
                   <span class="text-slate-600">Show Shortcuts</span>
                   <kbd class="px-2 py-1 bg-slate-100 rounded text-sm font-mono">?</kbd>
               </div>
               <div class="flex justify-between">
                   <span class="text-slate-600">Close/Deselect</span>
                   <kbd class="px-2 py-1 bg-slate-100 rounded text-sm font-mono">Esc</kbd>
               </div>
           </div>
           <button @click="open = false" class="mt-6 w-full py-2 bg-slate-100 rounded-lg font-bold">
               Close
           </button>
       </div>
   </div>
   ```

3. Add x-data="shortcuts" to app layout

**Files To Create/Modify:**
- `resources/js/shortcuts.js` (CREATE)
- `resources/js/app.js` (MODIFY - import)
- `resources/views/components/ui/shortcuts-modal.blade.php` (CREATE)
- `resources/views/components/layouts/app.blade.php` (MODIFY)

**Acceptance Criteria:**
- [ ] `/` focuses search
- [ ] `N` goes to submit page
- [ ] `?` shows shortcuts help
- [ ] `Esc` closes modals/blurs
- [ ] Disabled when typing in inputs

---

### TASK-034: Mobile Swipe Gestures
```
Status: TODO
Priority: MEDIUM
Claimed By: -
Started: -
Completed: -
```

**What To Build:**
Swipe left/right to vote on mobile cards.

**Step-by-Step:**
1. Add touch gesture handling:
   ```javascript
   // resources/js/swipe-vote.js
   Alpine.directive('swipe-vote', (el, { expression }, { evaluate }) => {
       let startX = 0;
       let startY = 0;
       const threshold = 100;

       el.addEventListener('touchstart', (e) => {
           startX = e.touches[0].clientX;
           startY = e.touches[0].clientY;
       });

       el.addEventListener('touchend', (e) => {
           const diffX = e.changedTouches[0].clientX - startX;
           const diffY = e.changedTouches[0].clientY - startY;

           // Ensure horizontal swipe (not scroll)
           if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > threshold) {
               if (diffX > 0) {
                   // Swipe right = agree
                   el.dispatchEvent(new CustomEvent('swipe-agree'));
               } else {
                   // Swipe left = disagree
                   el.dispatchEvent(new CustomEvent('swipe-disagree'));
               }
           }
       });
   });
   ```

2. Add visual feedback during swipe:
   ```blade
   <div x-data="{ swiping: null }"
        x-swipe-vote
        @swipe-agree="swiping = 'agree'; $wire.vote('agree'); setTimeout(() => swiping = null, 500)"
        @swipe-disagree="swiping = 'disagree'; $wire.vote('disagree'); setTimeout(() => swiping = null, 500)"
        :class="{
            'bg-green-100 border-green-500': swiping === 'agree',
            'bg-red-100 border-red-500': swiping === 'disagree'
        }"
        class="transition-colors duration-200">
       <!-- Card content -->

       <!-- Swipe hint (shown on first visit) -->
       <div x-show="!localStorage.getItem('swipe-hint-seen')"
            x-init="setTimeout(() => localStorage.setItem('swipe-hint-seen', 'true'), 3000)"
            class="absolute inset-0 bg-black/50 flex items-center justify-center text-white text-sm">
           ← Swipe to vote →
       </div>
   </div>
   ```

3. Add to mobile word cards only (use Tailwind breakpoints)

**Files To Create/Modify:**
- `resources/js/swipe-vote.js` (CREATE)
- `resources/js/app.js` (MODIFY - import)
- `resources/views/components/ui/bento-grid.blade.php` (MODIFY)
- Word card blade files (MODIFY)

**Acceptance Criteria:**
- [ ] Swipe right = agree (Facts)
- [ ] Swipe left = disagree (Cap)
- [ ] Visual feedback during swipe
- [ ] Only on mobile (touch devices)
- [ ] First-time hint displayed

---

### TASK-035: Empty States with Illustrations
```
Status: TODO
Priority: MEDIUM
Claimed By: -
Started: -
Completed: -
```

**What To Build:**
Friendly empty states when no content is available.

**Step-by-Step:**
1. Create empty state components:

   `resources/views/components/ui/empty-state.blade.php`:
   ```blade
   @props(['type' => 'generic', 'title' => null, 'description' => null, 'action' => null, 'actionUrl' => null])

   @php
   $states = [
       'no-results' => [
           'icon' => '🔍',
           'title' => 'No results found',
           'description' => 'Try adjusting your search or filters.',
       ],
       'no-words' => [
           'icon' => '📝',
           'title' => 'No words yet',
           'description' => 'Be the first to add a word!',
           'action' => 'Submit a Word',
           'actionUrl' => '/submit',
       ],
       'no-definitions' => [
           'icon' => '💭',
           'title' => 'No definitions yet',
           'description' => 'This word needs your help!',
           'action' => 'Add Definition',
       ],
       'no-activity' => [
           'icon' => '😴',
           'title' => 'Nothing happening here',
           'description' => 'Check back later for updates.',
       ],
       'coming-soon' => [
           'icon' => '🚧',
           'title' => 'Coming Soon',
           'description' => "We're working on something cool!",
       ],
   ];
   $state = $states[$type] ?? $states['generic'];
   @endphp

   <div class="text-center py-12 px-4">
       <div class="text-6xl mb-4">{{ $state['icon'] }}</div>
       <h3 class="text-xl font-bold text-slate-800 mb-2">
           {{ $title ?? $state['title'] }}
       </h3>
       <p class="text-slate-600 max-w-md mx-auto mb-6">
           {{ $description ?? $state['description'] }}
       </p>
       @if($action ?? $state['action'] ?? false)
           <a href="{{ $actionUrl ?? $state['actionUrl'] ?? '#' }}"
              class="inline-block px-6 py-3 bg-[#002B5B] text-white font-bold rounded-full hover:bg-[#003d7a] transition">
               {{ $action ?? $state['action'] }}
           </a>
       @endif
   </div>
   ```

2. Apply to:
   - Search with no results
   - Category with no words
   - User profile with no submissions
   - Admin tables with no data

3. Usage:
   ```blade
   @if($words->isEmpty())
       <x-ui.empty-state type="no-words" />
   @else
       <!-- Show words -->
   @endif
   ```

**Files To Create/Modify:**
- `resources/views/components/ui/empty-state.blade.php` (CREATE)
- Multiple blade views (MODIFY - add empty states)

**Acceptance Criteria:**
- [ ] Empty state component with variants
- [ ] Applied to search results
- [ ] Applied to category pages
- [ ] Applied to admin tables
- [ ] Includes call-to-action where appropriate

---

### TASK-036: Animated Number Counters (Count Up Effect)
```
Status: DONE
Priority: HIGH
Claimed By: Claude AI
Started: 2026-01-12
Completed: 2026-01-12
```

**What To Build:**
Numbers (views, votes, stats) animate counting up from 0 to their final value when visible. Creates engaging "live data" feel.

**Step-by-Step:**
1. Create Alpine counter directive `resources/js/counter.js`:
   ```javascript
   document.addEventListener('alpine:init', () => {
       Alpine.directive('counter', (el, { expression }, { evaluate }) => {
           const target = parseInt(evaluate(expression)) || 0;
           const duration = 1500;
           const frameDuration = 1000 / 60;
           const totalFrames = Math.round(duration / frameDuration);
           let frame = 0;
           let hasAnimated = false;

           const easeOutQuad = (t) => t * (2 - t);

           const animate = () => {
               if (hasAnimated) return;
               hasAnimated = true;

               const counter = setInterval(() => {
                   frame++;
                   const progress = easeOutQuad(frame / totalFrames);
                   el.textContent = Math.round(target * progress).toLocaleString();

                   if (frame === totalFrames) {
                       clearInterval(counter);
                       el.textContent = target.toLocaleString();
                   }
               }, frameDuration);
           };

           const observer = new IntersectionObserver((entries) => {
               entries.forEach(entry => {
                   if (entry.isIntersecting) {
                       animate();
                       observer.unobserve(el);
                   }
               });
           }, { threshold: 0.5 });

           observer.observe(el);
       });
   });
   ```

2. Import in `resources/js/app.js`:
   ```javascript
   import './counter.js';
   ```

3. Usage in blade files:
   ```blade
   <!-- Vote counters -->
   <span x-data x-counter="{{ $agrees }}">0</span>

   <!-- View counters -->
   <span x-data x-counter="{{ $word->views }}">0</span> views

   <!-- Admin stats -->
   <div class="text-4xl font-black" x-data x-counter="{{ $totalWords }}">0</div>
   ```

**Files To Create/Modify:**
- `resources/js/counter.js` (CREATE)
- `resources/js/app.js` (MODIFY)
- `resources/views/livewire/voting-counter.blade.php` (MODIFY)
- `resources/views/components/ui/bento-grid.blade.php` (MODIFY)
- Admin dashboard views (MODIFY)

**Acceptance Criteria:**
- [ ] Numbers count from 0 to final value
- [ ] Easing animation (slows at end)
- [ ] Only triggers when visible (IntersectionObserver)
- [ ] Works on vote counters
- [ ] Works on view counters
- [ ] Works on admin stats
- [ ] Duration ~1.5 seconds
- [ ] Formats with commas (1,234)

---

### TASK-037: Card Entrance Animations
```
Status: TODO
Priority: MEDIUM
Claimed By: -
Started: -
Completed: -
```

**What To Build:**
Cards fade-up with staggered timing when entering viewport.

**Step-by-Step:**
1. Create animation directive `resources/js/animations.js`:
   ```javascript
   document.addEventListener('alpine:init', () => {
       Alpine.directive('animate-cards', (el) => {
           const cards = el.querySelectorAll('[data-card]');

           cards.forEach((card, index) => {
               card.style.opacity = '0';
               card.style.transform = 'translateY(20px)';

               const observer = new IntersectionObserver((entries) => {
                   entries.forEach(entry => {
                       if (entry.isIntersecting) {
                           setTimeout(() => {
                               card.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                               card.style.opacity = '1';
                               card.style.transform = 'translateY(0)';
                           }, index * 80);
                           observer.unobserve(entry.target);
                       }
                   });
               }, { threshold: 0.1 });

               observer.observe(card);
           });
       });
   });
   ```

2. Add CSS in `resources/css/app.css`:
   ```css
   .card-hover {
       transition: transform 0.2s ease, box-shadow 0.2s ease;
   }
   .card-hover:hover {
       transform: translateY(-4px);
       box-shadow: 0 12px 24px -8px rgba(0, 43, 91, 0.15);
   }
   ```

3. Apply to grids:
   ```blade
   <div x-data x-animate-cards class="grid gap-6">
       @foreach($words as $word)
           <div data-card class="card-hover bg-white rounded-2xl">...</div>
       @endforeach
   </div>
   ```

**Files To Create/Modify:**
- `resources/js/animations.js` (CREATE)
- `resources/js/app.js` (MODIFY)
- `resources/css/app.css` (MODIFY)
- `resources/views/components/ui/bento-grid.blade.php` (MODIFY)
- `resources/views/word/show.blade.php` (MODIFY)

**Acceptance Criteria:**
- [ ] Cards fade up on scroll
- [ ] Staggered timing (80ms between)
- [ ] Hover lift effect (-4px)
- [ ] Works on homepage grid
- [ ] Works on definitions

---

### TASK-038: Input Field Animations
```
Status: TODO
Priority: MEDIUM
Claimed By: -
Started: -
Completed: -
```

**What To Build:**
Floating labels that animate up, focus ring effects, shake on errors.

**Step-by-Step:**
1. Create `resources/views/components/ui/floating-input.blade.php`:
   ```blade
   @props(['name', 'label', 'type' => 'text', 'error' => null, 'required' => false])

   <div class="relative" x-data="{ focused: false, hasValue: false }">
       <input
           type="{{ $type }}"
           name="{{ $name }}"
           id="{{ $name }}"
           {{ $required ? 'required' : '' }}
           @focus="focused = true"
           @blur="focused = false; hasValue = $el.value.length > 0"
           @input="hasValue = $el.value.length > 0"
           {{ $attributes->merge(['class' => 'peer w-full px-4 py-3 pt-6 border-2 rounded-xl transition-all duration-200 outline-none
               ' . ($error ? 'border-red-400' : 'border-slate-200 focus:border-[#002B5B]')]) }}
       >
       <label
           for="{{ $name }}"
           class="absolute left-4 transition-all duration-200 pointer-events-none"
           :class="{
               'text-xs top-2 text-[#002B5B]': focused || hasValue,
               'text-base top-4 text-slate-500': !focused && !hasValue
           }"
       >{{ $label }}{{ $required ? ' *' : '' }}</label>

       <div class="absolute inset-0 rounded-xl pointer-events-none transition-all"
            :class="focused ? 'ring-4 ring-[#002B5B]/10' : ''"></div>

       @if($error)
           <p class="mt-1 text-xs text-red-500 animate-shake">{{ $error }}</p>
       @endif
   </div>
   ```

2. Add shake animation in `resources/css/app.css`:
   ```css
   @keyframes shake {
       0%, 100% { transform: translateX(0); }
       20%, 60% { transform: translateX(-4px); }
       40%, 80% { transform: translateX(4px); }
   }
   .animate-shake { animation: shake 0.4s ease-in-out; }
   ```

3. Usage:
   ```blade
   <x-ui.floating-input name="term" label="Slang Term" wire:model="term" :error="$errors->first('term')" required />
   ```

**Files To Create/Modify:**
- `resources/views/components/ui/floating-input.blade.php` (CREATE)
- `resources/views/components/ui/floating-textarea.blade.php` (CREATE)
- `resources/css/app.css` (MODIFY)
- Form blade files (MODIFY)

**Acceptance Criteria:**
- [ ] Labels float up on focus
- [ ] Labels stay up when has value
- [ ] Focus ring glow effect
- [ ] Shake animation on errors
- [ ] Applied to all forms

---


---

### TASK-039: Mobile Responsive Navigation
```
Status: DONE
Priority: HIGH
Claimed By: Claude AI
Started: 2026-01-12
Completed: 2026-01-12
```

**What To Build:**
Fully responsive navigation bar with hamburger menu for mobile devices.

**Step-by-Step:**
1. Create `resources/views/components/layout/mobile-nav.blade.php`:
   - Slide-over menu or drop-down
   - Navigation links
   - Mobile search bar
2. Update `resources/views/components/layouts/app.blade.php`:
   - Hide desktop nav on mobile (`hidden md:flex`)
   - Show hamburger button on mobile (`block md:hidden`)
   - Include mobile menu component

**Acceptance Criteria:**
- [ ] Hamburger menu opens/closes smoothly
- [ ] Links are touch-friendly (44px min height)
- [ ] Search bar accessible on mobile
- [ ] No horizontal scroll when menu open

---

### TASK-040: Responsive Layouts (Homepage & Detail)
```
Status: DONE
Priority: HIGH
Claimed By: Claude AI
Started: 2026-01-12
Completed: 2026-01-12
```

**What To Build:**
Ensure Homepage, Bento Grid, and Word Detail pages look great on all device sizes (Mobile, Tablet, Desktop).

**Step-by-Step:**
1. Update `resources/views/components/ui/bento-grid.blade.php`:
   - Grid columns: `grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4`
2. Update `resources/views/word/show.blade.php`:
   - Stack layout for mobile (`flex-col`)
   - Adjust typography sizes (H1 from `text-6xl` to `text-4xl` on mobile)
   - Ensure tables/lists don't overflow
3. Update `resources/views/welcome.blade.php`:
   - "Fresh Submissions" grid responsive
   - Hero section stats stacking

**Acceptance Criteria:**
- [ ] Homepage bento grid stacks correctly on mobile
- [ ] Word detail page readable on mobile (no zooming needed)
- [ ] Font sizes adjusted for smaller screens
- [ ] Stats section stacks on mobile

---

### TASK-041: Responsive Forms & Inputs
```
Status: DONE
Priority: MEDIUM
Claimed By: Claude AI
Started: 2026-01-12
Completed: 2026-01-12
```

### TASK-042: Dark Mode Polish
```
Status: TODO
Priority: LOW
Claimed By: -
Started: -
Completed: -
```

**What To Build:**
Ensure all forms (Submit Word, Add Definition) are usable on mobile devices.

**Step-by-Step:**
1. Update Form Blade Views:
   - Full width inputs on mobile
   - Large touch targets for submit buttons
   - Prevent zoom on input focus (font-size >= 16px)
   - Vertical padding adjustments

**Acceptance Criteria:**
- [ ] Inputs readable and accessible on mobile
- [ ] Submit buttons easily tappable
- [ ] Error messages displayed correctly on narrow screens

---

### TASK-043: Live Notifications (Freelancer-Style Real-Time Toasts)
```
Status: TODO
Priority: HIGH
Claimed By: -
Started: -
Completed: -
```

**What To Build:**
Real-time toast notifications that appear site-wide when someone submits a new word, like Freelancer.com shows "New project posted" notifications. Creates social proof and engagement.

**Step-by-Step:**
1. Install Laravel Echo and Pusher (or use Reverb for self-hosted):
   ```bash
   composer require pusher/pusher-php-server
   npm install --save-dev laravel-echo pusher-js
   ```

2. Configure `.env`:
   ```env
   BROADCAST_DRIVER=pusher
   PUSHER_APP_ID=your-app-id
   PUSHER_APP_KEY=your-app-key
   PUSHER_APP_SECRET=your-secret
   PUSHER_APP_CLUSTER=mt1
   ```

3. Create Event `app/Events/NewWordSubmitted.php`:
   ```php
   <?php
   namespace App\Events;

   use Illuminate\Broadcasting\Channel;
   use Illuminate\Broadcasting\InteractsWithSockets;
   use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
   use Illuminate\Foundation\Events\Dispatchable;
   use App\Models\Word;

   class NewWordSubmitted implements ShouldBroadcast
   {
       use Dispatchable, InteractsWithSockets;

       public $word;
       public $username;

       public function __construct(Word $word, string $username)
       {
           $this->word = [
               'id' => $word->id,
               'term' => $word->term,
               'slug' => $word->slug,
               'category' => $word->category,
           ];
           $this->username = $username;
       }

       public function broadcastOn()
       {
           return new Channel('live-activity');
       }

       public function broadcastAs()
       {
           return 'word.submitted';
       }
   }
   ```

4. Create Event `app/Events/NewVoteCast.php`:
   ```php
   <?php
   namespace App\Events;

   use Illuminate\Broadcasting\Channel;
   use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

   class NewVoteCast implements ShouldBroadcast
   {
       public $wordTerm;
       public $voteType; // 'agree' or 'disagree'
       public $newCount;

       public function __construct(string $wordTerm, string $voteType, int $newCount)
       {
           $this->wordTerm = $wordTerm;
           $this->voteType = $voteType;
           $this->newCount = $newCount;
       }

       public function broadcastOn()
       {
           return new Channel('live-activity');
       }

       public function broadcastAs()
       {
           return 'vote.cast';
       }
   }
   ```

5. Dispatch events in `app/Livewire/SubmitWordForm.php`:
   ```php
   use App\Events\NewWordSubmitted;

   // After word is created successfully:
   event(new NewWordSubmitted($word, auth()->user()->username ?? 'Anonymous'));
   ```

6. Create Alpine.js toast manager `resources/js/live-notifications.js`:
   ```javascript
   import Echo from 'laravel-echo';
   import Pusher from 'pusher-js';

   window.Pusher = Pusher;

   window.Echo = new Echo({
       broadcaster: 'pusher',
       key: import.meta.env.VITE_PUSHER_APP_KEY,
       cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
       forceTLS: true
   });

   document.addEventListener('alpine:init', () => {
       Alpine.store('notifications', {
           items: [],

           add(notification) {
               const id = Date.now();
               this.items.push({ id, ...notification });

               // Auto-remove after 5 seconds
               setTimeout(() => {
                   this.remove(id);
               }, 5000);
           },

           remove(id) {
               this.items = this.items.filter(n => n.id !== id);
           }
       });

       // Listen for events
       window.Echo.channel('live-activity')
           .listen('.word.submitted', (e) => {
               Alpine.store('notifications').add({
                   type: 'word',
                   title: 'New Word Added!',
                   message: `"${e.word.term}" was just submitted by ${e.username}`,
                   link: `/word/${e.word.slug}`,
                   icon: '📝'
               });
           })
           .listen('.vote.cast', (e) => {
               Alpine.store('notifications').add({
                   type: 'vote',
                   title: e.voteType === 'agree' ? 'Facts!' : 'Cap!',
                   message: `Someone voted on "${e.wordTerm}"`,
                   icon: e.voteType === 'agree' ? '👍' : '👎'
               });
           });
   });
   ```

7. Create toast component `resources/views/components/ui/live-notifications.blade.php`:
   ```blade
   <div
       x-data
       class="fixed bottom-4 right-4 z-50 flex flex-col gap-2 max-w-sm"
   >
       <template x-for="notification in $store.notifications.items" :key="notification.id">
           <div
               x-show="true"
               x-transition:enter="transform ease-out duration-300"
               x-transition:enter-start="translate-x-full opacity-0"
               x-transition:enter-end="translate-x-0 opacity-100"
               x-transition:leave="transform ease-in duration-200"
               x-transition:leave-start="translate-x-0 opacity-100"
               x-transition:leave-end="translate-x-full opacity-0"
               class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-4 flex items-start gap-3 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700 transition"
               @click="notification.link ? window.location.href = notification.link : null"
           >
               <span class="text-2xl" x-text="notification.icon"></span>
               <div class="flex-1 min-w-0">
                   <p class="font-bold text-sm text-[#002B5B] dark:text-white" x-text="notification.title"></p>
                   <p class="text-xs text-slate-600 dark:text-slate-400 truncate" x-text="notification.message"></p>
               </div>
               <button
                   @click.stop="$store.notifications.remove(notification.id)"
                   class="text-slate-400 hover:text-slate-600 dark:hover:text-white"
               >
                   <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                   </svg>
               </button>
           </div>
       </template>
   </div>
   ```

8. Include in app layout `resources/views/components/layouts/app.blade.php`:
   ```blade
   <!-- Before </body> -->
   <x-ui.live-notifications />
   ```

**Alternative: Without Pusher (Polling-Based)**
If you don't want to use Pusher, implement with Livewire polling:

1. Create Livewire component `app/Livewire/LiveActivityFeed.php`:
   ```php
   <?php
   namespace App\Livewire;

   use Livewire\Component;
   use App\Models\Word;
   use Illuminate\Support\Facades\Cache;

   class LiveActivityFeed extends Component
   {
       public $lastChecked;
       public $notifications = [];

       public function mount()
       {
           $this->lastChecked = now();
       }

       public function checkForUpdates()
       {
           $newWords = Word::where('created_at', '>', $this->lastChecked)
               ->latest()
               ->take(3)
               ->get();

           foreach ($newWords as $word) {
               $this->dispatch('show-notification', [
                   'title' => 'New Word Added!',
                   'message' => "\"{$word->term}\" was just submitted",
                   'link' => route('word.show', $word->slug),
                   'icon' => '📝'
               ]);
           }

           $this->lastChecked = now();
       }

       public function render()
       {
           return view('livewire.live-activity-feed');
       }
   }
   ```

2. View with polling `resources/views/livewire/live-activity-feed.blade.php`:
   ```blade
   <div wire:poll.10s="checkForUpdates">
       <!-- Empty - just for polling -->
   </div>
   ```

**Files To Create/Modify:**
- `app/Events/NewWordSubmitted.php` (CREATE)
- `app/Events/NewVoteCast.php` (CREATE)
- `resources/js/live-notifications.js` (CREATE)
- `resources/views/components/ui/live-notifications.blade.php` (CREATE)
- `resources/views/components/layouts/app.blade.php` (MODIFY)
- `app/Livewire/SubmitWordForm.php` (MODIFY - dispatch event)
- `app/Livewire/VotingCounter.php` (MODIFY - dispatch event)
- `config/broadcasting.php` (MODIFY)
- `.env` (MODIFY - add Pusher keys)

**Acceptance Criteria:**
- [ ] Toast appears when new word submitted
- [ ] Toast appears when vote cast (optional, can be noisy)
- [ ] Toast slides in from right side
- [ ] Auto-dismisses after 5 seconds
- [ ] Click toast to navigate to word
- [ ] X button to manually dismiss
- [ ] Works on all pages
- [ ] Dark mode compatible
- [ ] Mobile responsive (bottom of screen)

---

## QUICK REFERENCE

### Total Tasks: 43

| Phase | Tasks | Status |
|-------|-------|--------|
| Phase 1: Database | TASK-001 to TASK-005 | 5/5 Done |
| Phase 2: Frontend | TASK-006 to TASK-011 | 6/6 Done |
| Phase 3: Admin | TASK-012 to TASK-017 | 5/6 Done |
| Phase 4: Advanced | TASK-018 to TASK-026 | 7/9 Done |
| Phase 5: Creative/UX | TASK-027 to TASK-043 | 4/17 Done |

### Next Available Tasks (TODO) - No Dependencies:
| Task | Name | Priority |
|------|------|----------|
| TASK-017 | Moderation Queue | HIGH |
| TASK-020 | Vibe-Check Search Page | MEDIUM |
| TASK-023 | Download Sound Bite | MEDIUM |
| TASK-026 | Dark Mode Toggle Button | MEDIUM |
| TASK-027 | Word of the Day | MEDIUM |
| TASK-031 | Skeleton Loading States | HIGH |
| TASK-036 | Animated Number Counters | HIGH |
| TASK-043 | Live Notifications (Freelancer-style) | HIGH |

### UX Enhancements (AI Recommended)
- [ ] Skeleton Loading States (TASK-031)
- [ ] Celebration Animations (TASK-032)
- [ ] Keyboard Shortcuts (TASK-033)
- [ ] Mobile Swipe Gestures (TASK-034)
- [ ] Empty States with Illustrations (TASK-035)
- [x] Animated Number Counters - count up effect (TASK-036) - DONE
- [ ] Card Entrance Animations - fade up staggered (TASK-037)
- [ ] Input Field Animations - floating labels (TASK-038)
- [ ] Mobile Responsive Navigation (TASK-039)
- [ ] Responsive Layouts (TASK-040)
- [ ] Responsive Forms & Inputs (TASK-041)

### In Progress:
| Task | Name | Claimed By |
|------|------|------------|
| TASK-019 | Vertical Feed (TikTok Scroll) | External AI |

### Blocked (Waiting on Dependencies):
| Task | Waiting For |
|------|-------------|
| TASK-010 | TASK-002 (Flags table) |
| TASK-015 | TASK-001 (Categories table) |
| TASK-016 | TASK-004 (Settings table) |
| TASK-017 | TASK-002 (Flags table) |
| TASK-021 | TASK-006 (Domain checker) |
| TASK-023 | TASK-022 (Listen button) |
| TASK-030 | TASK-005 (User roles) |

### Priority Order (Recommended):
```
1. TASK-001 (Categories) ─────────────> Unlocks TASK-015
2. TASK-002 (Flags) ──────────────────> Unlocks TASK-010, TASK-017
3. TASK-004 (Settings) ───────────────> Unlocks TASK-016
4. TASK-005 (Users update) ───────────> Unlocks TASK-030
5. TASK-006 (Domain Checker) ─────────> MONETIZATION - Critical!
6. TASK-022 (Puter.js Audio) ─────────> NEW FEATURE from README
7. TASK-031 (Skeleton Loading) ───────> Better perceived performance
8. TASK-027 (Word of the Day) ────────> Homepage engagement
9. TASK-007 (RFCI Display)
10. TASK-008 (Lore Timeline)
11. TASK-009 (Live View Counter)
12. TASK-024 (Search-to-Submit Inline)
13. TASK-028 (Rising Stars)
14. TASK-034 (Mobile Swipe Gestures)
15. TASK-035 (Empty States)
```

---

## FEATURE CHECKLIST (from README.md)

### Core Features
- [x] Word submission
- [x] Agree/Disagree voting (Facts/Cap)
- [x] Hierarchical definition ranking
- [x] Timeframe sorting (Now/Week/Month)
- [x] Duplicate handling
- [ ] Categories from database (TASK-001)
- [x] Username-only auth
- [ ] Full admin panel (TASK-012 to TASK-017)

### Word Card Requirements (README lines 69-119)
- [x] Word Title (clickable)
- [ ] Live view counter + green dot (TASK-009)
- [ ] "Possible Polar Trend" badge (TASK-009)
- [x] Description with "Read more"
- [x] Agree/Disagree buttons
- [x] Category tag
- [ ] Domain Availability Checker (TASK-006) - MONETIZATION!
- [x] Submit alternate definition
- [ ] RFCI Score display (TASK-007)
- [ ] AI Combined Summary (TASK-018)

### Gemini's 5 Unconventional Features
- [x] Viral Velocity Heatmap (Bento grid)
- [ ] Slang-to-Sticker Generator (TASK-011)
- [ ] Lore Timeline Display (TASK-008)
- [ ] Vibe-Check Search (TASK-020)
- [ ] Investor Dashboard (TASK-021)

### NEW FEATURES (README update)
- [ ] Puter.js Audio - Listen Button (TASK-022)
- [ ] Puter.js Audio - Download Sound Bite (TASK-023)
- [ ] Search-to-Submit Inline Form (TASK-024)
- [ ] Hover Reveal Interactions (TASK-025)
- [ ] Dark Mode with TikTok Colors (TASK-026)
- [ ] Vertical Feed TikTok Scroll (TASK-019 - IN PROGRESS)

### Creative Features (AI Recommended)
- [ ] Word of the Day (TASK-027)
- [ ] Rising Stars Section (TASK-028)
- [ ] Definition Battle Mode (TASK-029)
- [ ] User Badges/Gamification (TASK-030)

### UX Enhancements (AI Recommended)
- [ ] Skeleton Loading States (TASK-031)
- [ ] Celebration Animations (TASK-032)
- [ ] Keyboard Shortcuts (TASK-033)
- [ ] Mobile Swipe Gestures (TASK-034)
- [ ] Empty States with Illustrations (TASK-035)
- [ ] Animated Number Counters - count up effect (TASK-036)
- [ ] Card Entrance Animations - fade up staggered (TASK-037)
- [ ] Input Field Animations - floating labels (TASK-038)

### Technical Requirements
- [ ] wire:poll for live counters (TASK-009)
- [ ] Redis view buffering (future)
- [ ] Polar trend auto-detection (future)

---

## CHANGE LOG

| Date | Task | Action | By |
|------|------|--------|-----|
| 2026-01-12 | TASK-012 to TASK-016 | Admin panel UI/UX improvements - modern styling, toast notifications, consistent headers | Claude Opus 4.5 |
| 2026-01-12 | TASK-036 to TASK-038 | Added animation tasks (counters, cards, inputs) | Claude Architect |
| 2026-01-12 | TASK-027 to TASK-035 | Added creative features & UX tasks | Claude Architect |
| 2026-01-12 | ALL | Added strict AI rules, updated summary | Claude Architect |
| 2026-01-11 | TASK-019 | Started | External AI |
| 2026-01-11 | ALL | Created task board with 26 tasks | Claude Architect |

---

*Last Updated: 2026-01-12*
*Total Tasks: 39 | Completed: 27 | In Progress: 0 | TODO: 12*
