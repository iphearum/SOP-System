import { describe, it, expect, vi } from 'vitest'
import { render, screen } from '@testing-library/react'
import { QueryClient, QueryClientProvider } from '@tanstack/react-query'
import TemplatesPage from './TemplatesPage'
import * as client from '../../api/client'

vi.spyOn(client, 'fetchTemplates').mockResolvedValue([])
vi.spyOn(client, 'createTemplate').mockResolvedValue({ id: '1', name: 'Demo', description: 'test' })

describe('TemplatesPage', () => {
  it('renders header and empty state', async () => {
    const queryClient = new QueryClient()
    render(
      <QueryClientProvider client={queryClient}>
        <TemplatesPage />
      </QueryClientProvider>
    )

    expect(screen.getByText(/Templates/)).toBeInTheDocument()
    expect(await screen.findByText(/No templates yet/)).toBeInTheDocument()
  })
})
