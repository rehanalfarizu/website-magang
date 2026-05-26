<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nidn',
        'nama',
        'email',
        'no_telepon',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function penugasan()
    {
        return $this->hasMany(PenugasanDosen::class);
    }

    public function logbook()
    {
        return $this->hasMany(Logbook::class);
    }
}
