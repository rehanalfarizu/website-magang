<template>
  <div class="desktop-layout min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside class="desktop-sidebar fixed left-0 top-0 bottom-0 w-72 bg-white border-r border-gray-200 z-30">
      <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="p-6 border-b border-gray-100">
          <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center shadow-glow">
              <span class="text-xl font-bold text-white">A</span>
            </div>
            <div>
              <p class="font-bold text-lg text-gray-900">Sistem Magang</p>
              <p class="text-xs text-gray-400">AMIKOM Yogyakarta</p>
            </div>
          </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4 px-3">
          <div class="px-3 mb-3">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu Utama</p>
          </div>
          <router-link
            v-for="item in navItems"
            :key="item.route"
            :to="{ name: item.route }"
            :class="[
              'flex items-center gap-3 px-4 py-3 rounded-xl mb-1 transition-all duration-200',
              isActiveRoute(item.route)
                ? 'bg-brand-50 text-brand-700 font-medium shadow-sm'
                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
            ]"
          >
            <component :is="item.icon" :class="['w-5 h-5', isActiveRoute(item.route) ? 'text-brand-600' : 'text-gray-400']" />
            <span>{{ item.label }}</span>
            <span v-if="item.badge" class="ml-auto px-2 py-0.5 text-xs font-medium bg-danger-100 text-danger-600 rounded-full">
              {{ item.badge }}
            </span>
          </router-link>
        </nav>

        <!-- User Section -->
        <div class="p-4 border-t border-gray-100">
          <div class="bg-gray-50 rounded-xl p-4 mb-4">
            <div class="flex items-center gap-3">
              <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center text-white font-semibold shadow-sm">
                {{ userInitials }}
              </div>
              <div class="flex-1 min-w-0">
                <p class="font-medium text-gray-900 truncate text-sm">{{ authStore.userName }}</p>
                <p class="text-xs text-gray-400 truncate">{{ roleLabel }}</p>
              </div>
            </div>
          </div>
          <button @click="handleLogout" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-gray-900 rounded-xl transition-colors text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span>Keluar</span>
          </button>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="desktop-main ml-72">
      <!-- Top Bar -->
      <header class="bg-white/80 backdrop-blur-lg border-b border-gray-200 px-6 py-4 sticky top-0 z-20">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-xl font-bold text-gray-900">{{ pageTitle }}</h1>
          </div>
          <div class="flex items-center gap-3">
            <!-- Search -->
            <div class="relative hidden md:block">
              <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              <input type="text" placeholder="Cari..." class="w-64 pl-10 pr-4 py-2 text-sm bg-gray-100 border-0 rounded-xl focus:ring-2 focus:ring-brand-500 transition-all" />
            </div>

            <!-- Notifications -->
            <button class="relative p-2.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-colors">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
              </svg>
              <span v-if="unreadCount > 0" class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-danger-500 text-white text-xs rounded-full flex items-center justify-center font-medium">
                {{ unreadCount > 9 ? '9+' : unreadCount }}
              </span>
            </button>
          </div>
        </div>
      </header>

      <!-- Page Content -->
      <main class="p-6">
        <router-view v-slot="{ Component }">
          <transition name="fade" mode="out-in">
            <component :is="Component" />
          </transition>
        </router-view>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, Transition } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth/auth'
import IconHome from '@/components/common/IconHome.vue'
import IconBriefcase from '@/components/common/IconBriefcase.vue'
import IconUsers from '@/components/common/IconUsers.vue'
import IconAcademic from '@/components/common/IconAcademic.vue'
import IconBuilding from '@/components/common/IconBuilding.vue'
import IconDocument from '@/components/common/IconDocument.vue'
import IconUser from '@/components/common/IconUser.vue'

const route = useRoute()
const router = useRouter()
const authStore = useAuthStore()

const unreadCount = ref(5)

const navItems = computed(() => {
  const role = authStore.userRole

  if (role === 'admin') {
    return [
      { route: 'AdminDashboard', label: 'Dashboard', icon: IconHome },
      { route: 'AdminLowongan', label: 'Kelola Lowongan', icon: IconBriefcase },
      { route: 'AdminMahasiswa', label: 'Mahasiswa', icon: IconUsers },
      { route: 'AdminDosen', label: 'Dosen', icon: IconAcademic },
      { route: 'AdminMitra', label: 'Mitra', icon: IconBuilding },
      { route: 'AdminProfile', label: 'Pengaturan', icon: IconUser }
    ]
  }

  if (role === 'dosen') {
    return [
      { route: 'DosenDashboard', label: 'Dashboard', icon: IconHome },
      { route: 'DosenMahasiswa', label: 'Mahasiswa Bimbingan', icon: IconUsers },
      { route: 'DosenLogbook', label: 'Review Logbook', icon: IconDocument },
      { route: 'DosenProfile', label: 'Pengaturan', icon: IconUser }
    ]
  }

  return []
})

const roleLabel = computed(() => {
  const labels = {
    admin: 'Administrator',
    dosen: 'Dosen Pembimbing',
    mitra: 'Mitra Perusahaan'
  }
  return labels[authStore.userRole] || 'User'
})

const pageTitle = computed(() => {
  const titles = {
    AdminDashboard: 'Dashboard Admin',
    AdminLowongan: 'Kelola Lowongan',
    AdminMahasiswa: 'Manajemen Mahasiswa',
    AdminDosen: 'Manajemen Dosen',
    AdminMitra: 'Manajemen Mitra',
    AdminProfile: 'Pengaturan Akun',
    DosenDashboard: 'Dashboard Dosen',
    DosenMahasiswa: 'Mahasiswa Bimbingan',
    DosenLogbook: 'Review Logbook',
    DosenProfile: 'Pengaturan Akun'
  }
  return titles[route.name] || 'Sistem Magang'
})

const userInitials = computed(() => {
  const name = authStore.userName
  return name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2)
})

function isActiveRoute(routeName) {
  return route.name === routeName
}

async function handleLogout() {
  await authStore.logout()
  router.push({ name: 'Login' })
}
</script>

<style scoped>
.desktop-layout {
  min-height: 100vh;
  background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 50%, #fafafa 100%);
}

.desktop-main {
  min-height: 100vh;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>