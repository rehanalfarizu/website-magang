<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TaskMagang;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class TaskMagangController extends Controller
{
    /**
     * GET /api/pendaftaran/{pendaftaran}/task - List task magang
     */
    public function index(Pendaftaran $pendaftaran)
    {
        $tasks = TaskMagang::where('pendaftaran_id', $pendaftaran->id)
            ->orderBy('target_bulan')
            ->get();

        return response()->json(['tasks' => $tasks]);
    }

    /**
     * POST /api/pendaftaran/{pendaftaran}/task - Buat task baru
     */
    public function store(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'deskripsi_task' => 'required|string|max:500',
            'target_bulan'   => 'nullable|date_format:Y-m-d',
        ]);

        $task = TaskMagang::create([
            'pendaftaran_id'  => $pendaftaran->id,
            'deskripsi_task'  => $request->deskripsi_task,
            'target_bulan'    => $request->target_bulan,
            'status'          => 'pending',
        ]);

        return response()->json(['message' => 'Task dibuat', 'task' => $task], 201);
    }

    /**
     * PUT /api/task-magang/{id} - Update task
     */
    public function update(Request $request, TaskMagang $taskMagang)
    {
        $request->validate([
            'deskripsi_task' => 'sometimes|string|max:500',
            'target_bulan'   => 'nullable|date_format:Y-m-d',
            'status'         => 'sometimes|in:pending,approved,completed',
        ]);

        $taskMagang->update($request->only(['deskripsi_task', 'target_bulan', 'status']));

        return response()->json(['message' => 'Task diupdate', 'task' => $taskMagang->fresh()]);
    }

    /**
     * DELETE /api/task-magang/{id} - Hapus task
     */
    public function destroy(TaskMagang $taskMagang)
    {
        $taskMagang->delete();
        return response()->json(['message' => 'Task dihapus']);
    }
}
