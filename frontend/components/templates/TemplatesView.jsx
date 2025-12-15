'use client';

import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
import { useMemo, useState } from 'react';
import { createTemplate, fetchTemplates } from '@/lib/api/templates';

export default function TemplatesView() {
  const queryClient = useQueryClient();
  const { data, isLoading, isError, error } = useQuery({ queryKey: ['templates'], queryFn: fetchTemplates });
  const [form, setForm] = useState({ name: '', description: '' });

  const createMutation = useMutation({
    mutationFn: createTemplate,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['templates'] });
      setForm({ name: '', description: '' });
    },
  });

  const templates = useMemo(() => data?.data ?? data ?? [], [data]);

  return (
    <div className="card">
      <p className="badge">Templates</p>
      <h1 style={{ marginTop: '8px' }}>Template catalog</h1>
      <p>Capture Cambodia SOP formats and publish versions that downstream submissions depend on.</p>

      <section style={{ marginTop: '20px' }}>
        <h2>Create template</h2>
        <form
          onSubmit={(e) => {
            e.preventDefault();
            if (!form.name.trim()) return;
            createMutation.mutate({ name: form.name, description: form.description });
          }}
          style={{ display: 'grid', gap: '12px', marginTop: '12px' }}
        >
          <div>
            <label htmlFor="name">Name</label>
            <input
              id="name"
              name="name"
              placeholder="e.g., Ministry of Health SOP"
              value={form.name}
              onChange={(e) => setForm((prev) => ({ ...prev, name: e.target.value }))}
              required
            />
          </div>
          <div>
            <label htmlFor="description">Description</label>
            <textarea
              id="description"
              name="description"
              placeholder="Outline the template purpose, required sections, and Cambodia-specific routing."
              value={form.description}
              onChange={(e) => setForm((prev) => ({ ...prev, description: e.target.value }))}
            />
          </div>
          <button type="submit" disabled={createMutation.isPending} aria-busy={createMutation.isPending}>
            {createMutation.isPending ? 'Creating…' : 'Create template'}
          </button>
          {createMutation.isError && (
            <p role="alert" style={{ color: '#b91c1c' }}>
              Failed to create template: {createMutation.error?.message || 'Unknown error'}
            </p>
          )}
        </form>
      </section>

      <section style={{ marginTop: '32px' }}>
        <h2>Templates ({templates.length})</h2>
        {isLoading && <p>Loading templates…</p>}
        {isError && (
          <p role="alert" style={{ color: '#b91c1c' }}>
            Could not load templates: {error?.message || 'Unexpected error'}
          </p>
        )}

        {!isLoading && !isError && templates.length === 0 && <p>No templates available yet.</p>}

        {!isLoading && !isError && templates.length > 0 && (
          <table className="table" aria-label="Templates list">
            <thead>
              <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Version</th>
              </tr>
            </thead>
            <tbody>
              {templates.map((template) => (
                <tr key={template.id}>
                  <td>{template.name}</td>
                  <td>{template.description}</td>
                  <td>
                    <span className="status-pill">{template.status || 'draft'}</span>
                  </td>
                  <td>{template.version || '1.0'}</td>
                </tr>
              ))}
            </tbody>
          </table>
        )}
      </section>
    </div>
  );
}
