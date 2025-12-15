# Frontend (Next.js)

Next.js App Router frontend aligned with the SOP System blueprint. It uses TanStack Query, Axios, and React Testing Library.

## Scripts

- `npm run dev` – start Next.js dev server.
- `npm run build` – production build.
- `npm run start` – start production server.
- `npm run lint` – run ESLint (Next core web vitals).
- `npm test` – run Vitest + Testing Library suite.

## Bootstrapping

Install dependencies (requires npm registry access):

```bash
npm install
cp .env.example .env.local
```

Set `NEXT_PUBLIC_API_URL` to your backend base URL.

## Templates demo

`/templates` demonstrates React Query data fetching, optimistic template creation, and error states. It expects the backend to expose `/api/templates` endpoints.
