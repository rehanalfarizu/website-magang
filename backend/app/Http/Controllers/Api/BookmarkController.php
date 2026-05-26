<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Lowongan;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    /**
     * GET /api/bookmark - List bookmark mahasiswa
     */
    public function index(Request $request)
    {
        $mahasiswa = $request->user()->mahasiswa;
        $bookmarks = Bookmark::where('mahasiswa_id', $mahasiswa->id)
            ->with('lowongan.mitra:id,nama_perusahaan')
            ->orderByDesc('created_at')
            ->get();

        return response()->json(['bookmarks' => $bookmarks]);
    }

    /**
     * POST /api/bookmark - Tambah bookmark
     */
    public function store(Request $request)
    {
        $request->validate([
            'lowongan_id' => 'required|exists:lowongan,id',
        ]);

        $mahasiswa = $request->user()->mahasiswa;

        $bookmark = Bookmark::firstOrCreate([
            'mahasiswa_id' => $mahasiswa->id,
            'lowongan_id'  => $request->lowongan_id,
        ]);

        return response()->json([
            'message'  => 'Lowongan ditambahkan ke bookmark',
            'bookmark' => $bookmark,
        ], 201);
    }

    /**
     * DELETE /api/bookmark/{lowongan_id} - Hapus bookmark by lowongan_id
     */
    public function destroy(Request $request, int $lowonganId)
    {
        $mahasiswa = $request->user()->mahasiswa;

        Bookmark::where('mahasiswa_id', $mahasiswa->id)
            ->where('lowongan_id', $lowonganId)
            ->delete();

        return response()->json(['message' => 'Bookmark dihapus']);
    }
}
