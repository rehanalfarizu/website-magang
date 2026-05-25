<template>
  <div class="lowongan-view">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-neutral-800">Kelola Lowongan</h2>
      <button @click="showCreateModal = true" class="btn-primary">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Lowongan
      </button>
    </div>

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

    <!-- Table -->
    <div class="card overflow-hidden">
      <table class="w-full">
        <thead class="bg-neutral-50">
          <tr>
            <th class="px-4 py-3 text-left text-sm font-medium text-neutral-500">Posisi</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-neutral-500">Mitra</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-neutral-500">Kuota</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-neutral-500">Batas</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-neutral-500">Status</th>
            <th class="px-4 py-3 text-right text-sm font-medium text-neutral-500">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-neutral-100">
          <tr v-for="job in filteredJobs" :key="job.id" class="hover:bg-neutral-50">
            <td class="px-4 py-3">
              <p class="font-medium text-neutral-800">{{ job.position }}</p>
              <p class="text-sm text-neutral-500">{{ job.location }}</p>
            </td>
            <td class="px-4 py-3 text-neutral-600">{{ job.mitra }}</td>
            <td class="px-4 py-3 text-neutral-600">{{ job.quota }}</td>
            <td class="px-4 py-3 text-neutral-600">{{ job.deadline }}</td>
            <td class="px-4 py-3">
              <span :class="['badge', getStatusBadge(job.status)]">{{ getStatusLabel(job.status) }}</span>
            </td>
            <td class="px-4 py-3 text-right">
              <button class="btn-sm btn-ghost">Edit</button>
              <button class="btn-sm btn-ghost text-danger-500">Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const activeTab = ref('all')
const showCreateModal = ref(false)

const tabs = [
  { id: 'all', label: 'Semua', count: 18 },
  { id: 'published', label: 'Published', count: 12 },
  { id: 'pending', label: 'Menunggu Kurasi', count: 4 },
  { id: 'draft', label: 'Draft', count: 2 }
]

const jobs = ref([
  { id: 1, position: 'Frontend Developer', mitra: 'PT Teknologi Indonesia', location: 'Yogyakarta', quota: 3, deadline: '15 Juni 2026', status: 'published' },
  { id: 2, position: 'Backend Developer', mitra: 'Startup Hub', location: 'Jakarta', quota: 5, deadline: '20 Juni 2026', status: 'pending' }
])

const filteredJobs = computed(() => {
  if (activeTab.value === 'all') return jobs.value
  return jobs.value.filter(j => j.status === activeTab.value)
})

function getStatusBadge(status) {
  const classes = { published: 'badge-success', pending: 'badge-pending', draft: 'badge-info' }
  return classes[status] || 'badge-info'
}

function getStatusLabel(status) {
  const labels = { published: 'Published', pending: 'Menunggu', draft: 'Draft' }
  return labels[status] || status
}
</script>