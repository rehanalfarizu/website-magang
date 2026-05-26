<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminProdi extends Model
{
    use HasFactory;

    protected $table = 'admin_prodi';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nama',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function penugasan()
    {
        return $this->hasMany(PenugasanDosen::class, 'assigned_by');
    }
}
