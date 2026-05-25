<template>
  <div class="dashboard-view animate-fade-in">
    <div class="mb-8">
      <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Dashboard Admin Prodi</h2>
      <p class="text-gray-500 mt-1">Selamat datang di Sistem Magang AMIKOM</p>
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

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Pendaftaran Pending -->
      <div class="card">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
          <h3 class="font-semibold text-gray-900">Pendaftaran Pending</h3>
          <span class="badge badge-warning">{{ pendingApps.length }}</span>
        </div>
        <div class="divide-y divide-gray-100">
          <div v-for="item in pendingApps" :key="item.id" class="p-4 md:p-5 flex items-center justify-between hover:bg-gray-50 transition-colors">
            <div class="flex items-center gap-4">
              <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-100 to-brand-200 flex items-center justify-center text-brand-600 font-semibold">
                {{ item.initials }}
              </div>
              <div>
                <p class="font-medium text-gray-900">{{ item.nama }}</p>
                <p class="text-sm text-gray-500">{{ item.perusahaan }}</p>
              </div>
            </div>
            <button class="btn-primary text-sm px-4">Validasi</button>
          </div>
        </div>
        <div class="p-4 bg-gray-50 text-center">
          <button class="text-sm font-medium text-brand-600 hover:text-brand-700">Lihat Semua</button>
        </div>
      </div>

      <!-- Lowongan Perlu Kurasi -->
      <div class="card">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
          <h3 class="font-semibold text-gray-900">Lowongan Perlu Kurasi</h3>
          <span class="badge badge-info">{{ pendingLowongan.length }}</span>
        </div>
        <div class="divide-y divide-gray-100">
          <div v-for="item in pendingLowongan" :key="item.id" class="p-4 md:p-5 flex items-center justify-between hover:bg-gray-50 transition-colors">
            <div>
              <p class="font-medium text-gray-900">{{ item.posisi }}</p>
              <p class="text-sm text-gray-500">{{ item.mitra }}</p>
            </div>
            <button class="btn-outline text-sm px-4">Review</button>
          </div>
        </div>
        <div class="p-4 bg-gray-50 text-center">
          <button class="text-sm font-medium text-brand-600 hover:text-brand-700">Lihat Semua</button>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="card mt-6 p-6">
      <h3 class="font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <button class="flex flex-col items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
          <div class="w-12 h-12 rounded-xl bg-brand-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
          </div>
          <span class="text-sm font-medium text-gray-700">Tambah Lowongan</span>
        </button>
        <button class="flex flex-col items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
          <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <span class="text-sm font-medium text-gray-700">Validasi Pendaftaran</span>
        </button>
        <button class="flex flex-col items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
          <div class="w-12 h-12 rounded-xl bg-violet-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
          </div>
          <span class="text-sm font-medium text-gray-700">Kelola Mahasiswa</span>
        </button>
        <button class="flex flex-col items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
          <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5" />
            </svg>
          </div>
          <span class="text-sm font-medium text-gray-700">Kelola Mitra</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, h } from 'vue'

const stats = [
  {
    label: 'Total Mahasiswa',
    value: '156',
    badge: '+12 bulan ini',
    badgeClass: 'bg-brand-100 text-brand-700',
    bgColor: 'bg-brand-50',
    iconColor: 'text-brand-600',
    icon: { render: () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z' })]) }
  },
  {
    label: 'Mahasiswa Aktif',
    value: '89',
    badge: 'Sedang magang',
    badgeClass: 'bg-emerald-100 text-emerald-700',
    bgColor: 'bg-emerald-50',
    iconColor: 'text-emerald-600',
    icon: { render: () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' })]) }
  },
  {
    label: 'Mitra Aktif',
    value: '24',
    badge: '+3 bulan ini',
    badgeClass: 'bg-violet-100 text-violet-700',
    bgColor: 'bg-violet-50',
    iconColor: 'text-violet-600',
    icon: { render: () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4' })]) }
  },
  {
    label: 'Lowongan Aktif',
    value: '18',
    badge: 'Tersedia',
    badgeClass: 'bg-amber-100 text-amber-700',
    bgColor: 'bg-amber-50',
    iconColor: 'text-amber-600',
    icon: { render: () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' })]) }
  }
]

const pendingApps = ref([
  { id: 1, nama: 'Rehan Alfarizi', perusahaan: 'PT Teknologi Indonesia', initials: 'RA' },
  { id: 2, nama: 'Nazal Syamaidzar', perusahaan: 'Startup Hub Indonesia', initials: 'NS' },
  { id: 3, nama: 'Vendri Setyawan', perusahaan: 'CV Digital Indonesia', initials: 'VS' }
])

const pendingLowongan = ref([
  { id: 1, posisi: 'Frontend Developer', mitra: 'PT Teknologi Indonesia' },
  { id: 2, posisi: 'UI/UX Designer', mitra: 'CV Creative Studio' }
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