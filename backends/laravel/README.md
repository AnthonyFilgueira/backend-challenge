# ClinicSay Laravel reference backend

Laravel-first implementation in `backends/laravel`, separated from challenge root. Intended architecture: FormRequest → Controller → Service → Repository → Model. PostgreSQL. Original challenge files and provider are preserved.

## Current status
Initial skeleton, schema and clinic/patient/appointment create/read/reschedule/cancel paths have been added. This is **not yet complete or QA-approved**: provider dispatch, webhook, RBAC/tenancy integration, CI and contract tests remain.

## Local/runner setup
Requires PHP 8.3+, Composer and PostgreSQL 16+.
```sh
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve --port=3000
```
Configure DB_* and PROVIDER_URL. The challenge contract routes are served under /api.
