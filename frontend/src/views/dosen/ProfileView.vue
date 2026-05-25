<template>
  <div class="profile-view">
    <h2 class="text-2xl font-bold text-neutral-800 mb-6">Profil Dosen</h2>

    <div class="card p-6">
      <div class="flex flex-col md:flex-row gap-6">
        <div class="flex flex-col items-center">
          <div class="w-32 h-32 rounded-full bg-secondary-100 flex items-center justify-center text-4xl font-bold text-secondary-600 mb-4">
            {{ userInitials }}
          </div>
        </div>
        <div class="flex-1">
          <form @submit.prevent="saveProfile" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="label">Nama Lengkap</label>
                <input v-model="profile.nama" type="text" class="input" />
              </div>
              <div>
                <label class="label">NIDN</label>
                <input v-model="profile.nidn" type="text" class="input" />
              </div>
            </div>
            <div>
              <label class="label">Email</label>
              <input v-model="profile.email" type="email" class="input" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="label">No. Telepon</label>
                <input v-model="profile.telepon" type="tel" class="input" />
              </div>
              <div>
                <label class="label">Keahlian</label>
                <input v-model="profile.keahlian" type="text" class="input" />
              </div>
            </div>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
          </form>
        </div>
      </div>
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
  nama: 'Bambang Pilu Hartato',
  nidn: '12345678',
  email: 'bambang@amikom.ac.id',
  telepon: '081234567890',
  keahlian: 'Software Engineering, Web Development'
})

function saveProfile() {
  console.log('Save profile:', profile.value)
}
</script>