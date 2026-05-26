<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lowongan extends Model
{
    use HasFactory;

    protected $table = 'lowongan';

    protected $fillable = [
        'mitra_id',
        'posisi',
        'kuota',
        'deskripsi_task',
        'requirements',
        'lokasi',
        'batas_daftar',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'batas_daftar' => 'date',
            'kuota' => 'integer',
        ];
    }

    // Relationships
    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function bookmark()
    {
        return $this->hasMany(Bookmark::class);
    }
}
