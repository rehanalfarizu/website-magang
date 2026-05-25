<template>
  <div class="profile-view">
    <h2 class="text-2xl font-bold text-neutral-800 mb-6">Profil Admin</h2>

    <div class="card p-6">
      <form @submit.prevent="saveProfile" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="label">Nama Lengkap</label>
            <input v-model="profile.nama" type="text" class="input" />
          </div>
          <div>
            <label class="label">NIP</label>
            <input v-model="profile.nip" type="text" class="input" />
          </div>
        </div>
        <div>
          <label class="label">Email</label>
          <input v-model="profile.email" type="email" class="input" />
        </div>
        <div>
          <label class="label">No. Telepon</label>
          <input v-model="profile.telepon" type="tel" class="input" />
        </div>
        <button type="submit" class="btn-primary">Simpan Perubahan</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const profile = ref({
  nama: 'Administrator',
  nip: '123456789',
  email: 'admin@amikom.ac.id',
  telepon: '081234567890'
})

function saveProfile() {
  console.log('Save profile:', profile.value)
}
</script>