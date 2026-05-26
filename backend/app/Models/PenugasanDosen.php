<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenugasanDosen extends Model
{
    use HasFactory;

    protected $table = 'penugasan_dosen';
    public $timestamps = false;

    protected $fillable = [
        'pendaftaran_id',
        'dosen_id',
        'assigned_by',
        'assigned_at',
        'aktif',
    ];

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'aktif' => 'boolean',
        ];
    }

    // Relationships
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function adminProdi()
    {
        return $this->belongsTo(AdminProdi::class, 'assigned_by');
    }
}
