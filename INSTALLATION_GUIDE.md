# TikTokDictionary - Setup Instructions

## ✅ What's Been Created

**Laravel 11 Application** with the following components:

### Database Architecture
- **Migrations:**
  - `2026_01_10_000001_create_words_table.php` - Stores unique words with aggregate stats
  - `2026_01_10_000002_create_definitions_table.php` - Stores multiple definitions per word

### Models
- **Word Model** (`app/Models/Word.php`)
  - Relationships: `definitions()`, `primaryDefinition()`
  - Methods: `getTrending()`, `fuzzySearch()`, `findSimilar()`, `recalculateStats()`
  
- **Definition Model** (`app/Models/Definition.php`)
  - Velocity algorithm: `(Agrees - Disagrees) / (HoursOld + 2)^1.5`
  - Methods: `updateVelocityScore()`, `checkIfPrimary()`

### Livewire Components
- **VotingCounter** (`app/Livewire/VotingCounter.php`)
  - Optimistic UI with instant feedback
  - Cookie-based vote persistence (7 days)
  - Vote/unvote/change vote functionality

- **SearchBar** (`app/Livewire/SearchBar.php`)
  - Fuzzy search with SOUNDEX phonetic matching
  - Live search with debounce
  - Dropdown results with auto-complete

- **SubmitWordForm** (`app/Livewire/SubmitWordForm.php`)
  - Duplicate detection with suggestions
  - Add definitions to existing words
  - Form validation and success feedback

### Views
- **Homepage** (`resources/views/welcome.blade.php`)
  - Bento Grid layout with 7 different card patterns
  - Glassmorphism design with gradient backgrounds
  - Responsive (mobile, tablet, desktop)
  - Dynamic loading from database

- **Livewire Views:**
  - `resources/views/livewire/voting-counter.blade.php`
  - `resources/views/livewire/search-bar.blade.php`
  - `resources/views/livewire/submit-word-form.blade.php`

### Database Seeder
- **WordSeeder** (`database/seeders/WordSeeder.php`)
  - 11 trending words with 16 total definitions
  - Realistic vote counts (89 to 5,692 agrees)
  - Time offsets for velocity calculation
  - Words: Rizz, Delulu, Slay, FR FR, Bussin, No Cap, Mid, Sigma, Simp, Ate, Understood the Assignment

---

## 🚨 Current Issue: Composer Installation

The vendor directory installation failed due to **Windows Defender/Antivirus file locking**.

### Solution Options:

#### Option 1: Temporarily Disable Antivirus (Recommended)
1. **Disable Windows Defender Real-time Protection:**
   - Open Windows Security
   - Go to "Virus & threat protection"
   - Click "Manage settings"
   - Turn OFF "Real-time protection"

2. **Run Composer Install:**
   ```powershell
   cd d:\xampp\htdocs\tiktokdictionary
   d:\xampp\php\php.exe d:\xampp\htdocs\carriergo\composer.phar install --no-scripts
   ```

3. **Re-enable Windows Defender**

#### Option 2: Add Exclusion to Windows Defender
1. Open Windows Security
2. Go to "Virus & threat protection" > "Manage settings"
3. Scroll to "Exclusions" and click "Add or remove exclusions"
4. Add folder: `d:\xampp\htdocs\tiktokdictionary\vendor`
5. Run composer install

#### Option 3: Use Different Composer Method
```powershell
cd d:\xampp\htdocs\tiktokdictionary
d:\xampp\php\php.exe d:\xampp\htdocs\carriergo\composer.phar install --prefer-source --no-scripts --no-plugins
```

---

## 📝 Complete Setup Steps

Once vendor packages are installed:

### 1. Configure Environment
```powershell
cd d:\xampp\htdocs\tiktokdictionary
copy .env.example .env
```

Edit `.env` file:
```env
APP_NAME=TikTokDictionary
APP_URL=http://localhost/tiktokdictionary

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tiktokdictionary
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Generate Application Key
```powershell
d:\xampp\php\php.exe artisan key:generate
```

### 3. Create Database
Open phpMyAdmin or MySQL command line:
```sql
CREATE DATABASE tiktokdictionary CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Run Migrations
```powershell
d:\xampp\php\php.exe artisan migrate
```

### 5. Seed Database
```powershell
d:\xampp\php\php.exe artisan db:seed --class=WordSeeder
```

### 6. Install NPM Packages & Build Assets
```powershell
& 'C:\Program Files\nodejs\npm.cmd' install
& 'C:\Program Files\nodejs\npm.cmd' run build
```

### 7. Start Development Server
```powershell
d:\xampp\php\php.exe artisan serve
```

Visit: `http://localhost:8000`

---

## 🎨 Features Implemented

✅ **Bento Grid Homepage** - Unconventional layout with varying card sizes
✅ **Voting System** - Optimistic UI with cookie persistence
✅ **Trending Algorithm** - Velocity-based ranking with time decay
✅ **Fuzzy Search** - SOUNDEX phonetic matching
✅ **Word Submission** - With duplicate detection
✅ **Alternative Definitions** - Multiple users can define same word
✅ **Glassmorphism Design** - Modern UI with backdrop blur
✅ **Responsive Layout** - Mobile, tablet, desktop optimized
✅ **Sample Data** - 11 words with realistic engagement

---

## 🔧 Troubleshooting

### If migrations fail:
```powershell
d:\xampp\php\php.exe artisan migrate:fresh
```

### If Livewire not working:
```powershell
d:\xampp\php\php.exe artisan livewire:publish --config
d:\xampp\php\php.exe artisan livewire:publish --assets
```

### If styles not loading:
```powershell
& 'C:\Program Files\nodejs\npm.cmd' run dev
```
Leave this running in a separate terminal while developing.

### Clear caches:
```powershell
d:\xampp\php\php.exe artisan cache:clear
d:\xampp\php\php.exe artisan config:clear
d:\xampp\php\php.exe artisan view:clear
```

---

## 📚 Next Steps (Phase 2)

After testing the current implementation:

1. **Word Detail Page** - Show all definitions for a word
2. **Timeframe Filters** - "Trending Now" / "This Week" / "This Month" buttons
3. **User Authentication** - Login/register system
4. **Admin Panel** - Moderate words and definitions
5. **API Endpoints** - For mobile app integration
6. **Social Sharing** - Share definitions to TikTok/Twitter

---

## 🎯 Testing Checklist

Once server is running:

- [ ] Homepage loads with 11 sample words
- [ ] Bento Grid shows different card sizes
- [ ] Click thumbs up/down to vote (counts update instantly)
- [ ] Voting persists on page reload (cookies work)
- [ ] Search bar shows results as you type
- [ ] Submit new word form validates input
- [ ] Similar words detected on submission
- [ ] Can add alternative definition to existing word
- [ ] Mobile responsive (test on narrow browser window)

---

## 💡 Architecture Highlights

- **Multi-definition System**: One word → Many definitions (like Urban Dictionary)
- **Primary Definition**: Most agreed definition marked as primary
- **Velocity Scoring**: Recent + popular definitions rank higher
- **Optimistic UI**: Vote button responds instantly, syncs in background
- **Cookie Voting**: No login required, 7-day vote memory
- **SOUNDEX Search**: Finds words even with typos (e.g., "riz" finds "rizz")

---

## 📦 Dependencies

**PHP Packages (composer.json):**
- laravel/framework: ^11.0
- livewire/livewire: ^3.7

**NPM Packages (package.json):**
- tailwindcss: ^3.0
- alpinejs: ^3.0
- vite: ^5.0

All dependencies already configured, just need successful vendor install.

---

## 🆘 Need Help?

If still having issues with vendor installation:

1. Try running composer from different terminal (CMD instead of PowerShell)
2. Check if other Laravel projects (carriergo) have working vendor folder to copy from
3. Download Composer globally: https://getcomposer.org/Composer-Setup.exe
4. Consider using WSL2 (Windows Subsystem for Linux) for better compatibility

---

**Created:** January 10, 2026
**Laravel Version:** 11.47.0
**Livewire Version:** 3.7.3
**PHP Version Required:** 8.2+
