<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    /**
     * GET /api/notifikasi - List notifikasi user yang login
     */
    public function index(Request $request)
    {
        $notifikasi = Notifikasi::where('user_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->paginate(20);

        $unreadCount = Notifikasi::where('user_id', $request->user()->id)
            ->where('is_read', false)->count();

        return response()->json([
            'notifikasi'   => $notifikasi,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * PATCH /api/notifikasi/{id}/read - Tandai 1 notifikasi sudah dibaca
     */
    public function markRead(Notifikasi $notifikasi, Request $request)
    {
        if ($notifikasi->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        $notifikasi->update(['is_read' => true]);
        return response()->json(['message' => 'Notifikasi ditandai sudah dibaca']);
    }

    /**
     * PATCH /api/notifikasi/read-all - Tandai semua notifikasi sudah dibaca
     */
    public function markAllRead(Request $request)
    {
        Notifikasi::where('user_id', $request->user()->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['message' => 'Semua notifikasi ditandai sudah dibaca']);
    }

    /**
     * DELETE /api/notifikasi/{id} - Hapus notifikasi
     */
    public function destroy(Notifikasi $notifikasi, Request $request)
    {
        if ($notifikasi->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        $notifikasi->delete();
        return response()->json(['message' => 'Notifikasi dihapus']);
    }
}
