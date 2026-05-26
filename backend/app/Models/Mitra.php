<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mitra extends Model
{
    use HasFactory;

    protected $table = 'mitra';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nama_perusahaan',
        'alamat',
        'pic_nama',
        'pic_email',
        'pic_telepon',
        'status',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lowongan()
    {
        return $this->hasMany(Lowongan::class);
    }

    public function logbook()
    {
        return $this->hasMany(Logbook::class);
    }
}
