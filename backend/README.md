# Backend (Laravel API)

This folder now includes a Laravel 11–style API implementation for the SOP System. It ships with templates, documents, and approval endpoints aligned to a Cambodia-ready workflow.

## Getting started

Because package downloads are blocked in this environment, install dependencies locally or within Docker once network access is available:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

Then run the stack from the repository root:

```bash
docker-compose up backend queue db mailhog
```

The API will be available at `http://localhost:8000/api/v1`.

## API surface

- `GET /api/v1/templates` — paginated templates
- `POST /api/v1/templates` — create a template (expects `sections_schema` JSON)
- `GET /api/v1/documents` — list documents with template + owner
- `POST /api/v1/documents` — create a draft document from a template
- `POST /api/v1/documents/{document}/submit` — move draft to review
- `POST /api/v1/documents/{document}/approvals` — record an approval or rejection and update status
- `POST /api/v1/documents/{document}/publish` — publish after approval

## Testing

After running `composer install`, execute:

```bash
php artisan test
```

The included tests assume an in-memory SQLite database defined in `phpunit.xml`.
