<template>
  <div class="mahasiswa-view">
    <h2 class="text-2xl font-bold text-neutral-800 mb-6">Mahasiswa Bimbingan</h2>

    <!-- Search -->
    <div class="card p-3 mb-6">
      <div class="flex items-center gap-3">
        <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input v-model="searchQuery" type="text" placeholder="Cari nama mahasiswa..." class="input border-0 p-0 focus:ring-0" />
      </div>
    </div>

    <!-- Student Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="mhs in filteredMahasiswa" :key="mhs.id" class="card p-4">
        <div class="flex items-start gap-4">
          <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold flex-shrink-0">
            {{ mhs.initials }}
          </div>
          <div class="flex-1 min-w-0">
            <h3 class="font-semibold text-neutral-800">{{ mhs.nama }}</h3>
            <p class="text-sm text-neutral-500">{{ mhs.nim }}</p>
            <p class="text-sm text-neutral-500">{{ mhs.perusahaan }}</p>
          </div>
        </div>
        <div class="mt-4 pt-4 border-t border-neutral-100">
          <div class="flex justify-between mb-2">
            <span class="text-sm text-neutral-500">Progres</span>
            <span class="text-sm font-medium text-neutral-800">{{ mhs.progres }}%</span>
          </div>
          <div class="w-full bg-neutral-100 rounded-full h-2">
            <div class="bg-primary-500 h-2 rounded-full" :style="{ width: mhs.progres + '%' }"></div>
          </div>
        </div>
        <router-link :to="{ name: 'DosenMahasiswaDetail', params: { id: mhs.id } }" class="btn-outline w-full mt-4 text-sm">
          Lihat Detail
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const searchQuery = ref('')

const mahasiswa = ref([
  { id: 1, nama: 'Ahmad Natsrul Ulum', nim: '23.11.5524', perusahaan: 'PT Teknologi Indonesia', progres: 50 },
  { id: 2, nama: 'Nazal Syamaidzar M', nim: '23.11.5547', perusahaan: 'Startup Hub Indonesia', progres: 33 },
  { id: 3, nama: 'Zulfa Meydita Rahma', nim: '23.11.5512', perusahaan: 'CV Creative Studio', progres: 83 },
  { id: 4, nama: 'Vendri Setyawan', nim: '23.11.5523', perusahaan: 'PT Digital Solusi', progres: 67 }
])

const filteredMahasiswa = computed(() => {
  if (!searchQuery.value) return mahasiswa.value
  const query = searchQuery.value.toLowerCase()
  return mahasiswa.value.filter(m =>
    m.nama.toLowerCase().includes(query) ||
    m.nim.includes(query)
  )
})
</script>