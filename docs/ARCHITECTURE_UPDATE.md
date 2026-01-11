# TikTokDictionary.com - Architectural Update

## 🔄 CRITICAL CHANGE: Alternative Definitions System

Based on client brief review, the architecture has been updated to support **multiple user-submitted definitions per word** (like Urban Dictionary).

---

## Previous Architecture (INCORRECT) ❌

```
Word Table:
- id
- term
- definition (SINGLE)
- agrees
- disagrees
```

**Problem**: Blocked duplicate word submissions. Only one definition per word.

---

## New Architecture (CLIENT REQUIREMENT) ✅

```
Words Table:
- id
- term
- slug
- category
- total_definitions (count)
- total_agrees (sum)
- total_disagrees (sum)
- velocity_score (from top definition)

Definitions Table:
- id
- word_id (FK)
- definition
- example
- submitted_by
- agrees
- disagrees
- velocity_score
- is_primary (most agreed)
```

---

## How It Works Now:

### 1. User Submits "Rizz"
- Check if word exists
- **If YES**: Add new definition to existing word
- **If NO**: Create word + first definition

### 2. Multiple Definitions Per Word
```
Word: "Rizz"
├── Definition 1: "Charisma or charm..." (2,847 agrees) ← PRIMARY
├── Definition 2: "W Rizz means good game..." (543 agrees)
└── Definition 3: "Being smooth with pickup lines..." (201 agrees)
```

### 3. Voting on Definitions
- Each definition has its own agree/disagree count
- Most agreed definition becomes `is_primary = true`
- Word's velocity score = Top definition's velocity score

### 4. Homepage Display
- Shows word with PRIMARY definition
- User can click to see all alternate definitions

---

## Key Changes Made:

### ✅ New Files Created:
1. **`database/migrations/..._create_definitions_table.php`**
   - Separate table for user definitions
   - One-to-many relationship with words

2. **`app/Models/Definition.php`**
   - Velocity algorithm per definition
   - Auto-check if primary (most agreed)
   - Updates parent word stats

### ✅ Updated Files:
1. **`database/migrations/..._create_words_table.php`**
   - Removed single definition field
   - Added aggregate fields (total_definitions, total_agrees, total_disagrees)

2. **`app/Models/Word.php`**
   - Added relationships: `definitions()`, `primaryDefinition()`
   - Added `recalculateStats()` method
   - Updated trending methods with timeframe filters (now, week, month)

---

## Client Requirements Now Addressed:

✅ **Multiple definitions per word** - Users can submit alternatives
✅ **Agree/disagree per definition** - Each definition voted separately  
✅ **Most agreed shows first** - `is_primary` flag + ordering  
✅ **Timeframe sorting** - Trending now, this week, this month  
✅ **High contribution ranking** - Words with more definitions + votes rank higher

---

## Next Steps:

### Livewire Components to Update:
1. **`SubmitWordForm.php`**
   - Change logic: Instead of blocking duplicates, offer "Add definition to existing word"
   - If word exists, create Definition (not Word)

2. **`VotingCounter.php`**
   - Vote on Definition (not Word)
   - Update: `Definition::find($definitionId)`

3. **Homepage Blade**
   - Display `$word->primaryDefinition->definition`
   - Show "3 other definitions" link

### New Components Needed:
4. **`AlternateDefinitions.php`**
   - Display all definitions for a word
   - Ordered by agrees DESC
   - Each with own voting counter

---

## Visual Flow Update:

### Scenario: User searches "Rizz"

**Before (Wrong):**
- Word found → Block submission → Show "already exists" error

**Now (Correct):**
- Word found → Show primary definition
- Button: "Add your own definition" 
- Opens form with word pre-filled
- Submits new definition to same word
- Definitions ranked by agrees

---

## Files Ready for Update:
- [x] Database migrations (updated)
- [x] Word model (updated) 
- [x] Definition model (created)
- [ ] SubmitWordForm Livewire (needs update)
- [ ] VotingCounter Livewire (needs update)
- [ ] Homepage Blade (needs update)
- [ ] AlternateDefinitions component (needs creation)

---

This architectural change aligns perfectly with the client's requirement: **"Other users will be able to provide alternate definitions to the same words."**

The velocity algorithm, optimistic UI, and Gen-Z copy remain intact. The core difference is now allowing multiple user contributions per word, just like Urban Dictionary.
