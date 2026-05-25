<template>
  <div class="lowongan-view">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-neutral-800">Lowongan Saya</h2>
      <button @click="showCreateModal = true" class="btn-primary">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Buat Lowongan
      </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <div v-for="job in lowongans" :key="job.id" class="card p-4">
        <div class="flex justify-between items-start mb-4">
          <div>
            <h3 class="font-semibold text-neutral-800">{{ job.position }}</h3>
            <p class="text-sm text-neutral-500">{{ job.location }}</p>
          </div>
          <span :class="['badge', getStatusBadge(job.status)]">{{ job.status }}</span>
        </div>
        <p class="text-sm text-neutral-600 mb-4">{{ job.description }}</p>
        <div class="flex justify-between text-sm text-neutral-500 mb-4">
          <span>Kuota: {{ job.quota }}</span>
          <span>Batas: {{ job.deadline }}</span>
        </div>
        <div class="flex gap-2">
          <button class="btn-outline flex-1 text-sm">Edit</button>
          <button class="btn-ghost text-sm">Pendaftar ({{ job.applicants }})</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const showCreateModal = ref(false)

const lowongans = ref([
  { id: 1, position: 'Frontend Developer', location: 'Yogyakarta', description: 'Mengembangkan fitur frontend aplikasi web perusahaan', quota: 2, deadline: '15 Juni 2026', applicants: 5, status: 'Published' },
  { id: 2, position: 'Backend Developer', location: 'Remote', description: 'Membuat API dan database management', quota: 3, deadline: '20 Juni 2026', applicants: 3, status: 'Published' }
])

function getStatusBadge(status) {
  return status === 'Published' ? 'badge-success' : 'badge-info'
}
</script>