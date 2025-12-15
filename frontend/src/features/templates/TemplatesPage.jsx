import React, { useState } from 'react'
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query'
import { createTemplate, fetchTemplates } from '../../api/client'

function TemplateCard({ template }) {
  return (
    <div className="card">
      <h3>{template.name}</h3>
      <p>{template.description || 'No description provided.'}</p>
      <div className="badge">Version {template.version || '1.0'}</div>
    </div>
  )
}

export default function TemplatesPage() {
  const queryClient = useQueryClient()
  const [name, setName] = useState('')
  const [description, setDescription] = useState('')

  const { data: templates = [], isLoading, isError } = useQuery({
    queryKey: ['templates'],
    queryFn: fetchTemplates,
    staleTime: 1000 * 30
  })

  const mutation = useMutation({
    mutationFn: createTemplate,
    onSuccess: () => {
      setName('')
      setDescription('')
      queryClient.invalidateQueries({ queryKey: ['templates'] })
    }
  })

  return (
    <div className="card">
      <h2>Templates</h2>
      <p>Create SOP templates and view existing ones.</p>

      <form
        onSubmit={(e) => {
          e.preventDefault()
          mutation.mutate({ name, description })
        }}
        className="card"
      >
        <label>
          Name
          <input
            type="text"
            value={name}
            onChange={(e) => setName(e.target.value)}
            required
            placeholder="Safety checklist"
          />
        </label>
        <label>
          Description
          <input
            type="text"
            value={description}
            onChange={(e) => setDescription(e.target.value)}
            placeholder="Short summary"
          />
        </label>
        <div className="button-row">
          <button type="submit" className="primary" disabled={mutation.isLoading}>
            {mutation.isLoading ? 'Saving…' : 'Create template'}
          </button>
          {mutation.isError && <span role="alert">Failed to save template.</span>}
        </div>
      </form>

      {isLoading && <p>Loading templates…</p>}
      {isError && <p role="alert">Failed to load templates.</p>}
      {!isLoading && templates.length === 0 && <p>No templates yet.</p>}
      {!isLoading && templates.map((template) => <TemplateCard key={template.id || template.name} template={template} />)}
    </div>
  )
}
