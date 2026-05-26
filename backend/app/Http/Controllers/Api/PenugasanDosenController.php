<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PenugasanDosen;
use App\Models\Pendaftaran;
use App\Models\Dosen;
use App\Models\AdminProdi;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class PenugasanDosenController extends Controller
{
    /**
     * GET /api/penugasan-dosen - List penugasan
     */
    public function index(Request $request)
    {
        $query = PenugasanDosen::with([
            'pendaftaran.mahasiswa:id,nama,nim',
            'pendaftaran.lowongan:id,posisi',
            'dosen:id,nama,nidn',
        ]);

        if ($request->user()->role === 'dosen') {
            $query->where('dosen_id', $request->user()->dosen->id);
        }

        if ($request->filled('pendaftaran_id')) {
            $query->where('pendaftaran_id', $request->pendaftaran_id);
        }

        return response()->json($query->where('aktif', true)->get());
    }

    /**
     * POST /api/penugasan-dosen - Assign dosen ke pendaftaran (Admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftaran,id',
            'dosen_id'       => 'required|exists:dosen,id',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($request->pendaftaran_id);

        if ($pendaftaran->status !== 'diterima') {
            return response()->json([
                'message' => 'Penugasan dosen hanya bisa untuk pendaftaran yang sudah diterima'
            ], 422);
        }

        // Non-aktifkan penugasan lama jika ada
        PenugasanDosen::where('pendaftaran_id', $request->pendaftaran_id)
            ->where('aktif', true)
            ->update(['aktif' => false]);

        $admin    = $request->user()->adminProdi;
        $penugasan = PenugasanDosen::create([
            'pendaftaran_id' => $request->pendaftaran_id,
            'dosen_id'       => $request->dosen_id,
            'assigned_by'    => $admin->id,
            'assigned_at'    => now(),
            'aktif'          => true,
        ]);

        // Notifikasi ke dosen
        $dosen = Dosen::find($request->dosen_id);
        Notifikasi::create([
            'user_id'   => $dosen->user_id,
            'tipe'      => 'PENUGASAN_DOSEN',
            'judul'     => 'Penugasan Pembimbing Magang',
            'pesan'     => "Kamu ditugaskan sebagai pembimbing {$pendaftaran->mahasiswa->nama} di {$pendaftaran->lowongan->posisi}",
            'data_id'   => $penugasan->id,
            'data_type' => 'penugasan_dosen',
        ]);

        return response()->json([
            'message'   => 'Dosen berhasil ditugaskan',
            'penugasan' => $penugasan->load('dosen:id,nama,nidn'),
        ], 201);
    }

    /**
     * DELETE /api/penugasan-dosen/{id} - Batalkan penugasan (Admin)
     */
    public function destroy(PenugasanDosen $penugasanDosen)
    {
        $penugasanDosen->update(['aktif' => false]);
        return response()->json(['message' => 'Penugasan dosen dinonaktifkan']);
    }
}
