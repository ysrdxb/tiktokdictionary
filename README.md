# TikTokDictionary

A community-powered dictionary tracking viral slang and new trends across TikTok and online culture. Built with Laravel 11, Livewire 3, Alpine.js, and Tailwind CSS.

## Features

- **User-Powered Dictionary**: Users submit words, definitions, and examples.
- **Voting System**: 'Agree' / 'Disagree' voting logic ranks definitions.
- **Smart Duplicate Detection**: Live checking prevents duplicate entries (Exact vs Similar logic).
- **Trend Discovery**: Homepage ranks words by 'velocity_score' (Trending Today, Week, Month).
- **Custom UI**: Figma-faithful implementation with custom fonts (Grifter) and glassmorphism.

## Tech Stack

- **Backend**: Laravel 11 (PHP 8.2+)
- **Frontend**: Blade + Livewire 3 + Alpine.js
- **Styling**: Tailwind CSS
- **Database**: SQLite (Default) / MySQL

## Installation

1.  **Clone the repository**:
    ```bash
    git clone https://github.com/ysrdxb/tiktokdictionary.git
    cd tiktokdictionary
    ```

2.  **Install PHP Dependencies**:
    ```bash
    composer install
    ```

3.  **Install JS Dependencies**:
    ```bash
    npm install
    npm run build
    ```

4.  **Database Setup**:
    Copy `.env.example` to `.env` and configure your database.
    ```bash
    cp .env.example .env
    php artisan key:generate
    php artisan migrate:fresh --seed
    ```

5.  **Run Development Server**:
    ```bash
    php artisan serve
    ```

## Project Structure

- `app/Livewire/`: Core interactive components (SubmitForm, Search, Voting).
- `app/Models/Word.php`: Logic for trending & velocity scores.
- `resources/views/`: Blade templates matching Figma design.

## License

MIT License.
