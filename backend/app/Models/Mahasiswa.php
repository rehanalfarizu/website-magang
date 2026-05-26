<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nim',
        'nama',
        'ipk',
        'semester',
        'no_telepon',
        'status_magang',
    ];

    protected function casts(): array
    {
        return [
            'ipk' => 'decimal:2',
            'created_at' => 'datetime',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
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
