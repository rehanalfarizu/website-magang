<template>
  <div class="progres-view animate-fade-in">
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-gray-900">Progres Magang</h2>
      <p class="text-gray-500 text-sm mt-1">Pantau perkembangan magang Anda</p>
    </div>

    <!-- Overall Progress Card -->
    <div class="card p-8 mb-6 text-center">
      <div class="inline-flex items-center justify-center mb-6">
        <div class="relative w-40 h-40">
          <svg class="w-full h-full transform -rotate-90">
            <circle cx="80" cy="80" r="70" stroke="#f0f0f0" stroke-width="12" fill="none" />
            <circle cx="80" cy="80" r="70" stroke="url(#progressGradient)" stroke-width="12" fill="none"
              stroke-linecap="round"
              :stroke-dasharray="circumference"
              :stroke-dashoffset="progressOffset"
            />
            <defs>
              <linearGradient id="progressGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#2563eb" />
                <stop offset="100%" stop-color="#7c3aed" />
              </linearGradient>
            </defs>
          </svg>
          <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center">
              <span class="text-4xl font-bold text-gray-900">{{ progres }}</span>
              <span class="text-lg text-gray-500">%</span>
            </div>
          </div>
        </div>
      </div>
      <p class="text-gray-600">Progres magang Anda saat ini</p>
      <p class="text-sm text-gray-400 mt-2">Bulan ke-{{ currentMonth }} dari {{ totalMonth }} bulan</p>
    </div>

    <!-- Detail Progress -->
    <div class="card p-6 mb-6">
      <h3 class="font-semibold text-gray-900 mb-5">Detail Progres</h3>
      <div class="space-y-5">
        <div>
          <div class="flex justify-between mb-2">
            <span class="text-sm text-gray-600">Logbook Disetujui</span>
            <span class="text-sm font-semibold text-gray-900">{{ logbookStats.approved }}/{{ logbookStats.total }} bulan</span>
          </div>
          <div class="progress-bar">
            <div class="progress-bar-fill bg-gradient-to-r from-emerald-500 to-emerald-400" :style="{ width: (logbookStats.approved / logbookStats.total * 100) + '%' }"></div>
          </div>
        </div>
        <div>
          <div class="flex justify-between mb-2">
            <span class="text-sm text-gray-600">Durasi Magang</span>
            <span class="text-sm font-semibold text-gray-900">{{ currentMonth }}/{{ totalMonth }} bulan</span>
          </div>
          <div class="progress-bar">
            <div class="progress-bar-fill bg-gradient-to-r from-brand-500 to-brand-400" :style="{ width: (currentMonth / totalMonth * 100) + '%' }"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
      <!-- Company Info -->
      <div class="card p-5">
        <h4 class="text-sm font-medium text-gray-400 mb-4">Perusahaan</h4>
        <div class="flex items-center gap-4">
          <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
            <span class="text-xl font-bold text-gray-400">{{ company.name.charAt(0) }}</span>
          </div>
          <div>
            <p class="font-semibold text-gray-900">{{ company.name }}</p>
            <p class="text-sm text-gray-500">{{ company.address }}</p>
          </div>
        </div>
      </div>

      <!-- Supervisor Info -->
      <div class="card p-5">
        <h4 class="text-sm font-medium text-gray-400 mb-4">Dosen Pembimbing</h4>
        <div class="flex items-center gap-4">
          <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-brand-100 to-brand-200 flex items-center justify-center">
            <span class="text-lg font-bold text-brand-600">{{ supervisor.initials }}</span>
          </div>
          <div>
            <p class="font-semibold text-gray-900">{{ supervisor.name }}</p>
            <p class="text-sm text-gray-500">{{ supervisor.email }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Timeline -->
    <div class="card p-6">
      <h3 class="font-semibold text-gray-900 mb-5">Timeline Magang</h3>
      <div class="space-y-4">
        <div v-for="(month, index) in timeline" :key="index" class="flex items-start gap-4">
          <div :class="[
            'w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0',
            month.status === 'done' ? 'bg-emerald-500 text-white' :
            month.status === 'current' ? 'bg-brand-500 text-white' :
            'bg-gray-100 text-gray-400'
          ]">
            <svg v-if="month.status === 'done'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span v-else class="text-sm font-medium">{{ index + 1 }}</span>
          </div>
          <div class="flex-1 pb-4 border-b border-gray-100 last:border-0">
            <p class="font-medium text-gray-900">{{ month.name }}</p>
            <p v-if="month.feedback" class="text-sm text-emerald-600 mt-1">{{ month.feedback }}</p>
            <p v-else-if="month.status === 'current'" class="text-sm text-brand-600 mt-1">Sedang berlangsung</p>
            <p v-else class="text-sm text-gray-400 mt-1">Menunggu</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const progres = 33
const circumference = 439.82
const currentMonth = 2
const totalMonth = 6

const progressOffset = computed(() => {
  return circumference - (progres / 100 * circumference)
})

const logbookStats = {
  approved: 1,
  total: 6
}

const company = {
  name: 'PT Teknologi Indonesia',
  address: 'Jl. Magelang No. 123, Yogyakarta'
}

const supervisor = {
  name: 'Bambang Pilu Hartato, S.Kom., M.Eng.',
  email: 'bambang@amikom.ac.id',
  initials: 'BH'
}

const timeline = ref([
  { name: 'April 2026', status: 'done', feedback: 'Disetujui' },
  { name: 'Mei 2026', status: 'done', feedback: 'Disetujui' },
  { name: 'Juni 2026', status: 'current', feedback: null },
  { name: 'Juli 2026', status: 'pending', feedback: null },
  { name: 'Agustus 2026', status: 'pending', feedback: null },
  { name: 'September 2026', status: 'pending', feedback: null }
])
</script>

<style scoped>
.animate-fade-in {
  animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
</style>