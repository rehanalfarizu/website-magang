import api from './api'

export default {
  async getPendaftaran(params = {}) {
    const response = await api.get('/pendaftaran', { params })
    return response.data
  },

  async getPendaftaranById(id) {
    const response = await api.get(`/pendaftaran/${id}`)
    return response.data
  },

  async createPendaftaran(data) {
    const response = await api.post('/pendaftaran', data)
    return response.data
  },

  async approveByAdmin(id) {
    const response = await api.put(`/pendaftaran/${id}/approve-admin`)
    return response.data
  },

  async rejectByAdmin(id, alasan) {
    const response = await api.put(`/pendaftaran/${id}/reject-admin`, { alasan })
    return response.data
  },

  async approveByMitra(id) {
    const response = await api.put(`/pendaftaran/${id}/approve-mitra`)
    return response.data
  },

  async rejectByMitra(id, alasan) {
    const response = await api.put(`/pendaftaran/${id}/reject-mitra`, { alasan })
    return response.data
  },

  async tetapkanDosen(id, dosenId) {
    const response = await api.put(`/pendaftaran/${id}/dosen`, { dosenId })
    return response.data
  },

  async getMyPendaftaran() {
    const response = await api.get('/pendaftaran/my')
    return response.data
  }
}