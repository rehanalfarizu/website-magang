<template>
  <div class="auth-page min-h-screen flex">
    <!-- Left Panel - Branding (Desktop) -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-brand-600 via-brand-700 to-brand-800 relative overflow-hidden">
      <!-- Background Pattern -->
      <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
          <defs>
            <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
              <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
            </pattern>
          </defs>
          <rect width="100" height="100" fill="url(#grid)" />
        </svg>
      </div>

      <!-- Floating Elements -->
      <div class="absolute top-20 left-20 w-72 h-72 bg-white/10 rounded-full blur-3xl animate-pulse-soft"></div>
      <div class="absolute bottom-20 right-20 w-96 h-96 bg-brand-400/20 rounded-full blur-3xl animate-pulse-soft delay-200"></div>

      <!-- Content -->
      <div class="relative z-10 flex flex-col justify-center px-16 py-12">
        <div class="mb-8">
          <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-large mb-6">
            <span class="text-3xl font-bold text-brand-600">A</span>
          </div>
          <h1 class="text-5xl font-bold text-white mb-4 leading-tight">
            Sistem Magang<br />AMIKOM
          </h1>
          <p class="text-xl text-brand-100 leading-relaxed">
            Platform Terintegrasi untuk Pendaftaran dan Monitoring Magang Mahasiswa Prodi Informatika
          </p>
        </div>

        <div class="space-y-6">
          <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div>
              <p class="text-white font-medium">Validasi IPK Otomatis</p>
              <p class="text-brand-200 text-sm">Pastikan memenuhi persyaratan</p>
            </div>
          </div>

          <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div>
              <p class="text-white font-medium">Real-time Progress</p>
              <p class="text-brand-200 text-sm">Pantau progres magang Anda</p>
            </div>
          </div>

          <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
              </svg>
            </div>
            <div>
              <p class="text-white font-medium">Notifikasi Instan</p>
              <p class="text-brand-200 text-sm">Dapatkan update terbaru</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Panel - Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12">
      <div class="w-full max-w-md">
        <!-- Mobile Logo -->
        <div class="lg:hidden text-center mb-8">
          <div class="w-14 h-14 bg-brand-600 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-glow">
            <span class="text-2xl font-bold text-white">A</span>
          </div>
          <h1 class="text-2xl font-bold text-gray-900">Sistem Magang AMIKOM</h1>
        </div>

        <!-- Form Card -->
        <div class="card p-8 shadow-medium">
          <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Masuk ke Akun Anda</h2>
            <p class="text-gray-500">Gunakan email kampus untuk mengakses sistem</p>
          </div>

          <form @submit.prevent="handleLogin" class="space-y-5">
            <!-- Email -->
            <div>
              <label for="email" class="label">Alamat Email</label>
              <div class="relative">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                </div>
                <input
                  id="email"
                  v-model="email"
                  type="email"
                  class="input pl-12"
                  placeholder="nama@students.amikom.ac.id"
                  required
                  autocomplete="email"
                />
              </div>
            </div>

            <!-- Password -->
            <div>
              <label for="password" class="label">Password</label>
              <div class="relative">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                  </svg>
                </div>
                <input
                  id="password"
                  v-model="password"
                  :type="showPassword ? 'text' : 'password'"
                  class="input pl-12 pr-12"
                  placeholder="Masukkan password"
                  required
                  autocomplete="current-password"
                />
                <button
                  type="button"
                  @click="showPassword = !showPassword"
                  class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                >
                  <svg v-if="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                  </svg>
                  <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </button>
              </div>
            </div>

            <!-- Error Message -->
            <div v-if="error" class="p-4 bg-red-50 border border-red-100 rounded-lg flex items-start gap-3 animate-fade-in">
              <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <p class="text-sm text-red-600">{{ error }}</p>
            </div>

            <!-- Submit Button -->
            <button
              type="submit"
              :disabled="loading"
              class="btn-primary w-full py-3.5 text-base font-semibold shadow-md hover:shadow-lg"
            >
              <span v-if="loading" class="spinner w-5 h-5"></span>
              <span v-if="loading">Memproses...</span>
              <span v-else class="flex items-center justify-center gap-2">
                Masuk
                <svg v-if="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </span>
            </button>
          </form>

          <!-- Demo Accounts -->
          <div class="mt-8 pt-6 border-t border-gray-200">
            <p class="text-xs text-center text-gray-400 mb-4">Demo Account (password apapun)</p>
            <div class="grid grid-cols-2 gap-2">
              <button
                v-for="demo in demoAccounts"
                :key="demo.email"
                @click="quickLogin(demo.email)"
                class="chip-clickable justify-center text-xs"
              >
                {{ demo.label }}
              </button>
            </div>
          </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-400 mt-6">
          Tim noName &copy; 2026 &bull; AMIKOM Yogyakarta
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth/auth'

const router = useRouter()
const route = useRoute()
const authStore = useAuthStore()

const email = ref('')
const password = ref('')
const showPassword = ref(false)
const loading = computed(() => authStore.loading)
const error = computed(() => authStore.error)

const demoAccounts = [
  { email: 'mahasiswa@students.amikom.ac.id', label: 'Mahasiswa' },
  { email: 'dosen@amikom.ac.id', label: 'Dosen' },
  { email: 'admin@amikom.ac.id', label: 'Admin' },
  { email: 'mitra@company.co.id', label: 'Mitra' }
]

function quickLogin(demoEmail) {
  email.value = demoEmail
  password.value = 'demo'
  handleLogin()
}

async function handleLogin() {
  const result = await authStore.login(email.value, password.value)

  if (result.success) {
    const redirect = route.query.redirect || authStore.defaultRoute
    router.push({ name: redirect })
  }
}
</script>

<style scoped>
.auth-page {
  min-height: 100vh;
}

@media (max-width: 1024px) {
  .auth-page {
    background: linear-gradient(180deg, #eff6ff 0%, #fafafa 50%, #f5f5f5 100%);
  }
}
</style>