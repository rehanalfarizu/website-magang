<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use Illuminate\Http\Request;

class LowonganController extends Controller
{
    /**
     * GET /api/lowongan - List semua lowongan (publik, hanya yang published)
     */
    public function index(Request $request)
    {
        $query = Lowongan::with('mitra:id,nama_perusahaan,alamat')
            ->where('status', 'published');

        // Filter
        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'ilike', '%' . $request->lokasi . '%');
        }
        if ($request->filled('posisi')) {
            $query->where('posisi', 'ilike', '%' . $request->posisi . '%');
        }
        if ($request->filled('mitra_id')) {
            $query->where('mitra_id', $request->mitra_id);
        }

        $lowongan = $query->orderByDesc('created_at')->paginate(10);

        return response()->json($lowongan);
    }

    /**
     * GET /api/lowongan/all - List semua (admin & mitra, semua status)
     */
    public function all(Request $request)
    {
        $query = Lowongan::with('mitra:id,nama_perusahaan');

        // Mitra hanya lihat lowongan miliknya
        if ($request->user()->role === 'mitra') {
            $mitra = $request->user()->mitra;
            $query->where('mitra_id', $mitra->id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $lowongan = $query->orderByDesc('created_at')->paginate(15);

        return response()->json($lowongan);
    }

    /**
     * POST /api/lowongan - Buat lowongan baru (Mitra)
     */
    public function store(Request $request)
    {
        $request->validate([
            'posisi'        => 'required|string|max:255',
            'kuota'         => 'nullable|integer|min:1',
            'deskripsi_task'=> 'nullable|string',
            'requirements'  => 'nullable|string',
            'lokasi'        => 'nullable|string|max:255',
            'batas_daftar'  => 'nullable|date|after:today',
        ]);

        $mitra = $request->user()->mitra;

        $lowongan = Lowongan::create([
            'mitra_id'       => $mitra->id,
            'posisi'         => $request->posisi,
            'kuota'          => $request->kuota ?? 1,
            'deskripsi_task' => $request->deskripsi_task,
            'requirements'   => $request->requirements,
            'lokasi'         => $request->lokasi,
            'batas_daftar'   => $request->batas_daftar,
            'status'         => 'menunggu_kurasi',
            'created_by'     => $request->user()->id,
        ]);

        return response()->json([
            'message'  => 'Lowongan berhasil dibuat, menunggu kurasi admin',
            'lowongan' => $lowongan->load('mitra:id,nama_perusahaan'),
        ], 201);
    }

    /**
     * GET /api/lowongan/{id} - Detail lowongan
     */
    public function show(Lowongan $lowongan)
    {
        return response()->json([
            'lowongan' => $lowongan->load('mitra:id,nama_perusahaan,alamat,pic_nama,pic_email'),
        ]);
    }

    /**
     * PUT /api/lowongan/{id} - Update lowongan (Mitra/Admin)
     */
    public function update(Request $request, Lowongan $lowongan)
    {
        $request->validate([
            'posisi'         => 'sometimes|string|max:255',
            'kuota'          => 'sometimes|integer|min:1',
            'deskripsi_task' => 'nullable|string',
            'requirements'   => 'nullable|string',
            'lokasi'         => 'nullable|string|max:255',
            'batas_daftar'   => 'nullable|date',
            'status'         => 'sometimes|in:draft,menunggu_kurasi,published,ditolak,revisi',
        ]);

        // Mitra hanya boleh edit lowongan miliknya
        if ($request->user()->role === 'mitra') {
            $mitra = $request->user()->mitra;
            if ($lowongan->mitra_id !== $mitra->id) {
                return response()->json(['message' => 'Akses ditolak'], 403);
            }
        }

        $lowongan->update($request->only([
            'posisi', 'kuota', 'deskripsi_task', 'requirements',
            'lokasi', 'batas_daftar', 'status',
        ]));

        return response()->json([
            'message'  => 'Lowongan berhasil diupdate',
            'lowongan' => $lowongan->fresh()->load('mitra:id,nama_perusahaan'),
        ]);
    }

    /**
     * DELETE /api/lowongan/{id} - Hapus lowongan (Admin/Mitra)
     */
    public function destroy(Request $request, Lowongan $lowongan)
    {
        if ($request->user()->role === 'mitra') {
            $mitra = $request->user()->mitra;
            if ($lowongan->mitra_id !== $mitra->id) {
                return response()->json(['message' => 'Akses ditolak'], 403);
            }
        }

        $lowongan->delete();
        return response()->json(['message' => 'Lowongan berhasil dihapus']);
    }

    /**
     * PATCH /api/lowongan/{id}/kurasi - Admin approve/reject kurasi
     */
    public function kurasi(Request $request, Lowongan $lowongan)
    {
        $request->validate([
            'status' => 'required|in:published,ditolak,revisi',
            'catatan' => 'nullable|string',
        ]);

        $lowongan->update(['status' => $request->status]);

        return response()->json([
            'message'  => 'Status kurasi berhasil diupdate',
            'lowongan' => $lowongan->fresh(),
        ]);
    }
}
