# TikTokDictionary.com - Requirements Documentation

## Project Overview
TikTokDictionary.com is a user-powered, community-driven dictionary platform for social media slang and internet culture terminology. The platform enables users to discover, vote on, and contribute definitions for emerging slang terms.

---

## 1. Functional Requirements

### 1.1 User Interface Requirements

#### FR-1.1: Homepage Display
- **Description**: Display a Bento Grid layout with asymmetric word cards
- **Acceptance Criteria**:
  - Cards must vary in size (1x1, 2x1, 2x2, 1x2)
  - Each card displays: word, definition, category badge, vote counts, timestamp
  - Cards must animate on scroll with fade-in-up effect
  - Layout must be responsive across mobile, tablet, and desktop

#### FR-1.2: Dark Mode Theme
- **Description**: Implement dark mode design system
- **Acceptance Criteria**:
  - Background color: #09090b
  - Use glassmorphism effect (backdrop-blur-md)
  - Subtle borders with white/10 opacity
  - TikTok Pink (#FE2C55) and Cyan (#25F4EE) accent colors

#### FR-1.3: Search Functionality
- **Description**: Provide real-time search with fuzzy matching
- **Acceptance Criteria**:
  - Pill-shaped search bar with icon
  - Debounced search (300ms)
  - Display top 5 results in dropdown
  - Show "No results" with CTA to submit new word
  - Search must work on: exact match, partial match, phonetic match, definition content

### 1.2 Voting System Requirements

#### FR-2.1: Optimistic UI Voting
- **Description**: Enable instant vote feedback without page refresh
- **Acceptance Criteria**:
  - Clicking "No Cap" (Agree) updates UI immediately
  - Clicking "Cap" (Disagree) updates UI immediately
  - Backend persistence happens asynchronously
  - Loading state shown during server sync
  - Vote animation feedback (scale, color change)

#### FR-2.2: Vote State Management
- **Description**: Track and persist user votes
- **Acceptance Criteria**:
  - Cookie-based vote tracking (7-day expiry)
  - Users can change their vote
  - Users can remove their vote by clicking same button
  - Vote count updates reflect on all cards in real-time

#### FR-2.3: Vote Display
- **Description**: Visual representation of voting data
- **Acceptance Criteria**:
  - Display total agree count
  - Display total disagree count
  - Show vote percentage bar (gradient from cyan to pink)
  - Display total vote count
  - Format numbers with commas (e.g., 2,847)

### 1.3 Word Submission Requirements

#### FR-3.1: Submit Form
- **Description**: Allow users to submit new words
- **Acceptance Criteria**:
  - Modal overlay with glassmorphism design
  - Required fields: Term, Definition, Submitted By
  - Optional fields: Example, Category
  - Character limits: Term (50), Definition (500), Example (200)
  - Category dropdown with 9 options
  - Form validation with Gen-Z friendly error messages

#### FR-3.2: Duplicate Detection
- **Description**: Prevent duplicate word submissions
- **Acceptance Criteria**:
  - Real-time fuzzy search as user types term (500ms debounce)
  - Display up to 3 similar existing words
  - Show warning banner with similar words
  - Provide "Add to this" button for each similar word
  - Block exact duplicates on submission
  - Use SOUNDEX phonetic matching

#### FR-3.3: Submission Success
- **Description**: Confirm successful word submission
- **Acceptance Criteria**:
  - Show success message with animation
  - Auto-close modal after 2 seconds
  - Reset form fields
  - Emit event to refresh homepage word list
  - Display "Lore Dropped Successfully!" message

### 1.4 Trending Algorithm Requirements

#### FR-4.1: Velocity Score Calculation
- **Description**: Implement trending algorithm
- **Formula**: `Score = (Agrees - Disagrees) / (HoursOld + 2)^1.5`
- **Acceptance Criteria**:
  - Recalculate score on every vote
  - Store velocity_score in database
  - Default score: 0 for new words
  - New words get boosted visibility (+2 hours buffer)
  - Old content gradually decays (^1.5 decay curve)

#### FR-4.2: Content Ordering
- **Description**: Multiple sort options for word lists
- **Acceptance Criteria**:
  - Trending: Order by velocity_score DESC
  - Viral: Order by agrees DESC
  - New: Order by created_at DESC
  - Category: Filter + order by velocity_score DESC

---

## 2. Non-Functional Requirements

### 2.1 Performance Requirements

#### NFR-1.1: Page Load Time
- **Target**: < 2 seconds for initial page load
- **Strategy**: 
  - Use Tailwind CDN for rapid development (production: compile CSS)
  - Lazy load word cards below fold
  - Implement Alpine.js for lightweight interactivity

#### NFR-1.2: Search Response Time
- **Target**: < 300ms for search results
- **Strategy**:
  - Database indexes on: term, velocity_score, agrees, created_at
  - Full-text index on term and definition
  - Limit results to 5 per search

#### NFR-1.3: Vote Response Time
- **Target**: < 100ms for optimistic UI update, < 500ms for server confirmation
- **Strategy**:
  - Livewire optimistic updates
  - Background AJAX persistence
  - Cookie-based state management

### 2.2 Scalability Requirements

#### NFR-2.1: Database Scalability
- **Target**: Support 100,000+ words, 1M+ votes
- **Strategy**:
  - Indexed foreign keys
  - Efficient query patterns (avoid N+1)
  - Periodic velocity score recalculation (cron job)

#### NFR-2.2: Concurrent Users
- **Target**: Support 1,000 concurrent users
- **Strategy**:
  - Stateless Livewire components
  - Cookie-based vote tracking (no auth required)
  - Database connection pooling

### 2.3 Usability Requirements

#### NFR-3.1: Gen-Z Language
- **Requirement**: All copy must use Gen-Z friendly terminology
- **Examples**:
  - "Drop the Lore" instead of "Submit"
  - "No Cap" instead of "Agree"
  - "Cap" instead of "Disagree"
  - "FR FR" instead of "For Real"
  - Error messages: "What's the word? 🤔" instead of "Field required"

#### NFR-3.2: Mobile-First Design
- **Requirement**: Fully responsive, optimized for mobile
- **Breakpoints**:
  - Mobile: < 640px (1 column grid)
  - Tablet: 640-1024px (2 column grid)
  - Desktop: > 1024px (4 column grid)

#### NFR-3.3: Accessibility
- **Target**: WCAG 2.1 AA compliance
- **Requirements**:
  - Sufficient color contrast (dark mode optimized)
  - Keyboard navigation support
  - ARIA labels on interactive elements
  - Focus indicators on buttons/inputs

### 2.4 Security Requirements

#### NFR-4.1: Input Validation
- **Requirement**: Sanitize all user inputs
- **Strategy**:
  - Laravel validation rules on all forms
  - XSS protection via Blade escaping
  - SQL injection prevention via Eloquent ORM
  - Max length enforcement on all text fields

#### NFR-4.2: Rate Limiting
- **Requirement**: Prevent spam submissions
- **Strategy** (Future Implementation):
  - Max 5 submissions per hour per IP
  - Max 20 votes per minute per IP
  - CAPTCHA for high-frequency users

#### NFR-4.3: Content Moderation
- **Requirement**: Prevent offensive content
- **Strategy** (Future Implementation):
  - Profanity filter on submissions
  - Community reporting system
  - Admin verification flag (is_verified)
  - Automated content flagging

### 2.5 Browser Compatibility

#### NFR-5.1: Supported Browsers
- Chrome 90+ (primary target)
- Safari 14+
- Firefox 88+
- Edge 90+
- Mobile Safari (iOS 14+)
- Chrome Mobile (Android 10+)

#### NFR-5.2: Progressive Enhancement
- Core functionality works without JavaScript
- Enhanced UX with Alpine.js enabled
- Fallback for no backdrop-filter support

---

## 3. Data Requirements

### 3.1 Word Entity
```
- id: Primary key
- term: String (unique, indexed, max 100 chars)
- slug: String (unique, indexed, max 150 chars)
- definition: Text (max 500 chars)
- example: String (nullable, max 200 chars)
- category: String (enum, indexed)
- submitted_by: String (max 100 chars, username/handle)
- agrees: Integer (default 0, indexed)
- disagrees: Integer (default 0)
- velocity_score: Decimal (10,4) (indexed)
- is_verified: Boolean (default false)
- created_at: Timestamp (indexed)
- updated_at: Timestamp
```

### 3.2 Category Options
1. TikTok
2. Instagram
3. Twitter / X
4. Snapchat
5. Gen-Z
6. AAVE
7. Gaming
8. Anime
9. Other

---

## 4. API Requirements (Future Phase)

### 4.1 Public API Endpoints
- `GET /api/words` - List words (paginated)
- `GET /api/words/{slug}` - Get single word
- `GET /api/trending` - Get trending words
- `GET /api/search?q={query}` - Search words
- `POST /api/words` - Submit new word (rate limited)
- `POST /api/words/{id}/vote` - Vote on word

### 4.2 API Response Format
```json
{
  "success": true,
  "data": {
    "id": 1,
    "term": "Rizz",
    "definition": "Charisma or charm...",
    "agrees": 2847,
    "disagrees": 143,
    "velocity_score": 124.5678
  }
}
```

---

## 5. Integration Requirements

### 5.1 Required Laravel Packages
- **Livewire 3.x**: For reactive components
- **Tailwind CSS 3.x**: For utility-first styling
- **Alpine.js 3.x**: For lightweight interactivity

### 5.2 Optional Future Integrations
- Social media authentication (TikTok, Twitter, Google)
- Email notifications for popular submissions
- Analytics (Google Analytics / Plausible)
- Content Delivery Network (CDN) for static assets

---

## 6. Deployment Requirements

### 6.1 Server Requirements
- PHP 8.1+
- MySQL 8.0+ or PostgreSQL 14+
- Composer 2.x
- Node.js 18+ (for build tools)
- Apache/Nginx web server

### 6.2 Environment Configuration
- `.env` file with database credentials
- APP_URL configured
- APP_DEBUG=false in production
- CSRF protection enabled
- Session driver: database or redis

---

## 7. Testing Requirements

### 7.1 Unit Tests
- Word model methods (velocity calculation, fuzzy search)
- Livewire component logic (voting, form submission)
- Helper functions

### 7.2 Feature Tests
- Submit word flow (success, duplicate detection)
- Voting flow (optimistic UI, persistence)
- Search functionality (exact, fuzzy, phonetic)

### 7.3 Browser Tests
- End-to-end user flows (Dusk)
- Mobile responsiveness
- Cross-browser compatibility

---

## 8. Documentation Requirements

### 8.1 User Documentation
- How to search for words
- How to vote on definitions
- How to submit new words
- Community guidelines

### 8.2 Developer Documentation
- Setup instructions
- Database schema
- API documentation
- Deployment guide

---

## Priority Matrix

### Must Have (Milestone 1) ✅
- Bento Grid UI
- Voting system with optimistic UI
- Search with fuzzy matching
- Word submission form
- Velocity algorithm
- Duplicate detection

### Should Have (Milestone 2)
- User authentication
- User profiles
- Alternative definitions
- Comment system
- Admin panel

### Could Have (Milestone 3)
- Public API
- Mobile apps
- Social sharing
- Trending notifications
- Bookmarking/favorites

### Won't Have (Out of Scope)
- Video content
- Paid subscriptions
- Advertising platform
- Multi-language support (v1)
