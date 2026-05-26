<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranDocument extends Model
{
    protected $table = 'pendaftaran_document';
    public $timestamps = false;

    protected $fillable = [
        'pendaftaran_id',
        'tipe',
        'file_path',
        'uploaded_at',
    ];

    protected function casts(): array
    {
        return [
            'uploaded_at' => 'datetime',
        ];
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}
