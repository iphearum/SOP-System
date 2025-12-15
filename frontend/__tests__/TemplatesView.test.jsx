import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import TemplatesView from '@/components/templates/TemplatesView';
import * as templatesApi from '@/lib/api/templates';

const renderWithClient = (ui) => {
  const client = new QueryClient();
  return render(<QueryClientProvider client={client}>{ui}</QueryClientProvider>);
};

describe('TemplatesView', () => {
  afterEach(() => {
    vi.restoreAllMocks();
  });

  it('shows templates and supports creation', async () => {
    vi.spyOn(templatesApi, 'fetchTemplates').mockResolvedValue([
      { id: 1, name: 'Initial SOP', description: 'Baseline', status: 'published', version: '1.0' },
    ]);
    const createSpy = vi.spyOn(templatesApi, 'createTemplate').mockResolvedValue({ id: 2 });

    renderWithClient(<TemplatesView />);

    expect(await screen.findByText('Initial SOP')).toBeInTheDocument();

    fireEvent.change(screen.getByLabelText('Name'), { target: { value: 'New Template' } });
    fireEvent.change(screen.getByLabelText('Description'), { target: { value: 'Cambodia format' } });
    fireEvent.click(screen.getByRole('button', { name: 'Create template' }));

    await waitFor(() => {
      expect(createSpy).toHaveBeenCalledWith({ name: 'New Template', description: 'Cambodia format' });
    });
  });
});
