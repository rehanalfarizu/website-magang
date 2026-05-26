<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';

    protected $fillable = [
        'mahasiswa_id',
        'lowongan_id',
        'status',
        'alasan_penolakan',
    ];

    // Relationships
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }

    public function penugasanDosen()
    {
        return $this->hasMany(PenugasanDosen::class);
    }

    public function logbook()
    {
        return $this->hasMany(Logbook::class);
    }

    public function dokumen()
    {
        return $this->hasMany(PendaftaranDocument::class);
    }

    public function taskMagang()
    {
        return $this->hasMany(TaskMagang::class);
    }
}
