# Frontend (React + Vite)

This is a lightweight React SPA scaffold aligned with the SOP System blueprint. It uses Vite, TanStack Query, and Axios.

## Scripts

- `npm run dev` – start Vite dev server.
- `npm run build` – production build.
- `npm run preview` – preview production build.
- `npm run lint` – run ESLint.
- `npm test` – run Vitest + Testing Library suite.

## Bootstrapping

Install dependencies (requires npm registry access):

```bash
npm install
cp .env.example .env
```

Set `VITE_API_URL` to your backend base URL.

## Templates demo

`TemplatesPage` demonstrates React Query data fetching, optimistic template creation, and error states. It expects the backend to expose `/api/templates` endpoints.
