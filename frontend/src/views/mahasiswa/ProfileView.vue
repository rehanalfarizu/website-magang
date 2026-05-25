<template>
  <div class="profile-view animate-fade-in">
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-gray-900">Profil Saya</h2>
      <p class="text-gray-500 text-sm mt-1">Kelola informasi akun Anda</p>
    </div>

    <!-- Profile Header -->
    <div class="card p-8 mb-6 text-center">
      <div class="inline-flex flex-col items-center">
        <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center text-3xl font-bold text-white shadow-glow mb-4">
          {{ userInitials }}
        </div>
        <h3 class="text-xl font-bold text-gray-900">{{ profile.nama }}</h3>
        <p class="text-gray-500">{{ profile.nim }}</p>
        <span class="badge badge-primary mt-3">Mahasiswa</span>
      </div>
    </div>

    <!-- Profile Form -->
    <div class="card p-6 mb-6">
      <h3 class="font-semibold text-gray-900 mb-5">Informasi Pribadi</h3>
      <form @submit.prevent="saveProfile" class="space-y-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <div>
            <label class="label">Nama Lengkap</label>
            <input v-model="profile.nama" type="text" class="input" />
          </div>
          <div>
            <label class="label">NIM</label>
            <input v-model="profile.nim" type="text" class="input bg-gray-50" disabled />
          </div>
        </div>

        <div>
          <label class="label">Email</label>
          <input v-model="profile.email" type="email" class="input" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <div>
            <label class="label">Semester</label>
            <input v-model="profile.semester" type="text" class="input bg-gray-50" disabled />
          </div>
          <div>
            <label class="label">IPK</label>
            <input v-model="profile.ipk" type="text" class="input bg-gray-50" disabled />
          </div>
        </div>

        <div>
          <label class="label">No. Telepon</label>
          <input v-model="profile.telepon" type="tel" class="input" placeholder="08xxxxxxxxxx" />
        </div>

        <div>
          <label class="label">Alamat</label>
          <textarea v-model="profile.alamat" rows="3" class="input resize-none"></textarea>
        </div>

        <div class="flex justify-end">
          <button type="submit" class="btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>

    <!-- Change Password -->
    <div class="card p-6">
      <h3 class="font-semibold text-gray-900 mb-5">Ubah Password</h3>
      <form @submit.prevent="changePassword" class="space-y-5">
        <div>
          <label class="label">Password Lama</label>
          <input v-model="password.oldPassword" type="password" class="input" />
        </div>
        <div>
          <label class="label">Password Baru</label>
          <input v-model="password.newPassword" type="password" class="input" />
        </div>
        <div>
          <label class="label">Konfirmasi Password Baru</label>
          <input v-model="password.confirmPassword" type="password" class="input" />
        </div>
        <div class="flex justify-end">
          <button type="submit" class="btn-outline">
            Ubah Password
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useAuthStore } from '@/stores/auth/auth'

const authStore = useAuthStore()

const userInitials = computed(() => {
  return authStore.userName.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2)
})

const profile = ref({
  nama: 'Muhammad Raihan Al Farizi',
  nim: '23.11.5548',
  email: 'rehan@students.amikom.ac.id',
  semester: '6',
  ipk: '3.75',
  telepon: '081234567890',
  alamat: 'Yogyakarta, Sleman'
})

const password = ref({
  oldPassword: '',
  newPassword: '',
  confirmPassword: ''
})

function saveProfile() {
  console.log('Save profile:', profile.value)
}

function changePassword() {
  if (password.value.newPassword !== password.value.confirmPassword) {
    alert('Password baru tidak cocok')
    return
  }
  console.log('Change password')
}
</script>

<style scoped>
.animate-fade-in {
  animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
</style>