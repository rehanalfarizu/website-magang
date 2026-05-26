<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogbookBukti extends Model
{
    protected $table = 'logbook_bukti';
    public $timestamps = false;

    protected $fillable = [
        'logbook_id',
        'file_path',
        'tipe',
        'uploaded_at',
    ];

    protected function casts(): array
    {
        return [
            'uploaded_at' => 'datetime',
        ];
    }

    public function logbook()
    {
        return $this->belongsTo(Logbook::class);
    }
}
