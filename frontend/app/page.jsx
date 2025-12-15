import Link from 'next/link';

export default function Home() {
  return (
    <main>
      <div className="card" style={{ marginBottom: '20px' }}>
        <p className="badge">Cambodia workflow ready</p>
        <h1 style={{ marginTop: '8px' }}>SOP System Frontend</h1>
        <p>
          Manage templates, submissions, approvals, and publishing with a Next.js interface aligned to the Cambodia-focused SOP
          lifecycle.
        </p>
        <p>
          Jump into templates to view, create, and publish SOP templates powering document submissions and approvals.
        </p>
        <Link href="/templates">
          <button aria-label="Go to templates">View templates</button>
        </Link>
      </div>
      <div className="card">
        <h2>What&apos;s included</h2>
        <ul>
          <li>Next.js App Router with TanStack Query data fetching.</li>
          <li>Axios client wired to the backend API via <code>NEXT_PUBLIC_API_URL</code>.</li>
          <li>React Query Devtools enabled for fast inspection.</li>
          <li>Vitest + Testing Library harness for component coverage.</li>
        </ul>
      </div>
    </main>
  );
}
