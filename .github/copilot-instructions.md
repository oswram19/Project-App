# GitHub Copilot Instructions for Project-App

## Architecture Overview

This is a **Laravel 10 application** with a **hybrid frontend architecture**:
- **Admin Panel**: Blade templates with AdminLTE 3 (`resources/views/admin/**`)
- **User-facing Frontend**: Vue 3 + Inertia.js (`resources/js/Pages/**`)
- **Authentication**: Laravel Jetstream with Sanctum (Inertia stack)
- **Permissions**: Spatie Laravel Permission (roles & permissions)

## Dual Routing System

The app maintains **two separate routing contexts**:

1. **Admin Routes** (`routes/admin.php`):
   - Prefix: `/admin`
   - Middleware: `web`, `auth` (defined in `RouteServiceProvider.php`)
   - Returns: Blade views using AdminLTE layout (`@extends('adminlte::page')`)
   - Naming: `admin.{resource}.{action}` (e.g., `admin.users.edit`)

2. **Public Routes** (`routes/web.php`):
   - Root level routes
   - Middleware: `auth:sanctum`, `verified` (for authenticated sections)
   - Returns: Inertia.js responses (`Inertia::render()`)
   - Uses Vue 3 components from `resources/js/Pages/`

**Key Pattern**: Admin controllers return views, public controllers return Inertia responses.

## Permission System

Permissions follow a strict naming convention using Spatie's package:

```php
// Pattern: {area}.{resource}.{action}
'admin.users.index', 'admin.users.edit', 'admin.users.destroy'
```

- Roles are seeded in `database/seeders/RoleSeeder.php`
- Default roles: `Admin`, `User`
- User model uses `HasRoles` trait from Spatie
- Permissions are synced in controllers: `$user->roles()->sync($request->roles)`

## DataTables Integration

Admin views use **jQuery DataTables** with server-side AJAX:

- DataTable controllers in `app/Http/Controllers/DatatableController.php`
- Route pattern: `datatable/{resource}` (e.g., `datatable/users`)
- Response format: `return datatables()->of($collection)->toJson()`
- Frontend: Bootstrap 4 styled tables with responsive plugin
- CDN-based (no npm packages for DataTables)

## Frontend Asset Build

**Development Workflow**:
```bash
npm run dev    # Start Vite dev server with HMR
npm run build  # Production build
```

**Dual Frontend Stack**:
- **Inertia/Vue**: Compiled via Vite (`vite.config.js`)
- **AdminLTE/Blade**: Static assets via CDN (jQuery, Bootstrap, DataTables)

AdminLTE views include scripts in `@section('js')` and styles in `@section('css')`.

## Database Seeding Pattern

Seeders follow a **dependency chain** (see `DatabaseSeeder.php`):
1. `RoleSeeder` - Creates roles & permissions first
2. `UserSeeder` - Assigns roles to users
3. Storage cleanup: `Storage::deleteDirectory('posts')` before seeding

Always run seeders in order: `php artisan db:seed`

## Resource Controller Conventions

**Admin Controllers**:
- May restrict methods: `->only(['index', 'edit', 'update'])`
- Use `compact()` to pass data to Blade views
- Models are type-hinted for route model binding

**Example Pattern**:
```php
public function edit(User $user) {
    $roles = Role::all();
    return view('admin/users/edit', compact('user', 'roles'));
}
```

## Key Configuration Files

- `config/adminlte.php` - AdminLTE customization (menu, theme)
- `config/jetstream.php` - Stack: `inertia`, features, teams
- `config/permission.php` - Spatie permissions config
- `app/Providers/RouteServiceProvider.php` - HOME constant = `'/'`, admin route group

## Development Environment

- **Local Server**: Laragon (Windows-based LAMP stack)
- **PHP**: ^8.1
- **Database**: Configured in `.env` (likely MySQL via Laragon)

## Common Commands

```bash
# Run migrations with fresh seeding
php artisan migrate:fresh --seed

# Clear caches
php artisan optimize:clear

# Generate IDE helpers (if installed)
php artisan ide-helper:models

# Run tests
php artisan test
```

## Important Notes

- **Route Naming**: Always use `->names()` or `->name()` to maintain consistency
- **Middleware Order**: Admin routes require `auth` before access; check `RouteServiceProvider`
- **Storage Links**: Public storage symlink required for file uploads
- **Ziggy Integration**: Use `route()` helper in Vue components for named routes
