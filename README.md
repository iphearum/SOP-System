# SOP System – Laravel + React + PostgreSQL blueprint

This repository outlines a portable starter blueprint for building an SOP management system using **Laravel** for the backend, **React** for the frontend, and **PostgreSQL** for persistence.

## Architecture overview
- **Backend:** Laravel API (Sanctum or Passport for auth) with modular service classes and form request validation. Use Laravel Queues for notifications and long-running tasks.
- **Frontend:** React (Vite) with component library (MUI/Chakra) and TanStack Query for data fetching + caching. Keep feature folders (e.g., `features/documents`, `features/templates`).
- **API style:** REST-first with pagination, filtering, and sorting. Consider JSON:API conventions for discoverability; add OpenAPI docs with Laravel Swagger or similar.
- **Authentication & authorization:** JWT or Laravel Sanctum, with Role-Based Access Control (RBAC). Use policies for per-entity permissions.
- **Storage:** PostgreSQL for relational data and versioning; S3-compatible storage for attachments via Laravel Filesystem.
- **Infrastructure:** Docker Compose for app + db; `.env` driven config. Include migrations, seeders, and CI checks (lint + tests + migrations).

## Core domain model
- **User**: roles (Author, Reviewer, Approver, Admin), department, status.
- **Team/Group**: name, members; used for workflow routing and escalation.
- **Template**: name, version, section schema (JSON), required metadata, status.
- **Document (SOP)**: belongs to template; status lifecycle (draft → review → approved → published → archived); owner; metadata tags; immutable versions.
- **Section/Content block**: structured content linked to a document version; supports attachments and ordering.
- **Workflow**: steps, assigned roles/actors, parallel/serial flags, SLAs, escalation rules.
- **Approval**: decision, comment, timestamp, step index, assignee.
- **Change Request**: reason, impact, linked to a prior version; triggers new workflow.
- **Audit Log**: actor, action, entity, timestamp, content hash for integrity.
- **Notification**: channel (email/Slack/Webhook), template, event trigger.

## Database sketch (PostgreSQL)
- Use UUID primary keys; enforce foreign keys and cascading rules.
- Tables: `users`, `teams`, `team_user`, `templates`, `template_versions`, `documents`, `document_versions`, `sections`, `workflows`, `workflow_steps`, `approvals`, `change_requests`, `audit_logs`, `notifications`.
- Versioning: `document_versions` holds immutable snapshots; `documents` tracks current version ID.
- Indexes: `status`, `owner_id`, `template_id`, `updated_at`, full-text search on `sections.content` (Postgres `tsvector`).

## API surface (examples)
- `POST /api/templates` – create template (with sections schema JSON).
- `POST /api/templates/{id}/publish` – lock template and mark current version.
- `POST /api/documents` – create document from template; starts draft.
- `POST /api/documents/{id}/submit` – move to review and initialize workflow.
- `POST /api/documents/{id}/approvals` – approve/reject current step; advances workflow.
- `GET /api/documents?status=review&tag=...` – filter/paginate; include owner and template.
- `GET /api/documents/{id}/versions` – list history; `GET /api/documents/{id}/diff/{v1}/{v2}` for comparisons.

## Frontend considerations (React)
- Use feature folders with hooks: `useDocuments()`, `useApproveStep()`, `useTemplateSchema()`, backed by TanStack Query.
- Form generation from template schema (JSON-driven forms) with validation.
- Rich text/structured editor for sections; show diff view for versions.
- Dashboard: status filters, SLA risk indicators, and pending approvals list.
- Handle optimistic updates for actions like approvals; fallback to refetch on error.

## Workflow & governance
- Guard transitions with Laravel Policies; prevent edits after approval except via change requests.
- Add reminders/escalations via queued jobs; store SLA deadlines on workflow steps.
- Capture audit events for create/update/approve/publish with hashed payloads.

## Dev environment (suggested)
- **Setup:** `composer create-project laravel/laravel backend`, `npm create vite@latest frontend -- --template react`.
- **Local run:** Docker Compose with `app`, `db` (Postgres), `queue`, and optional `mailhog`.
- **Testing:** Laravel Pest/PHPUnit for domain + workflow tests; Jest/RTL for React components; Playwright for e2e.
- **CI checks:** lint (PHP-CS-Fixer, ESLint/Prettier), tests, and migration validation.

Use this blueprint as a starting point, adding concrete code, migrations, and CI as you build out the SOP system.

## Monorepo layout

- `backend/` – Laravel API scaffold (generated via `composer create-project`) with Docker image for app and queue workers.
- `frontend/` – React + Vite SPA scaffold with TanStack Query and Axios.
- `docker-compose.yml` – services for backend, queue, Postgres, Mailhog, and the Vite dev server.
- `Makefile` – helper targets to bootstrap backend/frontend when registry access is available.

## Quickstart

Network access to PHP/Node registries is required for the bootstrap commands:

```bash
make backend-bootstrap   # generates Laravel app and installs composer deps
make frontend-bootstrap  # generates Vite app and installs npm deps
cp backend/.env.example backend/.env
cp frontend/.env.example frontend/.env

docker-compose up --build
```

Backend will be available on `http://localhost:8000`, frontend on `http://localhost:5173`, and Mailhog UI on `http://localhost:8025`.

## Delivery plan and quality gates

See [`docs/IMPLEMENTATION_PLAN.md`](docs/IMPLEMENTATION_PLAN.md) for the recommended phase-by-phase plan, deliverables, and the tests/checks to run at each step. Follow those gates and revise any change that does not pass before progressing.