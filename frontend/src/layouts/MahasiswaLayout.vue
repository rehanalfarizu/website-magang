<template>
  <div class="mobile-layout min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="mobile-header fixed top-0 left-0 right-0 z-40 bg-white/80 backdrop-blur-lg border-b border-gray-200">
      <div class="flex items-center justify-between px-4 h-16">
        <button @click="toggleSidebar" class="p-2 -ml-2 rounded-xl hover:bg-gray-100 transition-colors">
          <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
        <div class="flex items-center gap-2">
          <span class="text-sm font-semibold text-gray-900">{{ pageTitle }}</span>
        </div>
        <button @click="showNotifications = !showNotifications" class="p-2 -mr-2 rounded-xl hover:bg-gray-100 transition-colors relative">
          <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
          </svg>
          <span v-if="unreadCount > 0" class="absolute top-1.5 right-1.5 w-2 h-2 bg-danger-500 rounded-full animate-pulse"></span>
        </button>
      </div>
    </header>

    <!-- Sidebar Overlay -->
    <Transition name="fade">
      <div v-if="sidebarOpen" @click="toggleSidebar" class="fixed inset-0 bg-gray-950/50 z-40 backdrop-blur-sm"></div>
    </Transition>

    <!-- Sidebar -->
    <Transition name="slide">
      <aside v-if="sidebarOpen" class="mobile-sidebar fixed top-0 left-0 h-full w-80 bg-white z-50 shadow-large">
        <div class="flex flex-col h-full">
          <!-- Header -->
          <div class="p-6 border-b border-gray-100">
            <div class="flex items-center gap-4">
              <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center text-white text-xl font-bold shadow-md">
                {{ userInitials }}
              </div>
              <div class="flex-1 min-w-0">
                <p class="font-semibold text-gray-900 truncate">{{ authStore.userName }}</p>
                <p class="text-sm text-gray-500 truncate">{{ authStore.userEmail }}</p>
              </div>
            </div>
          </div>

          <!-- Navigation -->
          <nav class="flex-1 overflow-y-auto py-4">
            <div class="px-4 mb-3">
              <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu Utama</p>
            </div>
            <router-link
              v-for="(item, index) in navItems"
              :key="item.route"
              :to="{ name: item.route }"
              @click="toggleSidebar"
              :class="[
                'flex items-center gap-3 mx-3 px-4 py-3 rounded-xl transition-all duration-200',
                isActiveRoute(item.route)
                  ? 'bg-brand-50 text-brand-700 font-medium'
                  : 'text-gray-600 hover:bg-gray-50'
              ]"
              :style="{ animationDelay: `${index * 50}ms` }"
            >
              <component :is="item.icon" :class="['w-5 h-5', isActiveRoute(item.route) ? 'text-brand-600' : 'text-gray-400']" />
              <span>{{ item.label }}</span>
              <span v-if="item.badge" class="ml-auto px-2 py-0.5 text-xs font-medium bg-danger-100 text-danger-600 rounded-full">
                {{ item.badge }}
              </span>
            </router-link>
          </nav>

          <!-- Footer -->
          <div class="p-4 border-t border-gray-100">
            <button @click="handleLogout" class="w-full flex items-center justify-center gap-2 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl transition-colors font-medium">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
              </svg>
              <span>Keluar</span>
            </button>
          </div>
        </div>
      </aside>
    </Transition>

    <!-- Main Content -->
    <main class="mobile-content pt-16 pb-24 safe-pb">
      <div class="px-4 py-6">
        <router-view v-slot="{ Component }">
          <transition name="fade" mode="out-in">
            <component :is="Component" />
          </transition>
        </router-view>
      </div>
    </main>

    <!-- Bottom Navigation -->
    <nav class="mobile-bottom-nav fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-lg border-t border-gray-200 z-30">
      <div class="flex justify-around items-center h-16">
        <router-link
          v-for="item in bottomNavItems"
          :key="item.route"
          :to="{ name: item.route }"
          class="flex flex-col items-center justify-center w-full h-full text-gray-400 transition-colors tap-target"
          :class="isActiveRoute(item.route) ? 'text-brand-600' : 'hover:text-gray-600'"
        >
          <component :is="item.icon" class="w-6 h-6" />
          <span class="text-[10px] mt-1 font-medium">{{ item.label }}</span>
          <span v-if="isActiveRoute(item.route)" class="absolute top-0 w-8 h-0.5 bg-brand-600 rounded-full"></span>
        </router-link>
      </div>
    </nav>
  </div>
</template>

<script setup>
import { ref, computed, Transition } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth/auth'
import IconHome from '@/components/common/IconHome.vue'
import IconBriefcase from '@/components/common/IconBriefcase.vue'
import IconDocument from '@/components/common/IconDocument.vue'
import IconUser from '@/components/common/IconUser.vue'
import IconChart from '@/components/common/IconChart.vue'

const route = useRoute()
const router = useRouter()
const authStore = useAuthStore()

const sidebarOpen = ref(false)
const showNotifications = ref(false)
const unreadCount = ref(3)

const navItems = [
  { route: 'MahasiswaDashboard', label: 'Beranda', icon: IconHome },
  { route: 'MahasiswaLowongan', label: 'Lowongan Magang', icon: IconBriefcase },
  { route: 'MahasiswaLogbook', label: 'Logbook', icon: IconDocument },
  { route: 'MahasiswaProgres', label: 'Progres', icon: IconChart },
  { route: 'MahasiswaProfile', label: 'Pengaturan', icon: IconUser }
]

const bottomNavItems = [
  { route: 'MahasiswaDashboard', label: 'Beranda', icon: IconHome },
  { route: 'MahasiswaLowongan', label: 'Lowongan', icon: IconBriefcase },
  { route: 'MahasiswaLogbook', label: 'Logbook', icon: IconDocument },
  { route: 'MahasiswaProfile', label: 'Profil', icon: IconUser }
]

const pageTitle = computed(() => {
  const titles = {
    'MahasiswaDashboard': 'Beranda',
    'MahasiswaLowongan': 'Lowongan',
    'MahasiswaPendaftaran': 'Pendaftaran',
    'MahasiswaLogbook': 'Logbook',
    'MahasiswaProgres': 'Progres',
    'MahasiswaProfile': 'Profil'
  }
  return titles[route.name] || 'Sistem Magang'
})

const userInitials = computed(() => {
  const name = authStore.userName
  return name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2)
})

function toggleSidebar() {
  sidebarOpen.value = !sidebarOpen.value
}

function isActiveRoute(routeName) {
  return route.name === routeName
}

async function handleLogout() {
  await authStore.logout()
  router.push({ name: 'Login' })
}
</script>

<style scoped>
.mobile-layout {
  min-height: 100vh;
  background: linear-gradient(180deg, #fafafa 0%, #f5f5f5 100%);
}

.mobile-content {
  min-height: calc(100vh - 4rem - 4rem);
}

/* Transitions */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.slide-enter-active,
.slide-leave-active {
  transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.slide-enter-from,
.slide-leave-to {
  transform: translateX(-100%);
}

.mobile-bottom-nav {
  padding-bottom: env(safe-area-inset-bottom);
}
</style>