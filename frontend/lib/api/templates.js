import api from './client';

export async function fetchTemplates() {
  const { data } = await api.get('/api/templates');
  return data?.data ?? data;
}

export async function createTemplate(payload) {
  const { data } = await api.post('/api/templates', payload);
  return data?.data ?? data;
}
