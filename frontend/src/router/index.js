import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth/auth'

const routes = [
  // Auth Routes
  {
    path: '/login',
    name: 'Login',
    component: () => import('@/views/auth/LoginView.vue'),
    meta: { guest: true }
  },

  // Role-based Routes
  {
    path: '/mahasiswa',
    name: 'Mahasiswa',
    component: () => import('@/layouts/MahasiswaLayout.vue'),
    meta: { requiresAuth: true, role: 'mahasiswa' },
    children: [
      {
        path: '',
        name: 'MahasiswaDashboard',
        component: () => import('@/views/mahasiswa/DashboardView.vue')
      },
      {
        path: 'lowongan',
        name: 'MahasiswaLowongan',
        component: () => import('@/views/mahasiswa/LowonganView.vue')
      },
      {
        path: 'pendaftaran',
        name: 'MahasiswaPendaftaran',
        component: () => import('@/views/mahasiswa/PendaftaranView.vue')
      },
      {
        path: 'logbook',
        name: 'MahasiswaLogbook',
        component: () => import('@/views/mahasiswa/LogbookView.vue')
      },
      {
        path: 'progres',
        name: 'MahasiswaProgres',
        component: () => import('@/views/mahasiswa/ProgresView.vue')
      },
      {
        path: 'profile',
        name: 'MahasiswaProfile',
        component: () => import('@/views/mahasiswa/ProfileView.vue')
      }
    ]
  },

  {
    path: '/dosen',
    name: 'Dosen',
    component: () => import('@/layouts/DesktopLayout.vue'),
    meta: { requiresAuth: true, role: 'dosen' },
    children: [
      {
        path: '',
        name: 'DosenDashboard',
        component: () => import('@/views/dosen/DashboardView.vue')
      },
      {
        path: 'mahasiswa',
        name: 'DosenMahasiswa',
        component: () => import('@/views/dosen/MahasiswaView.vue')
      },
      {
        path: 'logbook',
        name: 'DosenLogbook',
        component: () => import('@/views/dosen/LogbookView.vue')
      },
      {
        path: 'profile',
        name: 'DosenProfile',
        component: () => import('@/views/dosen/ProfileView.vue')
      }
    ]
  },

  {
    path: '/admin',
    name: 'Admin',
    component: () => import('@/layouts/DesktopLayout.vue'),
    meta: { requiresAuth: true, role: 'admin' },
    children: [
      {
        path: '',
        name: 'AdminDashboard',
        component: () => import('@/views/admin/DashboardView.vue')
      },
      {
        path: 'lowongan',
        name: 'AdminLowongan',
        component: () => import('@/views/admin/LowonganView.vue')
      },
      {
        path: 'mahasiswa',
        name: 'AdminMahasiswa',
        component: () => import('@/views/admin/MahasiswaView.vue')
      },
      {
        path: 'dosen',
        name: 'AdminDosen',
        component: () => import('@/views/admin/DosenView.vue')
      },
      {
        path: 'mitra',
        name: 'AdminMitra',
        component: () => import('@/views/admin/MitraView.vue')
      },
      {
        path: 'profile',
        name: 'AdminProfile',
        component: () => import('@/views/admin/ProfileView.vue')
      }
    ]
  },

  {
    path: '/mitra',
    name: 'Mitra',
    component: () => import('@/layouts/MitraLayout.vue'),
    meta: { requiresAuth: true, role: 'mitra' },
    children: [
      {
        path: '',
        name: 'MitraDashboard',
        component: () => import('@/views/mitra/DashboardView.vue')
      },
      {
        path: 'lowongan',
        name: 'MitraLowongan',
        component: () => import('@/views/mitra/LowonganView.vue')
      },
      {
        path: 'pendaftaran',
        name: 'MitraPendaftaran',
        component: () => import('@/views/mitra/PendaftaranView.vue')
      },
      {
        path: 'mahasiswa',
        name: 'MitraMahasiswa',
        component: () => import('@/views/mitra/MahasiswaView.vue')
      },
      {
        path: 'profile',
        name: 'MitraProfile',
        component: () => import('@/views/mitra/ProfileView.vue')
      }
    ]
  },

  // Catch all
  {
    path: '/:pathMatch(.*)*',
    redirect: '/login'
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { top: 0 }
    }
  }
})

// Navigation Guard
router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore()

  // Try to restore session on first load
  if (!authStore.initialized) {
    await authStore.checkAuth()
  }

  const requiresAuth = to.meta.requiresAuth
  const guestOnly = to.meta.guest
  const requiredRole = to.meta.role

  if (requiresAuth && !authStore.isAuthenticated) {
    return next({ name: 'Login', query: { redirect: to.fullPath } })
  }

  if (guestOnly && authStore.isAuthenticated) {
    return next({ name: authStore.defaultRoute })
  }

  if (requiredRole && authStore.user?.role !== requiredRole) {
    return next({ name: authStore.defaultRoute })
  }

  next()
})

export default router