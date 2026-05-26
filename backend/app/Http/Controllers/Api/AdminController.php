<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pendaftaran;
use App\Models\Lowongan;
use App\Models\Mahasiswa;
use App\Models\Mitra;
use App\Models\Dosen;
use App\Models\Logbook;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * GET /api/admin/dashboard - Statistik dashboard admin
     */
    public function dashboard()
    {
        return response()->json([
            'stats' => [
                'total_mahasiswa'    => Mahasiswa::count(),
                'total_dosen'        => Dosen::count(),
                'total_mitra'        => Mitra::where('status', 'approved')->count(),
                'total_lowongan'     => Lowongan::where('status', 'published')->count(),
                'pending_kurasi'     => Lowongan::where('status', 'menunggu_kurasi')->count(),
                'pending_prodi'      => Pendaftaran::where('status', 'pending_prodi')->count(),
                'sedang_magang'      => Mahasiswa::where('status_magang', 'sedang_magang')->count(),
                'total_logbook'      => Logbook::count(),
                'logbook_perlu_review' => Logbook::where('status_review', 'dikirim')->count(),
            ],
            'pendaftaran_per_status' => Pendaftaran::selectRaw('status, count(*) as total')
                ->groupBy('status')->get(),
            'lowongan_terbaru' => Lowongan::with('mitra:id,nama_perusahaan')
                ->where('status', 'menunggu_kurasi')
                ->latest()->take(5)->get(),
            'pendaftaran_terbaru' => Pendaftaran::with([
                    'mahasiswa:id,nama,nim',
                    'lowongan:id,posisi',
                ])
                ->where('status', 'pending_prodi')
                ->latest()->take(5)->get(),
        ]);
    }

    /**
     * GET /api/admin/mahasiswa - List semua mahasiswa
     */
    public function mahasiswa(Request $request)
    {
        $query = Mahasiswa::with('user:id,email');

        if ($request->filled('status_magang')) {
            $query->where('status_magang', $request->status_magang);
        }
        if ($request->filled('search')) {
            $query->where('nama', 'ilike', '%' . $request->search . '%')
                  ->orWhere('nim', 'ilike', '%' . $request->search . '%');
        }

        return response()->json($query->paginate(15));
    }

    /**
     * GET /api/admin/dosen - List semua dosen
     */
    public function dosen(Request $request)
    {
        $query = Dosen::with([
            'user:id,email',
            'penugasan' => fn($q) => $q->where('aktif', true)
        ])->withCount(['penugasan as total_bimbingan' => fn($q) => $q->where('aktif', true)]);

        if ($request->filled('search')) {
            $query->where('nama', 'ilike', '%' . $request->search . '%');
        }

        return response()->json($query->paginate(15));
    }

    /**
     * GET /api/admin/mitra - List semua mitra
     */
    public function mitra(Request $request)
    {
        $query = Mitra::with('user:id,email')
            ->withCount('lowongan');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->paginate(15));
    }

    /**
     * PATCH /api/admin/mitra/{id}/approve - Approve mitra
     */
    public function approveMitra(Mitra $mitra)
    {
        $mitra->update(['status' => 'approved']);
        return response()->json(['message' => 'Mitra berhasil disetujui']);
    }

    /**
     * PATCH /api/admin/mitra/{id}/reject - Reject mitra
     */
    public function rejectMitra(Mitra $mitra)
    {
        $mitra->update(['status' => 'rejected']);
        return response()->json(['message' => 'Mitra ditolak']);
    }
}
