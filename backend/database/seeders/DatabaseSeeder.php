<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\AdminProdi;
use App\Models\Mitra;
use App\Models\Lowongan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ──────────────────────────────────────────────
        $adminUser = User::create([
            'email'         => 'admin@amikom.ac.id',
            'password_hash' => Hash::make('password123'),
            'role'          => 'admin',
        ]);
        AdminProdi::create([
            'user_id' => $adminUser->id,
            'nama'    => 'Admin Prodi Informatika',
        ]);

        // ── Dosen ─────────────────────────────────────────────
        $dosenUser = User::create([
            'email'         => 'dosen@amikom.ac.id',
            'password_hash' => Hash::make('password123'),
            'role'          => 'dosen',
        ]);
        Dosen::create([
            'user_id'    => $dosenUser->id,
            'nidn'       => '0012018901',
            'nama'       => 'Dr. Budi Santoso, M.Kom',
            'email'      => 'dosen@amikom.ac.id',
            'no_telepon' => '081234567891',
        ]);

        $dosenUser2 = User::create([
            'email'         => 'dosen2@amikom.ac.id',
            'password_hash' => Hash::make('password123'),
            'role'          => 'dosen',
        ]);
        Dosen::create([
            'user_id'    => $dosenUser2->id,
            'nidn'       => '0025019202',
            'nama'       => 'Siti Rahayu, S.Kom, M.T',
            'email'      => 'dosen2@amikom.ac.id',
            'no_telepon' => '081234567892',
        ]);

        // ── Mahasiswa ────────────────────────────────────────
        $mhsUser = User::create([
            'email'         => 'mahasiswa@students.amikom.ac.id',
            'password_hash' => Hash::make('password123'),
            'role'          => 'mahasiswa',
        ]);
        Mahasiswa::create([
            'user_id'     => $mhsUser->id,
            'nim'         => '22.11.4500',
            'nama'        => 'Andi Pratama',
            'ipk'         => 3.75,
            'semester'    => 6,
            'no_telepon'  => '081234567890',
            'status_magang' => 'belum_magang',
        ]);

        $mhsUser2 = User::create([
            'email'         => 'mahasiswa2@students.amikom.ac.id',
            'password_hash' => Hash::make('password123'),
            'role'          => 'mahasiswa',
        ]);
        Mahasiswa::create([
            'user_id'     => $mhsUser2->id,
            'nim'         => '22.11.4501',
            'nama'        => 'Dewi Kartika',
            'ipk'         => 3.50,
            'semester'    => 7,
            'no_telepon'  => '081234567893',
            'status_magang' => 'belum_magang',
        ]);

        // ── Mitra ────────────────────────────────────────────
        $mitraUser1 = User::create([
            'email'         => 'hrd@techcorp.com',
            'password_hash' => Hash::make('password123'),
            'role'          => 'mitra',
        ]);
        $mitra1 = Mitra::create([
            'user_id'         => $mitraUser1->id,
            'nama_perusahaan' => 'PT TechCorp Indonesia',
            'alamat'          => 'Jl. Sudirman No. 100, Jakarta Selatan',
            'pic_nama'        => 'Rizky Firmansyah',
            'pic_email'       => 'hrd@techcorp.com',
            'pic_telepon'     => '021-1234567',
            'status'          => 'approved',
        ]);

        $mitraUser2 = User::create([
            'email'         => 'rekrutmen@digitalagency.co.id',
            'password_hash' => Hash::make('password123'),
            'role'          => 'mitra',
        ]);
        $mitra2 = Mitra::create([
            'user_id'         => $mitraUser2->id,
            'nama_perusahaan' => 'CV Digital Agency Yogyakarta',
            'alamat'          => 'Jl. Malioboro No. 45, Yogyakarta',
            'pic_nama'        => 'Maya Sari',
            'pic_email'       => 'rekrutmen@digitalagency.co.id',
            'pic_telepon'     => '0274-123456',
            'status'          => 'approved',
        ]);

        $mitraUser3 = User::create([
            'email'         => 'intern@startup.id',
            'password_hash' => Hash::make('password123'),
            'role'          => 'mitra',
        ]);
        $mitra3 = Mitra::create([
            'user_id'         => $mitraUser3->id,
            'nama_perusahaan' => 'StartupID',
            'alamat'          => 'Jl. Seturan Raya No. 12, Sleman',
            'pic_nama'        => 'Bima Nugraha',
            'pic_email'       => 'intern@startup.id',
            'pic_telepon'     => '085234567890',
            'status'          => 'pending',
        ]);

        // ── Lowongan ─────────────────────────────────────────
        Lowongan::create([
            'mitra_id'        => $mitra1->id,
            'posisi'          => 'Frontend Developer Intern',
            'kuota'           => 3,
            'deskripsi_task'  => 'Membantu pengembangan UI menggunakan Vue.js dan React. Berkolaborasi dengan tim backend untuk integrasi API.',
            'requirements'    => 'Menguasai HTML, CSS, JavaScript. Familiar dengan Vue.js atau React. IPK minimal 3.0.',
            'lokasi'          => 'Jakarta Selatan (WFO)',
            'batas_daftar'    => now()->addMonth()->toDateString(),
            'status'          => 'published',
            'created_by'      => $mitraUser1->id,
        ]);

        Lowongan::create([
            'mitra_id'        => $mitra1->id,
            'posisi'          => 'Backend Developer Intern',
            'kuota'           => 2,
            'deskripsi_task'  => 'Pengembangan REST API menggunakan Laravel. Mengelola database PostgreSQL dan optimasi query.',
            'requirements'    => 'Menguasai PHP dan Laravel. Memahami konsep RESTful API. Familiar dengan SQL.',
            'lokasi'          => 'Jakarta Selatan / Remote',
            'batas_daftar'    => now()->addMonth()->toDateString(),
            'status'          => 'published',
            'created_by'      => $mitraUser1->id,
        ]);

        Lowongan::create([
            'mitra_id'        => $mitra2->id,
            'posisi'          => 'UI/UX Designer Intern',
            'kuota'           => 2,
            'deskripsi_task'  => 'Merancang wireframe, mockup, dan prototype untuk aplikasi web dan mobile. Melakukan user research.',
            'requirements'    => 'Menguasai Figma atau Adobe XD. Memahami prinsip UX design. Portfolio desain menjadi nilai plus.',
            'lokasi'          => 'Yogyakarta (WFO)',
            'batas_daftar'    => now()->addWeeks(3)->toDateString(),
            'status'          => 'published',
            'created_by'      => $mitraUser2->id,
        ]);

        Lowongan::create([
            'mitra_id'        => $mitra2->id,
            'posisi'          => 'Digital Marketing Intern',
            'kuota'           => 1,
            'deskripsi_task'  => 'Mengelola media sosial perusahaan. Membuat konten kreatif dan menjalankan kampanye iklan digital.',
            'requirements'    => 'Memahami SEO, SEM, dan Social Media Marketing. Kemampuan copywriting yang baik.',
            'lokasi'          => 'Yogyakarta (Remote)',
            'batas_daftar'    => now()->addWeeks(2)->toDateString(),
            'status'          => 'published',
            'created_by'      => $mitraUser2->id,
        ]);

        Lowongan::create([
            'mitra_id'        => $mitra3->id,
            'posisi'          => 'Mobile Developer Intern (Flutter)',
            'kuota'           => 2,
            'deskripsi_task'  => 'Mengembangkan aplikasi mobile cross-platform menggunakan Flutter. Integrasi dengan REST API.',
            'requirements'    => 'Menguasai Dart dan Flutter. Memahami state management (Provider/Riverpod/Bloc).',
            'lokasi'          => 'Sleman (WFO)',
            'batas_daftar'    => now()->addMonths(2)->toDateString(),
            'status'          => 'menunggu_kurasi',
            'created_by'      => $mitraUser3->id,
        ]);
    }
}
