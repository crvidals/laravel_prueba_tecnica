# Player Notes — Technical Test

## Description

Laravel 12 application with a **Player Notes** module that allows authorized support agents to view and create notes for players. Built with Livewire 3 for real-time interactivity, repository pattern for data access, and policy-based authorization.

## Technologies

- **Laravel** 12.x (framework ^12.0)
- **PHP** ^8.2
- **Livewire** ^3.8
- **MySQL** 8.0 (via Docker)
- **Nginx** (alpine, via Docker)
- **Docker Compose** (3 services: app, nginx, db)
- **PHPUnit** ^11.5
- **Laravel Breeze** (Blade + Alpine.js auth scaffolding)
- **Tailwind CSS** (via Vite)
- **Node.js / npm** (for Vite asset compilation)

## Architecture

- **Repository Pattern** — `PlayerNoteRepositoryInterface` bound to `PlayerNoteRepository` via dependency injection in `AppServiceProvider`.
- **Livewire Components** — `PlayerNotes` component handles mounting with a player ID, validation, authorization, and rendering via the repository. Embedded in a standard Blade view (not a full-page component).
- **Authorization** — `PlayerNotePolicy` with a single `create()` gate that checks the `can_create_notes` boolean column on the `users` table. Registered in `AuthServiceProvider`.
- **Eloquent Models** — `Player` (hasMany notes), `PlayerNote` (belongsTo Player/User), `User` (hasMany notes, `can_create_notes` boolean cast).
- **Migrations** — `players` table, `player_notes` table (foreign keys with `cascadeOnDelete`), and `add_can_create_notes_to_users` column migration.
- **Seeders** — `UserSeeder`, `PlayerSeeder`, `PlayerNoteSeeder` chained in `DatabaseSeeder`.
- **Feature Tests** — `PlayerNoteCreationTest` asserts an authorized user can create a note via Livewire and that it persists in the database.

## Requirements

- Git
- Docker Desktop (for Docker setup)
- **or** PHP ^8.2 + Composer + Node.js / npm (for local setup)
- PHP extensions: `pdo_mysql`, `mbstring`, `exif`, `pcntl`, `bcmath`, `gd`

## Installation

### Option A — Docker (recommended)

```bash
# 1. Clone the repository
git clone <repository-url> laravel_prueba_tecnica
cd laravel_prueba_tecnica

# 2. Copy environment file
cp .env.example .env

# 3. Build and start containers
docker compose up -d --build

# 4. Run migrations and seeders
docker compose exec app php artisan migrate --seed

# 5. Compile frontend assets
docker compose exec app npm install
docker compose exec app npm run build
```

The application will be available at `http://localhost`.

> **Note:** The container entrypoint (`docker/entrypoint.sh`) automatically runs `composer install`, copies `.env.example` to `.env`, generates `APP_KEY`, and runs `php artisan migrate --force` on startup. The `--seed` flag and frontend build must be executed explicitly.

### Option B — Local (without Docker)

```bash
# 1. Clone the repository
git clone <repository-url> laravel_prueba_tecnica
cd laravel_prueba_tecnica

# 2. Copy environment file
cp .env.example .env

# 3. Configure .env for SQLite (replace MySQL block)
#    DB_CONNECTION=sqlite
#    SESSION_DRIVER=file
#    QUEUE_CONNECTION=sync
#    CACHE_STORE=file

# 4. Install PHP dependencies
composer install

# 5. Generate application key
php artisan key:generate

# 6. Create SQLite database
touch database/database.sqlite

# 7. Install and build frontend assets
npm install
npm run build

# 8. Run migrations and seeders
php artisan migrate --seed

# 9. Start the development server
php -S 127.0.0.1:8080 -t public server.php
```

The application will be available at `http://127.0.0.1:8080`.

> **Note:** The `server.php` router script is required to correctly handle Livewire POST requests with PHP's built-in server.

## Execution

Once the server is running:

1. Register a new user at `/register` or log in at `/login` with a seeded user.
2. Navigate to `/players` to see the list of players.
3. Click **View Notes** on any player to access their notes.
4. If authorized (`can_create_notes = true`), a form will be visible to add new notes.

### Navigation flow

```
/login  →  /players  →  /players/{player}/notes  →  ← Back to Players
```

## Routes

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/players` | `players.index` | Player list (ID, Name, Notes count, View Notes) |
| GET | `/players/{player}/notes` | `players.notes` | Player notes history + form |

## Test Data

Run `php artisan migrate --seed` to populate the database with:

### Users

| Name | Email | Password | Permissions |
|------|-------|----------|-------------|
| Alice Johnson | agent@example.com | password | Can create notes |
| Bob Martinez | supervisor@example.com | password | Can create notes |

Both users have `can_create_notes = true`. Newly registered users default to `can_create_notes = false`.

### Players

ShadowStrike, LunarWolf, BlazeFury, StormChaser, NightHawk.

### Notes

3 to 6 notes per player (15–30 total), each assigned to a random user, with varied creation dates and realistic support-ticket content.

## Running Tests

```bash
# Docker
docker compose exec app php artisan test

# Local
php artisan test
```

Tests run with an in-memory SQLite database (`phpunit.xml` sets `DB_CONNECTION=sqlite` and `DB_DATABASE=:memory:`).

## Project Structure

```
app/
├── Livewire/
│   └── PlayerNotes.php              # Livewire component
├── Models/
│   ├── Player.php
│   ├── PlayerNote.php
│   └── User.php
├── Policies/
│   └── PlayerNotePolicy.php         # Authorization (can_create_notes)
├── Providers/
│   ├── AppServiceProvider.php       # Repository binding
│   └── AuthServiceProvider.php      # Policy registration
└── Repositories/
    ├── Contracts/
    │   └── PlayerNoteRepositoryInterface.php
    └── PlayerNoteRepository.php

database/
├── factories/
│   ├── PlayerFactory.php
│   ├── PlayerNoteFactory.php
│   └── UserFactory.php
├── migrations/                      # 6 migration files
└── seeders/
    ├── DatabaseSeeder.php
    ├── PlayerNoteSeeder.php
    ├── PlayerSeeder.php
    └── UserSeeder.php

resources/views/
├── livewire/
│   └── player-notes.blade.php       # Livewire component view
├── players/
│   ├── index.blade.php              # Player list page
│   └── notes.blade.php              # Player notes page (extends layouts.app)
└── layouts/
    └── app.blade.php                # Main layout

tests/
└── Feature/
    └── PlayerNoteCreationTest.php   # Feature test for note creation
```

## Implemented Features

- **User authentication** — Register, login, logout, password reset, email verification (Laravel Breeze).
- **Player list** — `/players` shows all players with ID, name, notes count, and a "View Notes" button.
- **Player notes history** — View all notes for a player, ordered by most recent first, showing author and formatted timestamp.
- **Note creation** — Authenticated users with `can_create_notes` permission can submit a new note via Livewire.
- **Real-time validation** — Required field, max 500 characters, with a live character counter (`mb_strlen`).
- **Authorization** — `PlayerNotePolicy` restricts note creation to users with `can_create_notes = true`; enforced both server-side (`$this->authorize()`) and in the Blade view (`@can`).
- **Repository pattern** — All note data access goes through `PlayerNoteRepositoryInterface`, keeping the Livewire component decoupled from Eloquent.
- **Seed data** — Pre-populated users, players, and notes for immediate evaluation.
- **Feature test** — Validates the complete note-creation flow with `RefreshDatabase`.
- **Eager loading** — Notes load their author (`->with('user')`), player list uses `->withCount('playerNotes')` to avoid N+1 queries.

## Considerations

- The repository is injected via `boot()` method in the Livewire component (Laravel's service container resolves it automatically), keeping the component testable and the data layer swappable.
- Foreign keys use `cascadeOnDelete` — deleting a player or user removes their related notes automatically.
- The `can_create_notes` column defaults to `false`, so newly registered users cannot create notes unless explicitly granted permission.
- Seed data uses factories with realistic, varied content to make the history view meaningful during evaluation.
- The Livewire component is embedded in a standard Blade view with `<x-app-layout>`, avoiding full-page component constraints and keeping the layout explicit.
