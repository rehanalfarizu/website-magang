<template>
  <div class="dashboard-view animate-fade-in">
    <div class="mb-8">
      <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Dashboard Mitra</h2>
      <p class="text-gray-500 mt-1">Selamat datang, {{ authStore.userName }}</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8">
      <div v-for="(stat, index) in stats" :key="stat.label" class="stats-card animate-fade-in-up" :style="{ animationDelay: `${index * 100}ms` }">
        <div class="flex items-start justify-between">
          <div>
            <p class="text-sm font-medium text-gray-500">{{ stat.label }}</p>
            <p class="text-2xl md:text-3xl font-bold text-gray-900 mt-1">{{ stat.value }}</p>
          </div>
          <div :class="['w-12 h-12 rounded-xl flex items-center justify-center', stat.bgColor]">
            <component :is="stat.icon" :class="['w-6 h-6', stat.iconColor]" />
          </div>
        </div>
        <div class="mt-4">
          <span :class="['text-xs font-medium px-2 py-1 rounded-full', stat.badgeClass]">{{ stat.badge }}</span>
        </div>
      </div>
    </div>

    <!-- Recent Applications -->
    <div class="card">
      <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-semibold text-gray-900">Pendaftaran Terbaru</h3>
        <router-link to="{ name: 'MitraPendaftaran' }" class="text-sm font-medium text-brand-600 hover:text-brand-700">Lihat Semua</router-link>
      </div>
      <div class="divide-y divide-gray-100">
        <div v-for="app in recentApps" :key="app.id" class="p-4 md:p-5 flex items-center justify-between hover:bg-gray-50 transition-colors">
          <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-100 to-brand-200 flex items-center justify-center text-brand-600 font-semibold text-lg">
              {{ app.initials }}
            </div>
            <div>
              <p class="font-medium text-gray-900">{{ app.nama }}</p>
              <p class="text-sm text-gray-500">NIM: {{ app.nim }}</p>
            </div>
          </div>
          <div class="flex items-center gap-3">
            <span class="badge badge-warning">Pending</span>
            <button class="btn-primary text-sm px-4">Review</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, h } from 'vue'
import { useAuthStore } from '@/stores/auth/auth'

const authStore = useAuthStore()

const stats = [
  {
    label: 'Lowongan Aktif',
    value: '3',
    badge: 'Dibuka',
    badgeClass: 'bg-brand-100 text-brand-700',
    bgColor: 'bg-brand-50',
    iconColor: 'text-brand-600',
    icon: { render: () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' })]) }
  },
  {
    label: 'Pendaftar',
    value: '8',
    badge: 'Menunggu',
    badgeClass: 'bg-amber-100 text-amber-700',
    bgColor: 'bg-amber-50',
    iconColor: 'text-amber-600',
    icon: { render: () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z' })]) }
  },
  {
    label: 'Mahasiswa Magang',
    value: '5',
    badge: 'Aktif',
    badgeClass: 'bg-emerald-100 text-emerald-700',
    bgColor: 'bg-emerald-50',
    iconColor: 'text-emerald-600',
    icon: { render: () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' })]) }
  }
]

const recentApps = ref([
  { id: 1, nama: 'Rehan Alfarizi', nim: '23.11.5548', initials: 'RA' },
  { id: 2, nama: 'Nazal Syamaidzar', nim: '23.11.5547', initials: 'NS' },
  { id: 3, nama: 'Vendri Setyawan', nim: '23.11.5523', initials: 'VS' }
])
</script>

<style scoped>
.stats-card {
  position: relative;
  overflow: hidden;
}

.stats-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: linear-gradient(90deg, #2563eb, #7c3aed);
}

.animate-fade-in {
  animation: fadeIn 0.4s ease-out;
}

.animate-fade-in-up {
  animation: fadeInUp 0.5s ease-out;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>