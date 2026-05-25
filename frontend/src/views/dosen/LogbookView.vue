<template>
  <div class="logbook-view">
    <h2 class="text-2xl font-bold text-neutral-800 mb-6">Review Logbook</h2>

    <!-- Filter Tabs -->
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

    <!-- Logbook List -->
    <div class="space-y-4">
      <div v-for="logbook in filteredLogbooks" :key="logbook.id" class="card p-4">
        <div class="flex items-center justify-between mb-4">
          <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold">
              {{ logbook.initials }}
            </div>
            <div>
              <p class="font-semibold text-neutral-800">{{ logbook.nama }}</p>
              <p class="text-sm text-neutral-500">{{ logbook.nim }}</p>
            </div>
          </div>
          <span :class="['badge', getStatusBadge(logbook.status)]">{{ logbook.status }}</span>
        </div>

        <div class="bg-neutral-50 rounded-lg p-4 mb-4">
          <p class="text-sm font-medium text-neutral-700 mb-2">Bulan: {{ logbook.bulan }}</p>
          <p class="text-sm text-neutral-600 mb-3">{{ logbook.deskripsi }}</p>
          <div class="space-y-2">
            <label v-for="(task, idx) in logbook.tasks" :key="idx" class="flex items-center gap-2">
              <span class="w-4 h-4 rounded border border-neutral-300 flex items-center justify-center">
                <svg v-if="task.completed" class="w-3 h-3 text-success-500" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
              </span>
              <span :class="['text-sm', task.completed ? 'text-neutral-500 line-through' : 'text-neutral-700']">{{ task.name }}</span>
            </label>
          </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-3">
          <button @click="markAsRead(logbook)" class="btn-outline flex-1 text-sm">Tandai Dibaca</button>
          <button @click="showApproveModal(logbook)" class="btn-primary flex-1 text-sm">Setujui</button>
          <button @click="showRevisionModal(logbook)" class="btn-danger flex-1 text-sm">Minta Revisi</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const activeTab = ref('pending')

const tabs = [
  { id: 'pending', label: 'Menunggu', count: 4 },
  { id: 'reviewed', label: 'Sudah Direview', count: 8 }
]

const logbooks = ref([
  {
    id: 1,
    nama: 'Ahmad Natsrul Ulum',
    nim: '23.11.5524',
    initials: 'AN',
    bulan: 'Juni 2026',
    status: 'pending',
    deskripsi: 'Melakukan pengembangan fitur login dengan OAuth integration dan bug fixing pada dashboard admin.',
    tasks: [
      { name: 'Implementasi OAuth login', completed: true },
      { name: 'Fix bug dashboard', completed: true },
      { name: 'Code review', completed: true },
      { name: 'Unit testing', completed: false }
    ]
  }
])

const filteredLogbooks = computed(() => {
  return logbooks.value.filter(l => activeTab.value === 'pending' ? l.status === 'pending' : l.status !== 'pending')
})

function getStatusBadge(status) {
  return status === 'pending' ? 'badge-pending' : 'badge-success'
}

function markAsRead(logbook) {
  console.log('Mark as read:', logbook.id)
}

function showApproveModal(logbook) {
  console.log('Approve:', logbook.id)
}

function showRevisionModal(logbook) {
  console.log('Request revision:', logbook.id)
}
</script>