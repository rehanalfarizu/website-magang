# Sistem Pendaftaran dan Monitoring Magang - AMIKOM

## Project Overview

Sistem informasi untuk mengelola pendaftaran dan monitoring magang mahasiswa Prodi Informatika AMIKOM Yogyakarta. Proyek ini menggantikan sistem berbasis Google Sheets yang tidak efisien.

**Konteks:**
- Tim: noName (Rehan, Nazal, Arul, Vendri, Zulfa)
- Dosen: Bambang Pilu Hartato, S.Kom., M.Eng.
- Tahun: 2026

**Masalah yang Diselesaikan:**
- Google Sheets-based system dengan script terpisah per fitur
- Tidak ada user testing sebelum rilis
- Monitoring manual (dosen menghubungi mahasiswa satu-satu)
- Situasi "saling tunggu" antara dosen dan mahasiswa
- Tidak ada real-time tracking progres magang

---

## User Roles & Features

### 4 Role Pengguna

| Role | Akses |
|------|-------|
| **Mahasiswa** | Mobile-first interface |
| **Dosen Pembimbing** | Desktop-first dashboard |
| **Admin Prodi** | Desktop-first dashboard |
| **Mitra Perusahaan** | Web interface |

### Fitur Utama

| ID | Fitur | Priority |
|----|-------|----------|
| PB-01 | Login multi-role dengan email kampus | High |
| PB-02 | Modul Informasi Lowongan (CRUD + kurasi) | High |
| PB-03 | Pendaftaran + Validasi IPK (min 3.0, semester min 5) | High |
| PB-04 | Logbook / Laporan Aktivitas Bulanan | High |
| PB-05 | Dashboard Real-time Admin Prodi | High |
| PB-06 | Dashboard Dosen Pembimbing | High |
| PB-07 | Review dan Approval Mitra | High |
| PB-09 | Modul Penolakan dengan Feedback | High |
| PB-10 | Notifikasi Status (termasuk "Dibaca") | Medium |
| PB-11 | Reminder Laporan Otomatis | Medium |
| PB-12 | Responsive Mobile-First Design | High |
| PB-13 | Pagination 20 baris/halaman | Medium |
| PB-14 | Pembatasan Upload (PDF/JPG/PNG) | High |
| PB-15 | Keamanan Login & Session Management | High |

### Future Development
- PB-08: Konversi SKS dan Pemetaan CPMK (nilai A-E)
- PB-17: User Testing Terstruktur (3 tahap beta testing)

---

## Data Models (Key Entities)

### User
- Email (domain kampus untuk Mahasiswa/Dosen)
- Password (hashed)
- Role (mahasiswa/dosen/admin/mitra)
- Profile data sesuai role

### Lowongan (Job Posting)
- Posisi, kuota, deskripsi task
- Batas pendaftaran
- Status: Draft → Menunggu Kurasi → Published / Ditolak
- Created by: Mitra atau Admin (atas nama mitra)

### Pendaftaran (Application)
- Status flow: Pending Prodi → Pending Mitra → Diterima / Ditolak
- IPK validation (min 3.0)
- Semester validation (min 5)
- Upload transkrip

### Logbook (Monthly Report)
- NIM, nama, deskripsi aktivitas
- Checklist tugas per bulan
- Upload bukti pekerjaan
- Status: Dikirim → Dibaca → Diterima / Perlu Revisi
- Feedback dari supervisor

### Progress Tracking
- Persentase berdasarkan laporan "Diterima"
- Durasi magang real-time
- CPMK mapping (future)

---

## Status Flows

### Pendaftaran Magang
```
Pending Prodi → Pending Mitra → Diterima / Ditolak Prodi / Ditolak Mitra
```

### Review Logbook
```
Dikirim → Dibaca → Diterima / Perlu Revisi → Dikirim (ulang) → ...
```

### Lowongan
```
Draft → Menunggu Kurasi → Published / Ditolak → Revisi → Menunggu Kurasi
```

---

## Technical Requirements

| Aspek | Spesifikasi |
|-------|-------------|
| Database | PostgreSQL (relasional) |
| API | REST API untuk 4 role |
| Frontend | Mobile-first (mahasiswa) / Desktop-first (admin/dosen) |
| Server Capacity | 1.5 TB |
| File Upload | PDF, JPG, PNG dengan size limit |
| Pagination | Max 20 baris per halaman |
| Session | Auto-expire after inactivity |
| Domain | Amikom domain untuk akses mahasiswa/dosen |

---

## Key User Stories Summary

### Mahasiswa (US-01 bis US-11)
- Lihat lowongan real-time + bookmark
- Validasi IPK + semester saat daftar
- Submit logbook bulanan dengan checklist task
- Lihat status + feedback review
- Dapat reminder laporan bulanan
- Lihat progres visual (% dan durasi)
- Lihat nama dosen pembimbing

### Admin Prodi (US-12 bis US-21)
- Dashboard: total mahasiswa aktif, sebaran perusahaan/dosen
- Kurasi lowongan + posting atas nama mitra
- Validasi IPK mahasiswa (cross-check transkrip)
- Tetapkan dosen pembimbing
- View-only: hasil review supervisor

### Mitra (US-22 bis US-27)
- Posting lowongan mandiri
- Approve/reject pendaftaran + alasan wajib
- Review logbook (mark as "Dibaca" + feedback)
- Lihat checklist task mahasiswa

### Dosen (US-28 bis US-33)
- Dashboard: mahasiswa bimbingan + progres
- Lihat checklist tugas per bulan
- Lihat status review logbook
- Notifikasi saat mahasiswa selesai magang
- Form penilaian CPMK (future)

---

## Notes for Development

- Sistem harus handle "saling tunggu" problem:
  - Supervisor harus bisa mark logbook sebagai "Dibaca" agar mahasiswa tahu review sedang berjalan
  - Notifikasi otomatis saat progres 100% agar dosen langsung kasih nilai
- Konversi SKS dan CPMK ditunda ke future (melibatkan logika akademik kompleks)
- User testing 3 tahap sebelum rilis final

---

## Team Roles

| Nama | NIM | Peran |
|------|-----|-------|
| Muhammad Raihan Al Farizi (Rehan) | 23.11.5548 | Product Owner |
| Nazal Syamaidzar Mahendra | 23.11.5547 | Scrum Master |
| Vendri Setyawan | 23.11.5523 | Developer (DB, REST API, Kalkulasi Progres) |
| Zulfa Meydita Rahma | 23.11.5512 | Developer (UI Mobile-first/Desktop) |
| Ahmad Natsrul Ulum (Arul) | 23.11.5524 | QA |