import React from 'react'
import TemplatesPage from './features/templates/TemplatesPage'

export default function App() {
  return (
    <main className="page">
      <header className="hero">
        <h1>SOP System</h1>
        <p>Laravel API + React SPA starter with workflow-ready scaffolding.</p>
      </header>
      <section>
        <TemplatesPage />
      </section>
    </main>
  )
}
