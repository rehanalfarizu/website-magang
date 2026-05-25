<template>
  <div class="logbook-view animate-fade-in">
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-gray-900">Logbook Magang</h2>
      <p class="text-gray-500 text-sm mt-1">Catat aktivitas dan progress magang Anda</p>
    </div>

    <!-- Current Month Card -->
    <div class="card p-6 mb-6">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h3 class="text-lg font-semibold text-gray-900">Logbook Juni 2026</h3>
          <p class="text-sm text-gray-500">Bulan ke-2 dari 6 bulan magang</p>
        </div>
        <span class="badge badge-warning">Belum Dikirim</span>
      </div>

      <form @submit.prevent="submitLogbook" class="space-y-6">
        <!-- Deskripsi Aktivitas -->
        <div>
          <label class="label">Deskripsi Aktivitas</label>
          <textarea
            v-model="logbook.deskripsi"
            rows="4"
            class="input resize-none"
            placeholder="Jelaskan aktivitas yang dilakukan selama magang..."
            required
          ></textarea>
        </div>

        <!-- Checklist Tasks -->
        <div>
          <label class="label">Tugas yang Dikerjakan</label>
          <div class="space-y-2">
            <label v-for="(task, index) in logbook.tasks" :key="index" class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl cursor-pointer hover:bg-gray-100 transition-colors">
              <div class="w-5 h-5 rounded border-2 flex items-center justify-center transition-colors" :class="task.completed ? 'bg-brand-500 border-brand-500' : 'border-gray-300'">
                <svg v-if="task.completed" class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <input type="checkbox" v-model="task.completed" class="sr-only" />
              <span :class="['flex-1', task.completed ? 'line-through text-gray-400' : 'text-gray-700']">{{ task.name }}</span>
            </label>
          </div>
        </div>

        <!-- File Upload -->
        <div>
          <label class="label">Bukti Pekerjaan <span class="text-gray-400">(opsional)</span></label>
          <div class="border-2 border-dashed border-gray-200 rounded-xl p-8 text-center hover:border-brand-300 hover:bg-gray-50 transition-colors cursor-pointer">
            <input type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png" />
            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16.6 7c-.11.4-.22.8-.22 1.3 0 .4.1.8.3 1.1a5.5 5.5 0 01-8.6 2.7l-.2-.2z" />
            </svg>
            <p class="text-sm text-gray-600 mb-1">Seret file ke sini atau klik untuk upload</p>
            <p class="text-xs text-gray-400">PDF, JPG, PNG (maks. 5MB)</p>
          </div>
        </div>

        <button type="submit" class="btn-primary w-full py-3.5">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9 2zm0 0v-8" />
          </svg>
          Kirim Logbook
        </button>
      </form>
    </div>

    <!-- Logbook History -->
    <div class="card">
      <div class="p-6 border-b border-gray-100">
        <h3 class="font-semibold text-gray-900">Riwayat Logbook</h3>
      </div>
      <div class="divide-y divide-gray-100">
        <div v-for="item in logbookHistory" :key="item.id" class="p-4 md:p-5 flex items-center justify-between hover:bg-gray-50 transition-colors">
          <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" :class="item.status === 'approved' ? 'bg-emerald-50' : 'bg-amber-50'">
              <svg v-if="item.status === 'approved'" class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <svg v-else class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div>
              <p class="font-medium text-gray-900">{{ item.bulan }}</p>
              <p class="text-sm text-gray-500">{{ item.tanggal }}</p>
            </div>
          </div>
          <span :class="['badge', item.status === 'approved' ? 'badge-success' : 'badge-warning']">
            {{ item.status === 'approved' ? 'Disetujui' : 'Menunggu' }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'

const logbook = reactive({
  deskripsi: '',
  tasks: [
    { name: 'Implementasi fitur login dengan OAuth', completed: true },
    { name: 'Code review dengan tim development', completed: true },
    { name: 'Fix bug pada halaman dashboard', completed: false },
    { name: 'Documentation API endpoint', completed: false }
  ]
})

const logbookHistory = ref([
  { id: 1, bulan: 'Mei 2026', tanggal: '28 Mei 2026', status: 'approved' },
  { id: 2, bulan: 'April 2026', tanggal: '28 April 2026', status: 'approved' }
])

function submitLogbook() {
  console.log('Submit logbook:', logbook)
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