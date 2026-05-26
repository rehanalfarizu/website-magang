<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LogbookBukti;
use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogbookBuktiController extends Controller
{
    /**
     * POST /api/logbook/{logbook}/bukti - Upload file bukti
     */
    public function store(Request $request, Logbook $logbook)
    {
        $request->validate([
            'file' => 'required|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,zip',
        ]);

        $file  = $request->file('file');
        $ext   = $file->getClientOriginalExtension();
        $tipe  = in_array($ext, ['jpg', 'jpeg', 'png']) ? 'foto' :
                 ($ext === 'pdf' ? 'pdf' : 'dokumen');

        $path  = $file->store("logbook/{$logbook->id}/bukti", 'public');

        $bukti = LogbookBukti::create([
            'logbook_id'  => $logbook->id,
            'file_path'   => $path,
            'tipe'        => $tipe,
            'uploaded_at' => now(),
        ]);

        return response()->json([
            'message' => 'File bukti berhasil diupload',
            'bukti'   => $bukti,
            'url'     => Storage::url($path),
        ], 201);
    }

    /**
     * DELETE /api/logbook-bukti/{id} - Hapus bukti
     */
    public function destroy(LogbookBukti $logbookBukti)
    {
        Storage::disk('public')->delete($logbookBukti->file_path);
        $logbookBukti->delete();
        return response()->json(['message' => 'File bukti dihapus']);
    }
}
