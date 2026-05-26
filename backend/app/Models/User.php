<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password_hash',
        'role',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    // Override getAuthPassword to use password_hash column
    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }

    // Relationships
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }

    public function dosen()
    {
        return $this->hasOne(Dosen::class);
    }

    public function adminProdi()
    {
        return $this->hasOne(AdminProdi::class);
    }

    public function mitra()
    {
        return $this->hasOne(Mitra::class);
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }
}
