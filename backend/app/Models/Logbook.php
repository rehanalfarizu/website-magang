<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Logbook extends Model
{
    use HasFactory;

    protected $table = 'logbook';

    protected $fillable = [
        'pendaftaran_id',
        'mitra_id',
        'dosen_id',
        'periode_bulan',
        'deskripsi_aktivitas',
        'status_review',
        'feedback_supervisor',
        'submitted_at',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'periode_bulan' => 'date',
            'submitted_at' => 'datetime',
            'reviewed_at' => 'datetime',
        ];
    }

    // Relationships
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function tasks()
    {
        return $this->hasMany(LogbookTask::class);
    }

    public function bukti()
    {
        return $this->hasMany(LogbookBukti::class);
    }
}
