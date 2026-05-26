<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Lowongan;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    /**
     * GET /api/pendaftaran - List pendaftaran (sesuai role)
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Pendaftaran::with([
            'mahasiswa:id,nama,nim',
            'lowongan:id,posisi,lokasi,mitra_id',
            'lowongan.mitra:id,nama_perusahaan',
        ]);

        match ($user->role) {
            'mahasiswa' => $query->where('mahasiswa_id', $user->mahasiswa->id),
            'mitra'     => $query->whereHas('lowongan', fn($q) =>
                                $q->where('mitra_id', $user->mitra->id)),
            'dosen'     => $query->whereHas('penugasanDosen', fn($q) =>
                                $q->where('dosen_id', $user->dosen->id)->where('aktif', true)),
            default     => null, // admin: semua
        };

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->orderByDesc('created_at')->paginate(15));
    }

    /**
     * POST /api/pendaftaran - Daftar magang (Mahasiswa)
     */
    public function store(Request $request)
    {
        $request->validate([
            'lowongan_id' => 'required|exists:lowongan,id',
        ]);

        $mahasiswa = $request->user()->mahasiswa;
        $lowongan  = Lowongan::findOrFail($request->lowongan_id);

        // Cek lowongan masih published
        if ($lowongan->status !== 'published') {
            return response()->json(['message' => 'Lowongan tidak tersedia'], 422);
        }

        // Cek sudah pernah daftar
        $existing = Pendaftaran::where('mahasiswa_id', $mahasiswa->id)
            ->where('lowongan_id', $request->lowongan_id)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Kamu sudah mendaftar ke lowongan ini'], 422);
        }

        $pendaftaran = Pendaftaran::create([
            'mahasiswa_id' => $mahasiswa->id,
            'lowongan_id'  => $request->lowongan_id,
            'status'       => 'pending_prodi',
        ]);

        return response()->json([
            'message'     => 'Pendaftaran berhasil dikirim, menunggu persetujuan prodi',
            'pendaftaran' => $pendaftaran->load('lowongan.mitra'),
        ], 201);
    }

    /**
     * GET /api/pendaftaran/{id} - Detail pendaftaran
     */
    public function show(Pendaftaran $pendaftaran)
    {
        return response()->json([
            'pendaftaran' => $pendaftaran->load([
                'mahasiswa.user:id,email',
                'lowongan.mitra',
                'penugasanDosen.dosen',
                'dokumen',
                'logbook',
                'taskMagang',
            ]),
        ]);
    }

    /**
     * PATCH /api/pendaftaran/{id}/approve-prodi - Admin setujui ke mitra
     */
    public function approveProdi(Request $request, Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->status !== 'pending_prodi') {
            return response()->json(['message' => 'Status tidak valid untuk aksi ini'], 422);
        }

        $pendaftaran->update(['status' => 'pending_mitra']);

        // Kirim notifikasi ke mahasiswa
        Notifikasi::create([
            'user_id'   => $pendaftaran->mahasiswa->user_id,
            'tipe'      => 'PENDAFTARAN_STATUS',
            'judul'     => 'Pendaftaran Disetujui Prodi',
            'pesan'     => 'Pendaftaranmu ke ' . $pendaftaran->lowongan->posisi . ' sudah disetujui prodi dan dikirim ke mitra.',
            'data_id'   => $pendaftaran->id,
            'data_type' => 'pendaftaran',
        ]);

        return response()->json(['message' => 'Pendaftaran disetujui prodi, diteruskan ke mitra']);
    }

    /**
     * PATCH /api/pendaftaran/{id}/approve-mitra - Mitra terima/tolak
     */
    public function approveMitra(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'action'           => 'required|in:diterima,ditolak',
            'alasan_penolakan' => 'required_if:action,ditolak|nullable|string',
        ]);

        if ($pendaftaran->status !== 'pending_mitra') {
            return response()->json(['message' => 'Status tidak valid untuk aksi ini'], 422);
        }

        // Validasi mitra hanya approve pendaftaran miliknya
        $mitra = $request->user()->mitra;
        if ($pendaftaran->lowongan->mitra_id !== $mitra->id) {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        $pendaftaran->update([
            'status'           => $request->action,
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

        // Update status magang mahasiswa jika diterima
        if ($request->action === 'diterima') {
            $pendaftaran->mahasiswa->update(['status_magang' => 'sedang_magang']);
        }

        // Notifikasi ke mahasiswa
        $statusLabel = $request->action === 'diterima' ? 'Diterima' : 'Ditolak';
        Notifikasi::create([
            'user_id'   => $pendaftaran->mahasiswa->user_id,
            'tipe'      => 'PENDAFTARAN_STATUS',
            'judul'     => "Pendaftaran $statusLabel oleh Mitra",
            'pesan'     => "Pendaftaranmu ke {$pendaftaran->lowongan->posisi} telah $request->action oleh mitra.",
            'data_id'   => $pendaftaran->id,
            'data_type' => 'pendaftaran',
        ]);

        return response()->json(['message' => "Pendaftaran berhasil $request->action"]);
    }

    /**
     * PATCH /api/pendaftaran/{id}/reject-prodi - Admin tolak pendaftaran
     */
    public function rejectProdi(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string',
        ]);

        $pendaftaran->update([
            'status'           => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

        Notifikasi::create([
            'user_id'   => $pendaftaran->mahasiswa->user_id,
            'tipe'      => 'PENDAFTARAN_STATUS',
            'judul'     => 'Pendaftaran Ditolak Prodi',
            'pesan'     => "Pendaftaranmu ke {$pendaftaran->lowongan->posisi} ditolak. Alasan: {$request->alasan_penolakan}",
            'data_id'   => $pendaftaran->id,
            'data_type' => 'pendaftaran',
        ]);

        return response()->json(['message' => 'Pendaftaran ditolak']);
    }
}
