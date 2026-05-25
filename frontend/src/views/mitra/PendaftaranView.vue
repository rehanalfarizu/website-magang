<template>
  <div class="pendaftaran-view">
    <h2 class="text-2xl font-bold text-neutral-800 mb-6">Pendaftaran Masuk</h2>

    <!-- Tabs -->
    <div class="flex gap-2 mb-6">
      <button
        v-for="tab in tabs"
        :key="tab.id"
        @click="activeTab = tab.id"
        :class="[
          'px-4 py-2 rounded-lg text-sm font-medium transition-colors',
          activeTab === tab.id ? 'bg-primary-600 text-white' : 'bg-white text-neutral-600 border border-neutral-200'
        ]"
      >
        {{ tab.label }} ({{ tab.count }})
      </button>
    </div>

    <div class="space-y-4">
      <div v-for="app in filteredApps" :key="app.id" class="card p-4">
        <div class="flex items-start gap-4 mb-4">
          <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold flex-shrink-0">
            {{ app.initials }}
          </div>
          <div class="flex-1">
            <h3 class="font-semibold text-neutral-800">{{ app.nama }}</h3>
            <p class="text-sm text-neutral-500">NIM: {{ app.nim }}</p>
            <p class="text-sm text-neutral-500">IPK: {{ app.ipk }} | Semester: {{ app.semester }}</p>
          </div>
          <span :class="['badge', getStatusBadge(app.status)]">{{ app.status }}</span>
        </div>

        <div class="bg-neutral-50 rounded-lg p-4 mb-4">
          <p class="text-sm font-medium text-neutral-700 mb-1">Lowongan:</p>
          <p class="text-sm text-neutral-600">{{ app.lowongan }}</p>
          <p class="text-sm font-medium text-neutral-700 mt-3 mb-1">Surat Lamaran:</p>
          <a href="#" class="text-sm text-primary-600 hover:underline">{{ app.surat }}</a>
        </div>

        <div class="flex gap-3">
          <button @click="showRejectModal(app)" class="btn-danger flex-1 text-sm">Tolak</button>
          <button @click="approveApp(app)" class="btn-primary flex-1 text-sm">Terima</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const activeTab = ref('pending')

const tabs = [
  { id: 'pending', label: 'Pending', count: 3 },
  { id: 'approved', label: 'Diterima', count: 4 },
  { id: 'rejected', label: 'Ditolak', count: 1 }
]

const apps = ref([
  { id: 1, nama: 'Rehan Alfarizi', nim: '23.11.5548', ipk: 3.75, semester: 6, lowongan: 'Frontend Developer', surat: 'surat_lamaran_rehan.pdf', status: 'pending', initials: 'RA' },
  { id: 2, nama: 'Nazal Syamaidzar', nim: '23.11.5547', ipk: 3.50, semester: 6, lowongan: 'Frontend Developer', surat: 'surat_lamaran_nazal.pdf', status: 'pending', initials: 'NS' }
])

const filteredApps = computed(() => {
  if (activeTab.value === 'pending') return apps.value.filter(a => a.status === 'pending')
  if (activeTab.value === 'approved') return apps.value.filter(a => a.status === 'approved')
  return apps.value.filter(a => a.status === 'rejected')
})

function getStatusBadge(status) {
  const classes = { pending: 'badge-pending', approved: 'badge-success', rejected: 'badge-danger' }
  return classes[status] || 'badge-info'
}

function approveApp(app) {
  console.log('Approve:', app.id)
}

function showRejectModal(app) {
  console.log('Reject:', app.id)
}
</script>