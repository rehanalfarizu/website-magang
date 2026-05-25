<template>
  <div class="dosen-view">
    <h2 class="text-2xl font-bold text-neutral-800 mb-6">Manajemen Dosen</h2>

    <div class="card overflow-hidden">
      <table class="w-full">
        <thead class="bg-neutral-50">
          <tr>
            <th class="px-4 py-3 text-left text-sm font-medium text-neutral-500">Dosen</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-neutral-500">NIDN</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-neutral-500">Email</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-neutral-500">Mahasiswa Bimbingan</th>
            <th class="px-4 py-3 text-right text-sm font-medium text-neutral-500">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-neutral-100">
          <tr v-for="dosen in dosens" :key="dosen.id" class="hover:bg-neutral-50">
            <td class="px-4 py-3 flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-secondary-100 flex items-center justify-center text-secondary-600 font-bold">
                {{ dosen.initials }}
              </div>
              <span class="font-medium text-neutral-800">{{ dosen.nama }}</span>
            </td>
            <td class="px-4 py-3 text-neutral-600">{{ dosen.nidn }}</td>
            <td class="px-4 py-3 text-neutral-600">{{ dosen.email }}</td>
            <td class="px-4 py-3 text-neutral-600">{{ dosen.mahasiswa }}</td>
            <td class="px-4 py-3 text-right">
              <button class="btn-sm btn-ghost">Edit</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const dosens = ref([
  { id: 1, nama: 'Bambang Pilu Hartato', nidn: '12345678', email: 'bambang@amikom.ac.id', mahasiswa: 12, initials: 'BH' },
  { id: 2, nama: 'Dr. Sri Wahyuni', nidn: '87654321', email: 'sri@amikom.ac.id', mahasiswa: 8, initials: 'SW' }
])
</script>