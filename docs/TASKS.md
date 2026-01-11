# TikTokDictionary - AI Task Board

**Last Updated**: 2026-01-11
**Purpose**: Central task management for multiple AI assistants

---

## RULES FOR AI ASSISTANTS

### Before Starting Any Task:
1. Read this ENTIRE file first
2. Check if task status is `TODO` (only work on TODO tasks)
3. Change status to `IN_PROGRESS` and add your session ID before starting
4. Do NOT touch tasks marked `IN_PROGRESS` or `DONE`

### After Completing a Task:
1. Change status to `DONE`
2. Add completion date
3. List files you created/modified
4. Move to next TODO task

### If You Get Interrupted:
1. If task is incomplete, leave status as `IN_PROGRESS`
2. Add note about what's left to do
3. Next AI can continue from there

---

## TASK STATUS LEGEND

| Status | Meaning |
|--------|---------|
| `TODO` | Not started - available to work on |
| `IN_PROGRESS` | Someone is working on it - DO NOT TOUCH |
| `DONE` | Completed and tested |
| `BLOCKED` | Waiting on another task |

---

## PHASE 1: DATABASE FOUNDATION

### TASK-001: Create Categories Table
```
Status: TODO
Priority: CRITICAL
Claimed By: -
Started: -
Completed: -
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
Status: TODO
Priority: CRITICAL
Claimed By: -
Started: -
Completed: -
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

### TASK-003: Create Activity Logs Table
```
Status: TODO
Priority: HIGH
Claimed By: -
Started: -
Completed: -
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
Status: TODO
Priority: HIGH
Claimed By: -
Started: -
Completed: -
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
Status: TODO
Priority: CRITICAL
Claimed By: -
Started: -
Completed: -
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
Status: TODO
Priority: CRITICAL (MONETIZATION)
Claimed By: -
Started: -
Completed: -
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
Status: TODO
Priority: HIGH
Claimed By: -
Started: -
Completed: -
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
Status: TODO
Priority: HIGH
Claimed By: -
Started: -
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
Status: TODO
Priority: HIGH
Claimed By: -
Started: -
Completed: -
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
Status: TODO
Priority: CRITICAL
Claimed By: -
Started: -
Completed: -
Depends On: TASK-001, TASK-002, TASK-003
```

**What To Build:**
Main admin dashboard with stats and activity feed.

[Detailed specs in Section 4 of claude_architect.md]

---

### TASK-013: Admin Words Table Component
```
Status: TODO
Priority: CRITICAL
Claimed By: -
Started: -
Completed: -
```

**What To Build:**
Searchable, sortable words table with bulk actions.

[Detailed specs in Section 4 of claude_architect.md]

---

### TASK-014: Admin Users Table Component
```
Status: TODO
Priority: CRITICAL
Claimed By: -
Started: -
Completed: -
Depends On: TASK-005
```

**What To Build:**
User management with roles and ban functionality.

[Detailed specs in Section 4 of claude_architect.md]

---

### TASK-015: Admin Categories Manager
```
Status: TODO
Priority: HIGH
Claimed By: -
Started: -
Completed: -
Depends On: TASK-001
```

**What To Build:**
CRUD interface for categories.

[Detailed specs in Section 4 of claude_architect.md]

---

### TASK-016: Admin Settings Page
```
Status: TODO
Priority: HIGH
Claimed By: -
Started: -
Completed: -
Depends On: TASK-004
```

**What To Build:**
Site settings management interface.

[Detailed specs in Section 4 of claude_architect.md]

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

*Last Updated: 2026-01-11*
*Total Tasks: 26 | Completed: 0 | In Progress: 1 | TODO: 25*
