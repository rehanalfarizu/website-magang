import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  // State
  const user = ref(null)
  const token = ref(localStorage.getItem('token') || null)
  const initialized = ref(false)
  const loading = ref(false)
  const error = ref(null)

  // Getters
  const isAuthenticated = computed(() => !!token.value && !!user.value)
  const userRole = computed(() => user.value?.role || null)
  const userName = computed(() => user.value?.nama || user.value?.name || 'User')
  const userEmail = computed(() => user.value?.email || '')

  const defaultRoute = computed(() => {
    if (!user.value) return 'Login'
    const routeMap = {
      mahasiswa: 'MahasiswaDashboard',
      dosen: 'DosenDashboard',
      admin: 'AdminDashboard',
      mitra: 'MitraDashboard'
    }
    return routeMap[user.value.role] || 'Login'
  })

  // Mock users for demo
  const mockUsers = {
    'mahasiswa@students.amikom.ac.id': { id: 1, nama: 'Rehan Alfarizi', email: 'mahasiswa@students.amikom.ac.id', role: 'mahasiswa', nim: '23.11.5548' },
    'dosen@amikom.ac.id': { id: 2, nama: 'Bambang Pilu Hartato', email: 'dosen@amikom.ac.id', role: 'dosen', nidn: '12345678' },
    'admin@amikom.ac.id': { id: 3, nama: 'Administrator', email: 'admin@amikom.ac.id', role: 'admin' },
    'mitra@company.co.id': { id: 4, nama: 'PT Teknologi Indonesia', email: 'mitra@company.co.id', role: 'mitra' }
  }

  // Actions
  async function login(email, password) {
    loading.value = true
    error.value = null

    // Simulate API delay
    await new Promise(resolve => setTimeout(resolve, 500))

    try {
      // Mock login - accept any password for demo
      const mockUser = mockUsers[email.toLowerCase()]

      if (mockUser) {
        token.value = 'mock-token-' + Date.now()
        user.value = mockUser
        localStorage.setItem('token', token.value)
        localStorage.setItem('mockUser', JSON.stringify(mockUser))
        return { success: true }
      } else {
        throw new Error('Email atau password salah')
      }
    } catch (err) {
      error.value = err.message || 'Login failed'
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  async function logout() {
    loading.value = true
    await new Promise(resolve => setTimeout(resolve, 200))
    user.value = null
    token.value = null
    localStorage.removeItem('token')
    initialized.value = false
    loading.value = false
  }

  async function checkAuth() {
    if (!token.value) {
      initialized.value = true
      return false
    }

    // For mock, just return true if token exists
    user.value = JSON.parse(localStorage.getItem('mockUser') || 'null')
    initialized.value = true
    return !!user.value
  }

  function clearError() {
    error.value = null
  }

  return {
    // State
    user,
    token,
    initialized,
    loading,
    error,
    // Getters
    isAuthenticated,
    userRole,
    userName,
    userEmail,
    defaultRoute,
    // Actions
    login,
    logout,
    checkAuth,
    clearError
  }
})