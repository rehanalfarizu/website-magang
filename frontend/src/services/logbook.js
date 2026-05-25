import api from './api'

export default {
  async getLogbook(params = {}) {
    const response = await api.get('/logbook', { params })
    return response.data
  },

  async getLogbookById(id) {
    const response = await api.get(`/logbook/${id}`)
    return response.data
  },

  async getMyLogbook() {
    const response = await api.get('/logbook/my')
    return response.data
  },

  async createLogbook(data) {
    const response = await api.post('/logbook', data)
    return response.data
  },

  async updateLogbook(id, data) {
    const response = await api.put(`/logbook/${id}`, data)
    return response.data
  },

  async submitLogbook(id) {
    const response = await api.put(`/logbook/${id}/submit`)
    return response.data
  },

  async markAsRead(id) {
    const response = await api.put(`/logbook/${id}/read`)
    return response.data
  },

  async approveLogbook(id, feedback = '') {
    const response = await api.put(`/logbook/${id}/approve`, { feedback })
    return response.data
  },

  async requestRevision(id, feedback) {
    const response = await api.put(`/logbook/${id}/revision`, { feedback })
    return response.data
  },

  async getMonthlyProgress(nim) {
    const response = await api.get(`/logbook/progress/${nim}`)
    return response.data
  }
}