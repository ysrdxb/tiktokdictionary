# User Requirements Document (URD) - TikTokDictionary

## 1. High Level Overview
TikTokDictionary is a community-driven, dynamic glossary designed to track, define, and archive the rapidly evolving language of the internet (specifically TikTok and Gen-Z slang). Unlike traditional dictionaries, it operates on a "Velocity" model where terms are ranked by current relevance and viral trend status, not just alphabetical order.

**Core Concept:** "The Urban Dictionary for the TikTok Era, but Premium."

**Key Mechanics:**
*   **Crowdsourced data**: Users submit words, definitions, and usage examples.
*   **Democratic Validation**: A reddit-style "Agree/Disagree" voting system determines the most accurate definition for a word.
*   **Trend Tracking**: A dedicated "Trending" algorithm highlights words that are spiking in usage (Today, This Week, This Month).
*   **Premium Aesthetic**: A glassmorphism-based, high-fidelity UI that treats slang with the visual respect of a high-end fashion brand.

---

## 2. User Flows

### A. The "Explorer" (Guest/Viewer)
*   **Goal**: Find the meaning of a specific slang term or discover what is currently popular.
*   **Flow**:
    1.  Lands on **Homepage**.
    2.  Sees "Word of the Day" and "Trending Now" sections.
    3.  Uses **Search Bar** to find a specific term (e.g., "Mewing").
    4.  Arrives at **Word Detail Page**.
    5.  Reads top-rated definition and usage examples.
    6.  (Optional) Clicks "Live Feed" to see real-time submissions.

### B. The "Contributor" (Registered User)
*   **Goal**: Add a missing word or define an existing one better.
*   **Flow**:
    1.  Logs in via **Login Page**.
    2.  Clicks **"Submit Word"**.
    3.  **Step 1**: Enters the Word (System checks for duplicates instantly).
    4.  **Step 2**: Enters Definition, Example usage, and Categories.
    5.  **Step 3**: Reviews and Submits.
    6.  System validates content (basic profanity/spam check).
    7.  Word goes to **Moderation Queue** (or auto-publishes based on reputation).

### C. The "Judge" (Community Voter)
*   **Goal**: Validate correct logic and bury spam/bias.
*   **Voting**:
    *   Users see "Agree" (Up) and "Disagree" (Down) buttons on every definition.
    *   Higher net votes push a definition to the top of the Word Detail page.

### D. The "Administrator"
*   **Goal**: Maintain quality and manage the platform.
*   **Flow**:
    1.  Accesses **Admin Dashboard**.
    2.  Reviews **Flagged/Reported** content.
    3.  Manages **Users** (ban/mute).
    4.  Configures site-wide settings (Maintenance Mode, Announcement Banners).

---

## 3. Screens / Pages Needed

### Core Public Pages
1.  **Homepage (`/`)**: High-impact "Word of the Day", Search Hero, and Trending Lists (Velocity-based).
2.  **Live Feed (`/feed`)**: A TikTok-style vertical scroll of the newest approved definitions.
3.  **Browse / Dictionary (`/browse`)**: A-Z filtered list, searchable and sortable by category.
4.  **Word Detail (`/word/{slug}`)**: The "Wiki" page for a specific word. Shows the word, its pronunciation (optional), and list of user-submitted definitions ordered by votes.
5.  **User Profile (`/u/{username}`)**: Shows a user's submitted words, total reputation score, and badges.

### Auth Pages
6.  **Login (`/login`)**: Premium glass-card interface.
7.  **Register (`/register`)**: Account creation flow.

### User Interaction
8.  **Submit Word (`/submit`)**: Multi-step form for contributing data.
9.  **Edit Submission**: Allow users to fix typos in their own unapproved content.

### Admin / Utility
10. **Admin Dashboard**: Stats overview.
11. **Moderation Queue**: Rapid-fire interface to Approve/Reject new words.
12. **Maintenance Page**: "We'll Be Back Soon" screen (with Admin bypass).

---

## 4. Expected Bottlenecks & Solutions

### A. Content Quality & Spam (The "Urban Dictionary Problem")
*   **Bottleneck**: Users submitting "inside jokes" (names of their friends) or hate speech.
*   **Solution**:
    *   **Pre-Moderation**: All new words require Approval before appearing in search (MVP).
    *   **Post-Moderation**: "Report" button on every definition.
    *   **AI Filtering**: Integrate basic keyword blocking for hate speech (already partially implemented).

### B. Duplicate Entries
*   **Bottleneck**: Users submitting "Rizz", "Rizzing", and "Rizzes" as separate entries, diluting the SEO and voting power.
*   **Solution**:
    *   **Normalization**: The system converts all inputs to lowercase/trimmed before checking.
    *   **"Did you mean?"**: During submission, if a user types typical duplicates, show "This word already exists" and redirect them to *add a definition* to the existing word instead of creating a new page.

### C. Search Performance
*   **Bottleneck**: As the database grows to 10k+ words, `LIKE %...%` queries will become slow.
*   **Solution**:
    *   **Indexing**: Ensure `slug` and `word` columns are indexed.
    *   **Scout/Algolia**: For Phase 2, implement full-text search (Laravel Scout). For MVP, basic SQL optimization is sufficient.

### D. Mobile Navigation (Recently Fixed)
*   **Bottleneck**: Complex menus getting cut off on small screens or stuck under hero banners.
*   **Solution**:
    *   **Teleporting**: Implementation of `x-teleport` technology to physically move menu DOM elements to the top level, ensuring they always overlay content regardless of z-index contexts.

### E. Visual Consistency ("Vibe Coding" Risk)
*   **Bottleneck**: Inconsistent fonts and low-effort UI elements making the site look amateur.
*   **Solution**:
    *   **Design System**: Strict adherence to "Grifter" for headers and specific styling for body text.
    *   **Component Library**: Use reusable Blade components (`<x-input>`, `<x-button>`) to ensure every single input field on the site looks identical and premium.
