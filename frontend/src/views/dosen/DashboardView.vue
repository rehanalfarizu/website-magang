<template>
  <div class="dashboard-view animate-fade-in">
    <div class="mb-8">
      <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Dashboard Dosen Pembimbing</h2>
      <p class="text-gray-500 mt-1">Selamat datang, {{ authStore.userName }}</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
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

    <!-- Logbook Reviews -->
    <div class="card">
      <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-semibold text-gray-900">Logbook Perlu Review</h3>
        <router-link to="{ name: 'DosenLogbook' }" class="text-sm font-medium text-brand-600 hover:text-brand-700">Lihat Semua</router-link>
      </div>
      <div class="divide-y divide-gray-100">
        <div v-for="item in pendingLogbooks" :key="item.id" class="p-4 md:p-5 flex items-center justify-between hover:bg-gray-50 transition-colors">
          <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-100 to-brand-200 flex items-center justify-center text-brand-600 font-semibold text-lg">
              {{ item.initials }}
            </div>
            <div>
              <p class="font-medium text-gray-900">{{ item.nama }}</p>
              <p class="text-sm text-gray-500">Logbook {{ item.bulan }} &bull; {{ item.tanggal }}</p>
            </div>
          </div>
          <span class="badge badge-warning">Menunggu</span>
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
    label: 'Total Mahasiswa',
    value: '12',
    badge: 'Bimbingan aktif',
    badgeClass: 'bg-brand-100 text-brand-700',
    bgColor: 'bg-brand-50',
    iconColor: 'text-brand-600',
    icon: { render: () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z' })]) }
  },
  {
    label: 'Logbook Pending',
    value: '5',
    badge: 'Perlu review',
    badgeClass: 'bg-amber-100 text-amber-700',
    bgColor: 'bg-amber-50',
    iconColor: 'text-amber-600',
    icon: { render: () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' })]) }
  },
  {
    label: 'Magang Aktif',
    value: '10',
    badge: 'Sedang berjalan',
    badgeClass: 'bg-emerald-100 text-emerald-700',
    bgColor: 'bg-emerald-50',
    iconColor: 'text-emerald-600',
    icon: { render: () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' })]) }
  },
  {
    label: 'Selesai Magang',
    value: '2',
    badge: 'Lulus',
    badgeClass: 'bg-violet-100 text-violet-700',
    bgColor: 'bg-violet-50',
    iconColor: 'text-violet-600',
    icon: { render: () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M5 13l4 4L19 7' })]) }
  }
]

const pendingLogbooks = ref([
  { id: 1, nama: 'Ahmad Natsrul Ulum', initials: 'AN', bulan: 'Juni 2026', tanggal: '28 Juni 2026' },
  { id: 2, nama: 'Nazal Syamaidzar M', initials: 'NS', bulan: 'Juni 2026', tanggal: '27 Juni 2026' },
  { id: 3, nama: 'Zulfa Meydita Rahma', initials: 'ZM', bulan: 'Mei 2026', tanggal: '28 Mei 2026' },
  { id: 4, nama: 'Vendri Setyawan', initials: 'VS', bulan: 'Juni 2026', tanggal: '26 Juni 2026' }
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