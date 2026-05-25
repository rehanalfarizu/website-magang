import api from './api'

export default {
  async getMahasiswa(params = {}) {
    const response = await api.get('/mahasiswa', { params })
    return response.data
  },

  async getMahasiswaById(id) {
    const response = await api.get(`/mahasiswa/${id}`)
    return response.data
  },

  async getMyProfile() {
    const response = await api.get('/mahasiswa/my')
    return response.data
  },

  async updateProfile(data) {
    const response = await api.put('/mahasiswa/profile', data)
    return response.data
  },

  async getDosen(params = {}) {
    const response = await api.get('/dosen', { params })
    return response.data
  },

  async getDosenById(id) {
    const response = await api.get(`/dosen/${id}`)
    return response.data
  },

  async getMitra(params = {}) {
    const response = await api.get('/mitra', { params })
    return response.data
  },

  async getMitraById(id) {
    const response = await api.get(`/mitra/${id}`)
    return response.data
  },

  async approveMitra(id) {
    const response = await api.put(`/mitra/${id}/approve`)
    return response.data
  },

  async rejectMitra(id, alasan) {
    const response = await api.put(`/mitra/${id}/reject`, { alasan })
    return response.data
  },

  async getDashboardStats() {
    const response = await api.get('/dashboard/stats')
    return response.data
  },

  async getMahasiswaBimbingan() {
    const response = await api.get('/dosen/mahasiswa-bimbingan')
    return response.data
  }
}