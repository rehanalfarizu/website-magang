<template>
  <div class="mitra-view">
    <h2 class="text-2xl font-bold text-neutral-800 mb-6">Manajemen Mitra</h2>

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

    <div class="card overflow-hidden">
      <table class="w-full">
        <thead class="bg-neutral-50">
          <tr>
            <th class="px-4 py-3 text-left text-sm font-medium text-neutral-500">Perusahaan</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-neutral-500">Kontak</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-neutral-500">Email</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-neutral-500">Status</th>
            <th class="px-4 py-3 text-right text-sm font-medium text-neutral-500">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-neutral-100">
          <tr v-for="mitra in filteredMitra" :key="mitra.id" class="hover:bg-neutral-50">
            <td class="px-4 py-3">
              <p class="font-medium text-neutral-800">{{ mitra.nama }}</p>
              <p class="text-sm text-neutral-500">{{ mitra.alamat }}</p>
            </td>
            <td class="px-4 py-3 text-neutral-600">{{ mitra.kontak }}</td>
            <td class="px-4 py-3 text-neutral-600">{{ mitra.email }}</td>
            <td class="px-4 py-3">
              <span :class="['badge', getStatusBadge(mitra.status)]">{{ mitra.status }}</span>
            </td>
            <td class="px-4 py-3 text-right">
              <button v-if="mitra.status === 'Pending'" class="btn-sm btn-primary">Approve</button>
              <button v-if="mitra.status === 'Pending'" class="btn-sm btn-ghost text-danger-500">Tolak</button>
              <button v-else class="btn-sm btn-ghost">Detail</button>
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

const tabs = [
  { id: 'all', label: 'Semua', count: 24 },
  { id: 'active', label: 'Aktif', count: 20 },
  { id: 'pending', label: 'Pending', count: 4 }
]

const mitras = ref([
  { id: 1, nama: 'PT Teknologi Indonesia', alamat: 'Yogyakarta', kontak: '081234567890', email: 'hr@titeknologi.id', status: 'Active' },
  { id: 2, nama: 'Startup Hub Indonesia', alamat: 'Jakarta', kontak: '081234567891', email: 'info@startuphub.id', status: 'Pending' }
])

const filteredMitra = computed(() => {
  if (activeTab.value === 'all') return mitras.value
  return mitras.value.filter(m => m.status === activeTab.value)
})

function getStatusBadge(status) {
  return status === 'Active' ? 'badge-success' : 'badge-pending'
}
</script>