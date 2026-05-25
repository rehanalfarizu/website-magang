<template>
  <div class="pendaftaran-view animate-fade-in">
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-gray-900">Pendaftaran Saya</h2>
      <p class="text-gray-500 text-sm mt-1">Pantau status pendaftaran magang Anda</p>
    </div>

    <!-- Tabs -->
    <div class="tabs mb-6">
      <button
        v-for="tab in tabs"
        :key="tab.id"
        @click="activeTab = tab.id"
        :class="['tab flex-1 justify-center', activeTab === tab.id ? 'tab-active' : '']"
      >
        {{ tab.label }}
        <span class="ml-1.5 px-1.5 py-0.5 text-2xs rounded-full" :class="activeTab === tab.id ? 'bg-brand-100 text-brand-700' : 'bg-gray-200 text-gray-500'">
          {{ tab.count }}
        </span>
      </button>
    </div>

    <!-- Application Cards -->
    <div class="space-y-4">
      <div v-for="(app, index) in filteredApps" :key="app.id" class="card-interactive p-5 animate-fade-in-up" :style="{ animationDelay: `${index * 50}ms` }">
        <div class="flex gap-4">
          <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center flex-shrink-0">
            <span class="text-xl font-bold text-gray-400">{{ app.company.charAt(0) }}</span>
          </div>
          <div class="flex-1 min-w-0">
            <div class="flex items-start justify-between">
              <div>
                <h3 class="font-semibold text-gray-900 text-lg">{{ app.position }}</h3>
                <p class="text-sm text-gray-500">{{ app.company }}</p>
              </div>
              <span :class="['badge', getStatusClass(app.status)]">{{ getStatusLabel(app.status) }}</span>
            </div>
          </div>
        </div>

        <!-- Status Timeline -->
        <div class="mt-6 pt-5 border-t border-gray-100">
          <div class="flex items-center justify-between relative">
            <!-- Progress Line -->
            <div class="absolute top-4 left-0 right-0 h-0.5 bg-gray-100 -z-10"></div>
            <div class="absolute top-4 left-0 h-0.5 bg-brand-500 -z-10" :style="{ width: getProgressWidth(app.status) }"></div>

            <div v-for="(step, idx) in app.timeline" :key="idx" class="flex flex-col items-center">
              <div :class="[
                'w-8 h-8 rounded-full flex items-center justify-center border-2 transition-colors',
                step.completed ? 'bg-brand-500 border-brand-500 text-white' :
                step.active ? 'bg-white border-brand-500 text-brand-500' :
                'bg-white border-gray-200 text-gray-400'
              ]">
                <svg v-if="step.completed" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span v-else class="text-xs font-medium">{{ idx + 1 }}</span>
              </div>
              <span class="text-2xs text-gray-400 mt-2">{{ step.label }}</span>
            </div>
          </div>
        </div>

        <!-- Feedback if rejected -->
        <div v-if="app.feedback" class="mt-5 p-4 bg-red-50 rounded-xl border border-red-100">
          <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
              <p class="text-sm font-medium text-red-700">Alasan Penolakan:</p>
              <p class="text-sm text-red-600 mt-1">{{ app.feedback }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-if="filteredApps.length === 0" class="empty-state">
      <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
      </svg>
      <p class="empty-state-title">Belum ada pendaftaran</p>
      <p class="empty-state-description">Mulai dengan mencari lowongan magang</p>
      <router-link to="{ name: 'MahasiswaLowongan' }" class="btn-primary mt-4">Cari Lowongan</router-link>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const activeTab = ref('all')

const tabs = [
  { id: 'all', label: 'Semua', count: 2 },
  { id: 'pending', label: 'Pending', count: 1 },
  { id: 'approved', label: 'Diterima', count: 1 },
  { id: 'rejected', label: 'Ditolak', count: 0 }
]

const applications = ref([
  {
    id: 1,
    position: 'Frontend Developer Intern',
    company: 'PT Teknologi Indonesia',
    status: 'pending_prodi',
    feedback: null,
    timeline: [
      { label: 'Dikirim', completed: true, active: false },
      { label: 'Prodi', completed: true, active: false },
      { label: 'Mitra', completed: false, active: true },
      { label: 'Selesai', completed: false, active: false }
    ]
  },
  {
    id: 2,
    position: 'UI/UX Designer Intern',
    company: 'CV Creative Studio',
    status: 'approved',
    feedback: null,
    timeline: [
      { label: 'Dikirim', completed: true, active: false },
      { label: 'Prodi', completed: true, active: false },
      { label: 'Mitra', completed: true, active: false },
      { label: 'Selesai', completed: true, active: false }
    ]
  }
])

const filteredApps = computed(() => {
  if (activeTab.value === 'all') return applications.value
  return applications.value.filter(app => app.status.includes(activeTab.value))
})

function getStatusClass(status) {
  const classes = {
    pending_prodi: 'badge-warning',
    pending_mitra: 'badge-warning',
    approved: 'badge-success',
    rejected_prodi: 'badge-danger',
    rejected_mitra: 'badge-danger'
  }
  return classes[status] || 'badge-primary'
}

function getStatusLabel(status) {
  const labels = {
    pending_prodi: 'Menunggu Validasi Prodi',
    pending_mitra: 'Menunggu Respon Mitra',
    approved: 'Diterima',
    rejected_prodi: 'Ditolak Prodi',
    rejected_mitra: 'Ditolak Mitra'
  }
  return labels[status] || status
}

function getProgressWidth(status) {
  const widths = {
    pending_prodi: '25%',
    pending_mitra: '50%',
    approved: '100%',
    rejected_prodi: '25%',
    rejected_mitra: '50%'
  }
  return widths[status] || '0%'
}
</script>

<style scoped>
.animate-fade-in {
  animation: fadeIn 0.3s ease-out;
}

.animate-fade-in-up {
  animation: fadeInUp 0.4s ease-out;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(15px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>