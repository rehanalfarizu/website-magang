<template>
  <div class="mahasiswa-view">
    <h2 class="text-2xl font-bold text-neutral-800 mb-6">Mahasiswa Magang</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="mhs in mahasiswas" :key="mhs.id" class="card p-4">
        <div class="flex items-center gap-4 mb-4">
          <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold flex-shrink-0">
            {{ mhs.initials }}
          </div>
          <div>
            <h3 class="font-semibold text-neutral-800">{{ mhs.nama }}</h3>
            <p class="text-sm text-neutral-500">{{ mhs.nim }}</p>
          </div>
        </div>

        <div class="mb-4">
          <div class="flex justify-between mb-1">
            <span class="text-sm text-neutral-500">Progres</span>
            <span class="text-sm font-medium text-neutral-800">{{ mhs.progres }}%</span>
          </div>
          <div class="w-full bg-neutral-100 rounded-full h-2">
            <div class="bg-primary-500 h-2 rounded-full" :style="{ width: mhs.progres + '%' }"></div>
          </div>
        </div>

        <div class="text-sm text-neutral-500 mb-4">
          <p>Bulan ke-{{ mhs.bulan }} dari {{ mhs.totalBulan }}</p>
          <p>Mulai: {{ mhs.startDate }}</p>
        </div>

        <button @click="viewLogbook(mhs)" class="btn-outline w-full text-sm">Lihat Logbook</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const mahasiswas = ref([
  { id: 1, nama: 'Rehan Alfarizi', nim: '23.11.5548', progres: 33, bulan: 2, totalBulan: 6, startDate: 'April 2026', initials: 'RA' },
  { id: 2, nama: 'Nazal Syamaidzar', nim: '23.11.5547', progres: 50, bulan: 3, totalBulan: 6, startDate: 'April 2026', initials: 'NS' }
])

function viewLogbook(mhs) {
  console.log('View logbook:', mhs.id)
}
</script>