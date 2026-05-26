<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $table = 'bookmark';
    public $timestamps = false;

    protected $fillable = [
        'mahasiswa_id',
        'lowongan_id',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }
}
