v<template>
  <div class="mitra-layout min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
      <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-16">
          <!-- Logo -->
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center shadow-sm">
              <span class="text-lg font-bold text-white">A</span>
            </div>
            <div>
              <p class="font-bold text-gray-900">Sistem Magang AMIKOM</p>
              <p class="text-xs text-gray-400">{{ authStore.userName }}</p>
            </div>
          </div>

          <!-- Navigation -->
          <nav class="hidden md:flex items-center gap-1">
            <router-link
              v-for="item in navItems"
              :key="item.route"
              :to="{ name: item.route }"
              :class="[
                'px-4 py-2 rounded-lg text-sm font-medium transition-colors',
                isActiveRoute(item.route)
                  ? 'bg-brand-50 text-brand-700'
                  : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
              ]"
            >
              {{ item.label }}
            </router-link>
          </nav>

          <!-- Actions -->
          <div class="flex items-center gap-3">
            <button class="relative p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
              </svg>
              <span v-if="unreadCount > 0" class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-danger-500 text-white text-xs rounded-full flex items-center justify-center font-medium">
                {{ unreadCount }}
              </span>
            </button>
            <button @click="handleLogout" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
              </svg>
              <span>Keluar</span>
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Mobile Navigation -->
    <nav class="md:hidden bg-white border-b border-gray-200 px-4 py-2 overflow-x-auto">
      <div class="flex gap-2">
        <router-link
          v-for="item in navItems"
          :key="item.route"
          :to="{ name: item.route }"
          :class="[
            'px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-colors',
            isActiveRoute(item.route)
              ? 'bg-brand-50 text-brand-700'
              : 'text-gray-600 bg-gray-50'
          ]"
        >
          {{ item.label }}
        </router-link>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 py-8">
      <router-view v-slot="{ Component }">
        <transition name="fade" mode="out-in">
          <component :is="Component" />
        </transition>
      </router-view>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
      <div class="max-w-7xl mx-auto px-6 py-6 text-center text-gray-400 text-sm">
        <p>Tim noName &copy; 2026 &bull; AMIKOM Yogyakarta</p>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, Transition } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth/auth'

const route = useRoute()
const router = useRouter()
const authStore = useAuthStore()

const unreadCount = ref(3)

const navItems = [
  { route: 'MitraDashboard', label: 'Dashboard' },
  { route: 'MitraLowongan', label: 'Lowongan Saya' },
  { route: 'MitraPendaftaran', label: 'Pendaftaran' },
  { route: 'MitraMahasiswa', label: 'Mahasiswa Magang' },
  { route: 'MitraProfile', label: 'Pengaturan' }
]

function isActiveRoute(routeName) {
  return route.name === routeName
}

async function handleLogout() {
  await authStore.logout()
  router.push({ name: 'Login' })
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>