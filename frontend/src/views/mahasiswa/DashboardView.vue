<template>
  <div class="dashboard-view animate-fade-in">
    <!-- Welcome Header -->
    <div class="mb-8">
      <p class="text-gray-500 text-sm mb-1">Selamat datang kembali,</p>
      <h2 class="text-2xl md:text-3xl font-bold text-gray-900">{{ authStore.userName }}</h2>
    </div>

    <!-- Stats Cards -->
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
          <div class="flex items-center gap-2">
            <span :class="['text-xs font-medium px-2 py-1 rounded-full', stat.badgeClass]">{{ stat.badge }}</span>
            <span class="text-xs text-gray-400">{{ stat.subtitle }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
      <!-- Progress Card -->
      <div class="lg:col-span-2 card p-6">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-lg font-semibold text-gray-900">Progres Magang</h3>
          <router-link to="{ name: 'MahasiswaProgres' }" class="text-sm font-medium text-brand-600 hover:text-brand-700">Lihat Detail</router-link>
        </div>

        <div class="flex items-center gap-6">
          <!-- Circular Progress -->
          <div class="relative w-32 h-32 flex-shrink-0">
            <svg class="w-full h-full transform -rotate-90">
              <circle cx="64" cy="64" r="56" stroke="#f0f0f0" stroke-width="10" fill="none" />
              <circle cx="64" cy="64" r="56" stroke="url(#gradient)" stroke-width="10" fill="none" stroke-linecap="round"
                :stroke-dasharray="circumference"
                :stroke-dashoffset="progressOffset"
              />
              <defs>
                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                  <stop offset="0%" stop-color="#2563eb" />
                  <stop offset="100%" stop-color="#7c3aed" />
                </linearGradient>
              </defs>
            </svg>
            <div class="absolute inset-0 flex items-center justify-center">
              <div class="text-center">
                <span class="text-3xl font-bold text-gray-900">{{ progres.progres }}%</span>
              </div>
            </div>
          </div>

          <!-- Progress Details -->
          <div class="flex-1 space-y-4">
            <div>
              <div class="flex justify-between text-sm mb-2">
                <span class="text-gray-600">Bulan ke-{{ progres.currentMonth }} dari {{ progres.totalMonth }}</span>
                <span class="font-medium text-gray-900">{{ progres.currentMonth }}/{{ progres.totalMonth }}</span>
              </div>
              <div class="progress-bar">
                <div class="progress-bar-fill bg-gradient-to-r from-brand-500 to-brand-600" :style="{ width: (progres.currentMonth / progres.totalMonth * 100) + '%' }"></div>
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-100">
              <div>
                <p class="text-xs text-gray-400">Logbook Disetujui</p>
                <p class="text-lg font-semibold text-gray-900">{{ progres.logbookApproved }}/{{ progres.totalMonth }}</p>
              </div>
              <div>
                <p class="text-xs text-gray-400">Sisa Waktu</p>
                <p class="text-lg font-semibold text-gray-900">{{ progres.totalMonth - progres.currentMonth }} bulan</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Info Card -->
      <div class="card p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Info Magang</h3>

        <div class="space-y-4">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-brand-50 flex items-center justify-center">
              <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
            </div>
            <div>
              <p class="text-xs text-gray-400">Perusahaan</p>
              <p class="text-sm font-medium text-gray-900">{{ company.name }}</p>
            </div>
          </div>

          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center">
              <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </div>
            <div>
              <p class="text-xs text-gray-400">Dosen Pembimbing</p>
              <p class="text-sm font-medium text-gray-900">{{ company.dosen }}</p>
            </div>
          </div>

          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center">
              <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            <div>
              <p class="text-xs text-gray-400">Tanggal Mulai</p>
              <p class="text-sm font-medium text-gray-900">{{ company.startDate }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Activity -->
    <div class="card">
      <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terakhir</h3>
      </div>
      <div class="divide-y divide-gray-100">
        <div v-for="(activity, index) in activities" :key="activity.id" class="p-4 md:p-6 flex items-center gap-4 hover:bg-gray-50 transition-colors">
          <div :class="['w-10 h-10 rounded-xl flex items-center justify-center', activity.iconBg]">
            <component :is="activity.icon" :class="['w-5 h-5', activity.iconColor]" />
          </div>
          <div class="flex-1 min-w-0">
            <p class="font-medium text-gray-900">{{ activity.title }}</p>
            <p class="text-sm text-gray-500">{{ activity.desc }}</p>
          </div>
          <span class="text-xs text-gray-400 whitespace-nowrap">{{ activity.time }}</span>
        </div>
      </div>
      <div class="p-4 bg-gray-50 text-center">
        <button class="text-sm font-medium text-brand-600 hover:text-brand-700">Lihat Semua Aktivitas</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, h } from 'vue'
import { useAuthStore } from '@/stores/auth/auth'

const authStore = useAuthStore()

const circumference = 351.86

const progres = ref({
  progres: 33,
  currentMonth: 2,
  totalMonth: 6,
  logbookApproved: 1
})

const company = ref({
  name: 'PT Teknologi Indonesia',
  dosen: 'Bambang Pilu Hartato, S.Kom.',
  startDate: '1 April 2026'
})

const stats = [
  {
    label: 'Logbook Tertunda',
    value: '1',
    badge: 'Segera kirim',
    badgeClass: 'bg-amber-100 text-amber-700',
    bgColor: 'bg-amber-50',
    iconColor: 'text-amber-600',
    subtitle: 'logbook bulan ini',
    icon: {
      render() {
        return h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [
          h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.894.553l2.414 2.414a1 1 0 01.553.894V19a2 2 0 01-2 2z' })
        ])
      }
    }
  },
  {
    label: 'Logbook Disetujui',
    value: '1',
    badge: 'Lancar',
    badgeClass: 'bg-emerald-100 text-emerald-700',
    bgColor: 'bg-emerald-50',
    iconColor: 'text-emerald-600',
    subtitle: 'dari 6 bulan',
    icon: {
      render() {
        return h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [
          h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' })
        ])
      }
    }
  },
  {
    label: 'Durasi Magang',
    value: '2',
    badge: 'Bulan',
    badgeClass: 'bg-brand-100 text-brand-700',
    bgColor: 'bg-brand-50',
    iconColor: 'text-brand-600',
    subtitle: 'dari 6 bulan',
    icon: {
      render() {
        return h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [
          h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' })
        ])
      }
    }
  },
  {
    label: 'Progres Keseluruhan',
    value: '33%',
    badge: 'On Track',
    badgeClass: 'bg-blue-100 text-blue-700',
    bgColor: 'bg-blue-50',
    iconColor: 'text-blue-600',
    subtitle: ' Target 100%',
    icon: {
      render() {
        return h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [
          h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' })
        ])
      }
    }
  }
]

const activities = ref([
  {
    id: 1,
    title: 'Logbook Mei 2026 disetujui',
    desc: 'Dosen telah menyetujui logbook bulan Mei',
    time: '2 jam lalu',
    iconBg: 'bg-emerald-50',
    iconColor: 'text-emerald-600',
    icon: {
      render() {
        return h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [
          h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M5 13l4 4L19 7' })
        ])
      }
    }
  },
  {
    id: 2,
    title: 'Logbook Juni 2026 dikirim',
    desc: 'Sedang menunggu review dosen',
    time: '1 hari lalu',
    iconBg: 'bg-brand-50',
    iconColor: 'text-brand-600',
    icon: {
      render() {
        return h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [
          h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M12 19l9 2-9-18-9 18 9 2zm0 0v-8' })
        ])
      }
    }
  },
  {
    id: 3,
    title: 'Pendaftaran diterima',
    desc: 'Diterima di PT Teknologi Indonesia',
    time: '3 hari lalu',
    iconBg: 'bg-violet-50',
    iconColor: 'text-violet-600',
    icon: {
      render() {
        return h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24' }, [
          h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'stroke-width': '2', d: 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' })
        ])
      }
    }
  }
])

const progressOffset = computed(() => {
  return circumference - (progres.value.progres / 100 * circumference)
})
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
  animation: fadeIn 0.5s ease-out;
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