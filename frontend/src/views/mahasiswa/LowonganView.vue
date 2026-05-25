<template>
  <div class="lowongan-view animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
      <div>
        <h2 class="text-2xl font-bold text-gray-900">Lowongan Magang</h2>
        <p class="text-gray-500 text-sm mt-1">Temukan kesempatan magang yang sesuai</p>
      </div>
      <button class="btn-ghost p-2 rounded-xl border border-gray-200">
        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.707.293l-4.414 4.414a1 1 0 00-.707.293V19a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z" />
        </svg>
      </button>
    </div>

    <!-- Search Bar -->
    <div class="card p-1 mb-6">
      <div class="flex items-center gap-3 px-4">
        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input v-model="searchQuery" type="text" placeholder="Cari posisi atau perusahaan..." class="input border-0 p-0 focus:ring-0 bg-transparent" />
      </div>
    </div>

    <!-- Filter Chips -->
    <div class="flex gap-2 overflow-x-auto pb-4 hide-scrollbar -mx-4 px-4 md:mx-0 md:px-0">
      <button
        v-for="filter in filters"
        :key="filter.id"
        @click="activeFilter = filter.id"
        :class="[
          'chip-clickable',
          activeFilter === filter.id ? 'chip-active' : ''
        ]"
      >
        {{ filter.label }}
      </button>
    </div>

    <!-- Job Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
      <div v-for="(job, index) in filteredJobs" :key="job.id" class="card-interactive p-5 animate-fade-in-up" :style="{ animationDelay: `${index * 50}ms` }">
        <div class="flex gap-4">
          <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center flex-shrink-0">
            <span class="text-xl font-bold text-gray-400">{{ job.company.charAt(0) }}</span>
          </div>
          <div class="flex-1 min-w-0">
            <h3 class="font-semibold text-gray-900 text-lg">{{ job.position }}</h3>
            <p class="text-sm text-gray-500">{{ job.company }}</p>
            <div class="flex flex-wrap gap-2 mt-3">
              <span class="chip">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ job.location }}
              </span>
              <span class="chip">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                {{ job.quota }} posisi
              </span>
            </div>
          </div>
        </div>

        <div class="mt-5 pt-4 border-t border-gray-100">
          <div class="flex items-center justify-between">
            <span class="text-xs text-gray-400">
              <svg class="w-3.5 h-3.5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              Batas: {{ job.deadline }}
            </span>
            <div class="flex gap-2">
              <button @click="toggleBookmark(job)" :class="['btn-ghost p-2 rounded-lg', job.bookmarked ? 'text-amber-500' : '']">
                <svg class="w-5 h-5" :fill="job.bookmarked ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                </svg>
              </button>
              <button @click="viewDetail(job)" class="btn-primary text-sm px-4">
                Lihat Detail
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-if="filteredJobs.length === 0" class="empty-state">
      <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
      </svg>
      <p class="empty-state-title">Tidak ada lowongan ditemukan</p>
      <p class="empty-state-description">Coba ubah kata kunci pencarian atau filter</p>
    </div>

    <!-- Job Detail Modal -->
    <Teleport to="body">
      <Transition name="fade">
        <div v-if="selectedJob" class="modal-overlay" @click.self="selectedJob = null">
          <div class="modal animate-fade-in-up">
            <div class="modal-header">
              <h3 class="text-xl font-bold text-gray-900">{{ selectedJob.position }}</h3>
              <button @click="selectedJob = null" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
            <div class="modal-body">
              <p class="text-gray-600 mb-6">{{ selectedJob.description }}</p>
              <div class="space-y-4">
                <div class="flex items-center gap-3">
                  <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                  </svg>
                  <span class="text-gray-700">{{ selectedJob.company }}</span>
                </div>
                <div class="flex items-center gap-3">
                  <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  </svg>
                  <span class="text-gray-700">{{ selectedJob.location }}</span>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button @click="selectedJob = null" class="btn-ghost">Tutup</button>
              <button @click="applyJob(selectedJob)" class="btn-primary">Daftar Sekarang</button>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const searchQuery = ref('')
const activeFilter = ref('all')
const selectedJob = ref(null)

const filters = [
  { id: 'all', label: 'Semua' },
  { id: 'tech', label: 'IT & Tech' },
  { id: 'design', label: 'Design' },
  { id: 'marketing', label: 'Marketing' },
  { id: 'finance', label: 'Finance' }
]

const jobs = ref([
  {
    id: 1,
    position: 'Frontend Developer Intern',
    company: 'PT Teknologi Indonesia',
    location: 'Yogyakarta',
    quota: 3,
    deadline: '15 Juni 2026',
    bookmarked: false,
    type: 'tech',
    description: 'Membantu pengembangan fitur frontend aplikasi web menggunakan Vue.js dan Tailwind CSS.'
  },
  {
    id: 2,
    position: 'UI/UX Designer Intern',
    company: 'CV Creative Studio',
    location: 'Remote',
    quota: 2,
    deadline: '20 Juni 2026',
    bookmarked: true,
    type: 'design',
    description: 'Membantu desain antarmuka dan pengalaman pengguna untuk berbagai proyek digital.'
  },
  {
    id: 3,
    position: 'Backend Developer',
    company: 'Startup Hub Indonesia',
    location: 'Jakarta',
    quota: 5,
    deadline: '30 Juni 2026',
    bookmarked: false,
    type: 'tech',
    description: 'Mengembangkan API dan database menggunakan Node.js dan PostgreSQL.'
  },
  {
    id: 4,
    position: 'Digital Marketing',
    company: 'PT Digital Solusi',
    location: 'Bandung',
    quota: 2,
    deadline: '25 Juni 2026',
    bookmarked: false,
    type: 'marketing',
    description: 'Membantu strategi marketing digital dan pengelolaan media sosial.'
  }
])

const filteredJobs = computed(() => {
  let result = jobs.value

  if (activeFilter.value !== 'all') {
    result = result.filter(job => job.type === activeFilter.value)
  }

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    result = result.filter(job =>
      job.position.toLowerCase().includes(query) ||
      job.company.toLowerCase().includes(query)
    )
  }

  return result
})

function viewDetail(job) {
  selectedJob.value = job
}

function toggleBookmark(job) {
  job.bookmarked = !job.bookmarked
}

function applyJob(job) {
  console.log('Apply to:', job.position)
  selectedJob.value = null
}
</script>

<style scoped>
.animate-fade-in {
  animation: fadeIn 0.3s ease-out;
}

.animate-fade-in-up {
  animation: fadeInUp 0.4s ease-out;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>