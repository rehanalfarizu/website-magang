<template>
  <div class="mahasiswa-view">
    <h2 class="text-2xl font-bold text-neutral-800 mb-6">Manajemen Mahasiswa</h2>

    <!-- Search & Filter -->
    <div class="card p-3 mb-6">
      <div class="flex items-center gap-3">
        <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input v-model="searchQuery" type="text" placeholder="Cari nama atau NIM..." class="input border-0 p-0 focus:ring-0" />
      </div>
    </div>

    <!-- Table -->
    <div class="card overflow-hidden">
      <table class="w-full">
        <thead class="bg-neutral-50">
          <tr>
            <th class="px-4 py-3 text-left text-sm font-medium text-neutral-500">Mahasiswa</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-neutral-500">Semester</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-neutral-500">IPK</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-neutral-500">Status</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-neutral-500">Mitra</th>
            <th class="px-4 py-3 text-right text-sm font-medium text-neutral-500">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-neutral-100">
          <tr v-for="mhs in filteredMahasiswa" :key="mhs.id" class="hover:bg-neutral-50">
            <td class="px-4 py-3">
              <p class="font-medium text-neutral-800">{{ mhs.nama }}</p>
              <p class="text-sm text-neutral-500">{{ mhs.nim }}</p>
            </td>
            <td class="px-4 py-3 text-neutral-600">{{ mhs.semester }}</td>
            <td class="px-4 py-3 text-neutral-600">{{ mhs.ipk }}</td>
            <td class="px-4 py-3">
              <span :class="['badge', getStatusBadge(mhs.status)]">{{ mhs.status }}</span>
            </td>
            <td class="px-4 py-3 text-neutral-600">{{ mhs.mitra || '-' }}</td>
            <td class="px-4 py-3 text-right">
              <button class="btn-sm btn-ghost">Detail</button>
              <button class="btn-sm btn-ghost text-primary-600">Dosen</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const searchQuery = ref('')

const mahasiswa = ref([
  { id: 1, nama: 'Ahmad Natsrul Ulum', nim: '23.11.5524', semester: 6, ipk: 3.75, status: 'Aktif', mitra: 'PT Teknologi Indonesia' },
  { id: 2, nama: 'Nazal Syamaidzar', nim: '23.11.5547', semester: 6, ipk: 3.50, status: 'Aktif', mitra: 'Startup Hub' }
])

const filteredMahasiswa = computed(() => {
  if (!searchQuery.value) return mahasiswa.value
  const q = searchQuery.value.toLowerCase()
  return mahasiswa.value.filter(m => m.nama.toLowerCase().includes(q) || m.nim.includes(q))
})

function getStatusBadge(status) {
  return status === 'Aktif' ? 'badge-success' : 'badge-info'
}
</script>