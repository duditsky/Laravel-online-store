
# Project Analysis: Laravel Online Store

This document provides an overview of the Laravel Online Store project, its structure, technologies, and development practices, intended to guide future interactions.

## Project Overview

This project is a web application built using **PHP 8.3** and the **Laravel 12** framework. It is designed as an online store with features for product management, user accounts, orders, and payments. The frontend utilizes **jQuery/AJAX** for dynamic interactions, managed by **Vite** for asset compilation. The project also integrates AI capabilities through packages like `google-gemini-php/laravel` and `openai-php/laravel`.

### AI & Language Rules
- **Response Language:** AI MUST always respond in Ukrainian. All code comments and explanations must be in Ukrainian.

## Building and Running the Project

### Development Environment

To start the development server and related processes (Vite, queue listener, log viewer), run:

```bash
composer run dev
```

This command executes `npx concurrently` to launch:
- `php artisan serve` (Laravel development server)
- `php artisan queue:listen` (Queue worker)
- `php artisan pail` (Log viewer)
- `npm run dev` (Vite development server for frontend assets)

### Production Build

To build production-ready frontend assets:

```bash
npm run build
```

### Running Tests

Execute the test suite using:

```bash
composer run test
```

This command first clears the configuration cache and then runs `php artisan test`.

### Database Migrations

To apply database migrations:

```bash
php artisan migrate
```

New projects typically run migrations automatically upon creation as indicated by `post-create-project-cmd` scripts.

## Development Conventions

### General

-   **Language:** PHP 8.3, Ukrainian locale is preferred for user-facing content.
-   **Framework:** Laravel 12.
-   **Frontend:** Primarily jQuery and AJAX. No Vue, React, or Livewire are used.
-   **Code Style:** Adheres to PSR-12, SOLID, DRY principles, and utilizes a Service Layer. The `laravel/pint` package is available for code formatting and linting.
-   **AJAX Responses:** Follow a specific JSON structure: `{status: bool, data: array, message: string, errors?: array}`.

### Security and Performance

-   **Models:** Use of `$guarded = []` or `$fillable` properties is standard.
-   **Database:** Prevent N+1 query issues by using `with()` eager loading. Foreign keys and filters should have indexes added in migrations.
-   **Validation:** All input validation should be handled via `FormRequests`. Inputs must be sanitized to protect against XSS attacks.
-   **Storage:** Photos should be sanitized, renamed, and optimized. Use `Storage::disk('public')` only for non-sensitive data.
-   **Configuration:** System configuration files (`.env`, `config/`) are considered read-only and should not be modified directly.

### Dependencies

-   **Composer:** Manages PHP dependencies, including Laravel core, AI packages, and development tools.
-   **NPM:** Manages frontend dependencies like Vite, Tailwind CSS, and Axios.

### Directory Structure

The project follows a standard Laravel directory structure, including `app/` for core logic, `database/` for migrations and seeds, `resources/` for views and frontend assets, and `routes/` for defining application routes.

