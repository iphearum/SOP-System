import axios from 'axios'

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
})

export const fetchTemplates = async () => {
  const { data } = await api.get('/templates')
  return data
}

export const createTemplate = async (payload) => {
  const { data } = await api.post('/templates', payload)
  return data
}

export default api
