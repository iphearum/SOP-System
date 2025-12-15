# Implementation Plan and Quality Gates

This document outlines a phased approach to delivering the SOP System using Laravel (backend), Next.js (frontend), and PostgreSQL. Each phase includes goals, deliverables, and verification steps (tests/checks). Revise or roll back any change that fails its quality gate before proceeding.

## Phase 0 – Project bootstrap
- **Goals:** Establish repos, environments, and CI baselines.
- **Deliverables:**
  - Laravel API scaffold with Docker Compose (app, db, queue, mailhog optional).
  - Next.js (App Router) scaffold with linting/formatting.
  - Shared `.env.example` files and Make/Composer/NPM scripts for common tasks.
- **Quality gates:**
  - Backend: `php artisan test` (empty suite allowed), `php artisan migrate --pretend` to validate migrations once added.
  - Frontend: `npm run lint`, `npm test -- --watch=false` (or `npm run test` if configured).
  - CI: workflow that runs lint + tests on push/PR.

## Phase 1 – Authentication and RBAC
- **Goals:** Secure access with JWT/Sanctum and role-based policies.
- **Deliverables:**
  - User model with roles (Author, Reviewer, Approver, Admin) and team membership.
  - Auth endpoints (register/login/refresh) and middleware to protect APIs.
  - Policies for Template, Document, Workflow entities.
- **Quality gates:**
  - Backend: Pest/PHPUnit feature tests for auth endpoints (happy/edge cases) and policy checks.
  - API contract: OpenAPI/Swagger route snippets generated/updated.
  - Manual check: Token-protected endpoint denies unauthenticated requests.

## Phase 2 – Templates
- **Goals:** Manage SOP templates with version control.
- **Deliverables:**
  - Models/tables: `templates`, `template_versions` with JSON schema for sections.
  - Endpoints: create/update, publish/lock template version, list versions.
  - Validation: schema validation for required sections/metadata.
- **Quality gates:**
  - Backend tests: model factories + API tests for creation, publish flow, validation errors.
  - Migration check: `php artisan migrate:fresh --seed` passes.
  - Docs: README/API docs updated with routes and example payloads.

## Phase 3 – Documents and Sections
- **Goals:** Create documents from templates with immutable versions.
- **Deliverables:**
  - Models/tables: `documents`, `document_versions`, `sections` (with ordering and attachments metadata).
  - Endpoints: create draft from template, update draft content, submit draft.
  - Versioning: new version row per submit; current version pointer on `documents`.
- **Quality gates:**
  - Backend tests: creation, draft update, submit locks draft, version history listing, diff computation utility (unit-tested).
  - File storage: attachment upload mocked in tests; checksum stored.
  - Manual check: diff endpoint returns structured section deltas.

## Phase 4 – Workflows and Approvals
- **Goals:** Configurable review/approval flows with SLAs and escalation hooks.
- **Deliverables:**
  - Models/tables: `workflows`, `workflow_steps`, `approvals` with serial/parallel flags and deadlines.
  - Endpoints: submit document to workflow, approve/reject current step, reassign/delegate, escalation trigger stub.
  - Queue jobs for reminders/escalations; events/webhooks for state changes.
- **Quality gates:**
  - Backend tests: step advancement logic, parallel approvals, rejection path, reassignment rules, SLA deadline calculations.
  - Integration test: document lifecycle draft → review → approved → published.
  - Observability: structured events logged for transitions.

## Phase 5 – Publishing, Audit, and Notifications
- **Goals:** Make approved SOPs discoverable and auditable.
- **Deliverables:**
  - Published state with read-only enforcement; change request entrypoint.
  - Audit log table capturing actor/action/entity/hash.
  - Notification templates and channels (email/Slack/Webhook) with queued dispatch.
- **Quality gates:**
  - Backend tests: publish guard, change request kickoff, audit write assertions, notification dispatch stubs.
  - Security: role/policy checks verified in tests for publish and audit retrieval.

## Phase 6 – Frontend features
- **Goals:** User-facing flows for templates, documents, approvals.
- **Deliverables:**
  - Feature folders: templates, documents, approvals; TanStack Query hooks.
  - Forms driven by template schema; diff viewer for versions; SLA dashboard.
  - Auth guard routes and session refresh handling.
- **Quality gates:**
  - Frontend tests: RTL tests for forms and approval flows; component snapshot where appropriate.
  - E2E: Playwright covering login, create template, create doc, submit, approve, publish.
  - Accessibility: axe/ARIA checks on critical forms.

## Phase 7 – Performance and Search
- **Goals:** Ensure responsiveness and searchability.
- **Deliverables:**
  - Postgres full-text indexes on sections; filters for status/owner/tag.
  - Caching strategy for frequently accessed lists; pagination defaults.
  - Background indexing or external search adapter stubs if scaling.
- **Quality gates:**
  - Performance test scripts (k6/Locust) for list/search endpoints with baseline thresholds.
  - DB explain plans for key queries documented.

## Phase 8 – Operations and Safety
- **Goals:** Harden deployments and recovery.
- **Deliverables:**
  - Backup/restore procedure; migration safety checklist.
  - Health checks, structured logging, and metrics (Prometheus/OpenTelemetry stubs).
  - Runbooks for incident response and SLA breach escalation.
- **Quality gates:**
  - Disaster recovery drill: restore from backup in a staging environment.
  - CI ensures migrations are reversible (`migrate:fresh`), and lint/tests remain green.

## Phase 9 – Readiness and Hand-off
- **Goals:** Finalize docs and ownership.
- **Deliverables:**
  - Updated README with setup/run/test instructions matching current code.
  - API reference snapshots (OpenAPI) and onboarding guide.
  - Known gaps list with mitigation or backlog links.
- **Quality gates:**
  - Release candidate checklist completed; sign-off from stakeholders.
  - All blocking issues resolved or explicitly deferred with owners.

## Revision and error handling
- If a phase fails its quality gates, fix forward within the phase before advancing.
- Log defects with repro steps and add regression tests.
- Keep commits small and reversible; prefer feature branches merged via PR with reviews and CI.
