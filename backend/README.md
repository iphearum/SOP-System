# Backend (Laravel) bootstrap

This folder is prepared for a Laravel API service. To generate the framework code when network access is available, run the bootstrap script below or manually invoke `composer create-project`.

## Bootstrap

```bash
make backend-bootstrap
```

The command will:
1. Run `composer create-project laravel/laravel .` inside `backend/`.
2. Install dependencies.
3. Generate `APP_KEY` and copy `.env.example` to `.env` if absent.

## Local development

After bootstrapping, start the stack:

```bash
docker-compose up backend queue db mailhog
```

The backend is exposed on `http://localhost:8000`.

## Testing

From the `backend/` directory after dependencies are installed:

```bash
php artisan test
php artisan migrate --pretend
```

If you encounter missing dependencies, ensure `composer install` has completed successfully.
