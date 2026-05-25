<template>
  <div class="placeholder-view">
    <div class="text-center py-12">
      <h2 class="text-2xl font-bold text-neutral-800 mb-2">{{ pageTitle }}</h2>
      <p class="text-neutral-500">Halaman dalam pengembangan</p>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

const pageTitle = computed(() => {
  const titles = {
    MahasiswaDashboard: 'Dashboard Mahasiswa',
    MahasiswaLowongan: 'Lowongan Magang',
    MahasiswaPendaftaran: 'Pendaftaran Saya',
    MahasiswaLogbook: 'Logbook',
    MahasiswaProgres: 'Progres Magang',
    MahasiswaProfile: 'Profil Saya',
    DosenDashboard: 'Dashboard Dosen',
    DosenMahasiswa: 'Mahasiswa Bimbingan',
    DosenLogbook: 'Review Logbook',
    DosenProfile: 'Profil Dosen',
    AdminDashboard: 'Dashboard Admin',
    AdminLowongan: 'Kelola Lowongan',
    AdminMahasiswa: 'Manajemen Mahasiswa',
    AdminDosen: 'Manajemen Dosen',
    AdminMitra: 'Manajemen Mitra',
    AdminProfile: 'Profil Admin',
    MitraDashboard: 'Dashboard Mitra',
    MitraLowongan: 'Lowongan Saya',
    MitraPendaftaran: 'Pendaftaran',
    MitraMahasiswa: 'Mahasiswa Magang',
    MitraProfile: 'Profil Mitra'
  }
  return titles[route.name] || 'Halaman'
})
</script>