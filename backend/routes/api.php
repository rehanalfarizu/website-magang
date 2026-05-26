<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LowonganController;
use App\Http\Controllers\Api\PendaftaranController;
use App\Http\Controllers\Api\PenugasanDosenController;
use App\Http\Controllers\Api\LogbookController;
use App\Http\Controllers\Api\LogbookTaskController;
use App\Http\Controllers\Api\LogbookBuktiController;
use App\Http\Controllers\Api\NotifikasiController;
use App\Http\Controllers\Api\BookmarkController;
use App\Http\Controllers\Api\PendaftaranDocumentController;
use App\Http\Controllers\Api\TaskMagangController;
use App\Http\Controllers\Api\AdminController;

// ============================================================
// PUBLIC ROUTES (tidak perlu auth)
// ============================================================
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
});

// Lowongan publik (hanya published)
Route::get('/lowongan',      [LowonganController::class, 'index']);
Route::get('/lowongan/{lowongan}', [LowonganController::class, 'show']);

// ============================================================
// PROTECTED ROUTES (perlu Sanctum token)
// ============================================================
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::get('/auth/me',     [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // ── Notifikasi (semua role) ──────────────────────────────
    Route::prefix('notifikasi')->group(function () {
        Route::get('/',                [NotifikasiController::class, 'index']);
        Route::patch('/read-all',      [NotifikasiController::class, 'markAllRead']);
        Route::patch('/{notifikasi}/read', [NotifikasiController::class, 'markRead']);
        Route::delete('/{notifikasi}', [NotifikasiController::class, 'destroy']);
    });

    // ── MAHASISWA ROUTES ─────────────────────────────────────
    Route::middleware('role:mahasiswa')->group(function () {
        // Pendaftaran
        Route::post('/pendaftaran', [PendaftaranController::class, 'store']);

        // Dokumen pendaftaran
        Route::post('/pendaftaran/{pendaftaran}/dokumen', [PendaftaranDocumentController::class, 'store']);
        Route::delete('/pendaftaran-dokumen/{pendaftaranDocument}', [PendaftaranDocumentController::class, 'destroy']);

        // Logbook (buat & edit)
        Route::post('/logbook',              [LogbookController::class, 'store']);
        Route::put('/logbook/{logbook}',     [LogbookController::class, 'update']);
        Route::patch('/logbook/{logbook}/submit', [LogbookController::class, 'submit']);
        Route::delete('/logbook/{logbook}',  [LogbookController::class, 'destroy']);

        // Logbook task
        Route::post('/logbook/{logbook}/task',     [LogbookTaskController::class, 'store']);
        Route::put('/logbook-task/{logbookTask}',  [LogbookTaskController::class, 'update']);
        Route::delete('/logbook-task/{logbookTask}', [LogbookTaskController::class, 'destroy']);

        // Logbook bukti
        Route::post('/logbook/{logbook}/bukti',        [LogbookBuktiController::class, 'store']);
        Route::delete('/logbook-bukti/{logbookBukti}', [LogbookBuktiController::class, 'destroy']);

        // Bookmark
        Route::get('/bookmark',          [BookmarkController::class, 'index']);
        Route::post('/bookmark',         [BookmarkController::class, 'store']);
        Route::delete('/bookmark/{lowonganId}', [BookmarkController::class, 'destroy']);

        // Task magang
        Route::get('/pendaftaran/{pendaftaran}/task',  [TaskMagangController::class, 'index']);
        Route::post('/pendaftaran/{pendaftaran}/task', [TaskMagangController::class, 'store']);
        Route::put('/task-magang/{taskMagang}',        [TaskMagangController::class, 'update']);
        Route::delete('/task-magang/{taskMagang}',     [TaskMagangController::class, 'destroy']);
    });

    // ── DOSEN ROUTES ─────────────────────────────────────────
    Route::middleware('role:dosen')->group(function () {
        Route::patch('/logbook/{logbook}/review', [LogbookController::class, 'review']);
        Route::put('/task-magang/{taskMagang}',   [TaskMagangController::class, 'update']);
    });

    // ── MITRA ROUTES ─────────────────────────────────────────
    Route::middleware('role:mitra')->group(function () {
        Route::get('/lowongan-saya',       [LowonganController::class, 'all']);
        Route::post('/lowongan',           [LowonganController::class, 'store']);
        Route::put('/lowongan/{lowongan}', [LowonganController::class, 'update']);
        Route::delete('/lowongan/{lowongan}', [LowonganController::class, 'destroy']);

        // Mitra approve/reject pendaftaran
        Route::patch('/pendaftaran/{pendaftaran}/approve-mitra', [PendaftaranController::class, 'approveMitra']);

        // Review logbook
        Route::patch('/logbook/{logbook}/review', [LogbookController::class, 'review']);
    });

    // ── ADMIN ROUTES ─────────────────────────────────────────
    Route::middleware('role:admin')->group(function () {
        // Dashboard & data
        Route::get('/admin/dashboard',   [AdminController::class, 'dashboard']);
        Route::get('/admin/mahasiswa',   [AdminController::class, 'mahasiswa']);
        Route::get('/admin/dosen',       [AdminController::class, 'dosen']);
        Route::get('/admin/mitra',       [AdminController::class, 'mitra']);
        Route::patch('/admin/mitra/{mitra}/approve', [AdminController::class, 'approveMitra']);
        Route::patch('/admin/mitra/{mitra}/reject',  [AdminController::class, 'rejectMitra']);

        // Kurasi lowongan
        Route::get('/lowongan-all',               [LowonganController::class, 'all']);
        Route::patch('/lowongan/{lowongan}/kurasi', [LowonganController::class, 'kurasi']);

        // Proses pendaftaran
        Route::patch('/pendaftaran/{pendaftaran}/approve-prodi', [PendaftaranController::class, 'approveProdi']);
        Route::patch('/pendaftaran/{pendaftaran}/reject-prodi',  [PendaftaranController::class, 'rejectProdi']);

        // Penugasan dosen
        Route::get('/penugasan-dosen',           [PenugasanDosenController::class, 'index']);
        Route::post('/penugasan-dosen',          [PenugasanDosenController::class, 'store']);
        Route::delete('/penugasan-dosen/{penugasanDosen}', [PenugasanDosenController::class, 'destroy']);
    });

    // ── SHARED ROUTES (beberapa role) ────────────────────────
    Route::middleware('role:mahasiswa,dosen,admin,mitra')->group(function () {
        Route::get('/pendaftaran',            [PendaftaranController::class, 'index']);
        Route::get('/pendaftaran/{pendaftaran}', [PendaftaranController::class, 'show']);
        Route::get('/logbook',               [LogbookController::class, 'index']);
        Route::get('/logbook/{logbook}',     [LogbookController::class, 'show']);
    });

    // Penugasan dosen (dosen lihat tugasnya)
    Route::middleware('role:dosen,admin')->group(function () {
        Route::get('/penugasan-dosen', [PenugasanDosenController::class, 'index']);
    });
});
