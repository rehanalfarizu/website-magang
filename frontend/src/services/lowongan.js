import api from './api'

export default {
  // Lowongan (Job Postings)
  async getLowongan(params = {}) {
    const response = await api.get('/lowongan', { params })
    return response.data
  },

  async getLowonganById(id) {
    const response = await api.get(`/lowongan/${id}`)
    return response.data
  },

  async createLowongan(data) {
    const response = await api.post('/lowongan', data)
    return response.data
  },

  async updateLowongan(id, data) {
    const response = await api.put(`/lowongan/${id}`, data)
    return response.data
  },

  async deleteLowongan(id) {
    const response = await api.delete(`/lowongan/${id}`)
    return response.data
  },

  async kurasiLowongan(id, status, catatan = '') {
    const response = await api.put(`/lowongan/${id}/kurasi`, { status, catatan })
    return response.data
  },

  // Bookmark
  async bookmarkLowongan(lowonganId) {
    const response = await api.post(`/lowongan/${lowonganId}/bookmark`)
    return response.data
  },

  async removeBookmark(lowonganId) {
    const response = await api.delete(`/lowongan/${lowonganId}/bookmark`)
    return response.data
  },

  async getBookmarks() {
    const response = await api.get('/lowongan/bookmarks')
    return response.data
  }
}