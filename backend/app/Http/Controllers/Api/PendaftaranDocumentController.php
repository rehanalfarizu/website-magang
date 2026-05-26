<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranDocument;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PendaftaranDocumentController extends Controller
{
    /**
     * POST /api/pendaftaran/{pendaftaran}/dokumen - Upload dokumen pendaftaran
     */
    public function store(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'file' => 'required|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx',
            'tipe' => 'required|in:transkrip,cv,surat_lamaran,sertifikat,lainnya',
        ]);

        // Pastikan milik mahasiswa yg login
        $mahasiswa = $request->user()->mahasiswa;
        if ($pendaftaran->mahasiswa_id !== $mahasiswa->id) {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        $path = $request->file('file')->store(
            "pendaftaran/{$pendaftaran->id}/dokumen",
            'public'
        );

        $dokumen = PendaftaranDocument::create([
            'pendaftaran_id' => $pendaftaran->id,
            'tipe'           => $request->tipe,
            'file_path'      => $path,
            'uploaded_at'    => now(),
        ]);

        return response()->json([
            'message' => 'Dokumen berhasil diupload',
            'dokumen' => $dokumen,
            'url'     => Storage::url($path),
        ], 201);
    }

    /**
     * DELETE /api/pendaftaran-dokumen/{id} - Hapus dokumen
     */
    public function destroy(PendaftaranDocument $pendaftaranDocument)
    {
        Storage::disk('public')->delete($pendaftaranDocument->file_path);
        $pendaftaranDocument->delete();
        return response()->json(['message' => 'Dokumen dihapus']);
    }
}
