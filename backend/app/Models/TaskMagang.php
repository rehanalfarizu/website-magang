<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskMagang extends Model
{
    protected $table = 'task_magang';
    public $timestamps = false;

    protected $fillable = [
        'pendaftaran_id',
        'deskripsi_task',
        'target_bulan',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'target_bulan' => 'date',
            'created_at' => 'datetime',
        ];
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}
