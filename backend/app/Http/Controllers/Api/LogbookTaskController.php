<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LogbookTask;
use App\Models\Logbook;
use Illuminate\Http\Request;

class LogbookTaskController extends Controller
{
    public function store(Request $request, Logbook $logbook)
    {
        $request->validate([
            'deskripsi_task' => 'required|string|max:500',
        ]);

        $task = LogbookTask::create([
            'logbook_id'     => $logbook->id,
            'deskripsi_task' => $request->deskripsi_task,
            'status'         => 'pending',
        ]);

        return response()->json(['message' => 'Task ditambahkan', 'task' => $task], 201);
    }

    public function update(Request $request, LogbookTask $logbookTask)
    {
        $request->validate([
            'deskripsi_task' => 'sometimes|string|max:500',
            'status'         => 'sometimes|in:pending,dikerjakan,selesai',
        ]);

        $logbookTask->update($request->only(['deskripsi_task', 'status']));

        return response()->json(['message' => 'Task diupdate', 'task' => $logbookTask->fresh()]);
    }

    public function destroy(LogbookTask $logbookTask)
    {
        $logbookTask->delete();
        return response()->json(['message' => 'Task dihapus']);
    }
}
