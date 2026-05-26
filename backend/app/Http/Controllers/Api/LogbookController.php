<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Logbook;
use App\Models\Pendaftaran;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
    /**
     * GET /api/logbook - List logbook (sesuai role)
     */
    public function index(Request $request)
    {
        $user  = $request->user();
        $query = Logbook::with(['pendaftaran.mahasiswa:id,nama,nim', 'pendaftaran.lowongan:id,posisi']);

        match ($user->role) {
            'mahasiswa' => $query->whereHas('pendaftaran', fn($q) =>
                                $q->where('mahasiswa_id', $user->mahasiswa->id)),
            'mitra'     => $query->where('mitra_id', $user->mitra->id),
            'dosen'     => $query->where('dosen_id', $user->dosen->id),
            default     => null, // admin: semua
        };

        if ($request->filled('pendaftaran_id')) {
            $query->where('pendaftaran_id', $request->pendaftaran_id);
        }
        if ($request->filled('status_review')) {
            $query->where('status_review', $request->status_review);
        }

        return response()->json($query->orderByDesc('periode_bulan')->paginate(12));
    }

    /**
     * POST /api/logbook - Buat logbook baru (Mahasiswa)
     */
    public function store(Request $request)
    {
        $request->validate([
            'pendaftaran_id'     => 'required|exists:pendaftaran,id',
            'periode_bulan'      => 'required|date_format:Y-m-d',
            'deskripsi_aktivitas'=> 'nullable|string',
        ]);

        // Pastikan ini pendaftaran milik mahasiswa yg login
        $pendaftaran = Pendaftaran::findOrFail($request->pendaftaran_id);
        $mahasiswa   = $request->user()->mahasiswa;
        if ($pendaftaran->mahasiswa_id !== $mahasiswa->id) {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        // Cek duplikat periode
        $existing = Logbook::where('pendaftaran_id', $request->pendaftaran_id)
            ->where('periode_bulan', $request->periode_bulan)->first();
        if ($existing) {
            return response()->json(['message' => 'Logbook untuk periode ini sudah ada'], 422);
        }

        $logbook = Logbook::create([
            'pendaftaran_id'      => $request->pendaftaran_id,
            'mitra_id'            => $pendaftaran->lowongan->mitra_id,
            'dosen_id'            => $pendaftaran->penugasanDosen()
                                        ->where('aktif', true)->first()?->dosen_id,
            'periode_bulan'       => $request->periode_bulan,
            'deskripsi_aktivitas' => $request->deskripsi_aktivitas,
            'status_review'       => 'draft',
        ]);

        return response()->json([
            'message' => 'Logbook berhasil dibuat',
            'logbook' => $logbook->load('tasks', 'bukti'),
        ], 201);
    }

    /**
     * GET /api/logbook/{id} - Detail logbook
     */
    public function show(Logbook $logbook)
    {
        return response()->json([
            'logbook' => $logbook->load([
                'pendaftaran.mahasiswa',
                'pendaftaran.lowongan.mitra',
                'dosen',
                'tasks',
                'bukti',
            ]),
        ]);
    }

    /**
     * PUT /api/logbook/{id} - Update logbook (Mahasiswa, hanya jika masih draft/perlu_revisi)
     */
    public function update(Request $request, Logbook $logbook)
    {
        $request->validate([
            'deskripsi_aktivitas' => 'nullable|string',
        ]);

        if (!in_array($logbook->status_review, ['draft', 'perlu_revisi'])) {
            return response()->json(['message' => 'Logbook tidak bisa diedit pada status ini'], 422);
        }

        $logbook->update($request->only(['deskripsi_aktivitas']));

        return response()->json(['message' => 'Logbook diupdate', 'logbook' => $logbook->fresh()]);
    }

    /**
     * PATCH /api/logbook/{id}/submit - Kirim logbook ke supervisor
     */
    public function submit(Request $request, Logbook $logbook)
    {
        if (!in_array($logbook->status_review, ['draft', 'perlu_revisi'])) {
            return response()->json(['message' => 'Logbook sudah dikirim'], 422);
        }

        $logbook->update([
            'status_review' => 'dikirim',
            'submitted_at'  => now(),
        ]);

        // Notifikasi ke dosen & mitra
        $pendaftaran = $logbook->pendaftaran;
        $mahasiswaNama = $pendaftaran->mahasiswa->nama;

        if ($logbook->dosen_id) {
            Notifikasi::create([
                'user_id'   => \App\Models\Dosen::find($logbook->dosen_id)->user_id,
                'tipe'      => 'LOGBOOK_DIKIRIM',
                'judul'     => 'Logbook Baru dari Mahasiswa',
                'pesan'     => "$mahasiswaNama mengirim logbook bulan " . $logbook->periode_bulan->format('M Y'),
                'data_id'   => $logbook->id,
                'data_type' => 'logbook',
            ]);
        }

        return response()->json(['message' => 'Logbook berhasil dikirim ke supervisor']);
    }

    /**
     * PATCH /api/logbook/{id}/review - Supervisor review logbook (Dosen/Mitra)
     */
    public function review(Request $request, Logbook $logbook)
    {
        $request->validate([
            'status_review'      => 'required|in:dibaca,diterima,perlu_revisi',
            'feedback_supervisor'=> 'nullable|string',
        ]);

        $logbook->update([
            'status_review'       => $request->status_review,
            'feedback_supervisor' => $request->feedback_supervisor,
            'reviewed_at'         => now(),
        ]);

        // Notifikasi ke mahasiswa
        $mahasiswaUserId = $logbook->pendaftaran->mahasiswa->user_id;
        $statusLabel     = match($request->status_review) {
            'diterima'    => 'Diterima ✅',
            'perlu_revisi'=> 'Perlu Revisi ⚠️',
            default       => 'Dibaca',
        };

        Notifikasi::create([
            'user_id'   => $mahasiswaUserId,
            'tipe'      => 'LOGBOOK_' . strtoupper($request->status_review),
            'judul'     => "Logbook $statusLabel",
            'pesan'     => "Logbook bulan " . $logbook->periode_bulan->format('M Y') . " $statusLabel." .
                           ($request->feedback_supervisor ? " Feedback: {$request->feedback_supervisor}" : ''),
            'data_id'   => $logbook->id,
            'data_type' => 'logbook',
        ]);

        return response()->json(['message' => 'Review logbook berhasil disimpan']);
    }

    /**
     * DELETE /api/logbook/{id} - Hapus logbook (hanya jika masih draft)
     */
    public function destroy(Logbook $logbook)
    {
        if ($logbook->status_review !== 'draft') {
            return response()->json(['message' => 'Hanya logbook draft yang bisa dihapus'], 422);
        }

        $logbook->delete();
        return response()->json(['message' => 'Logbook dihapus']);
    }
}
