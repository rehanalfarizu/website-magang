<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogbookTask extends Model
{
    protected $table = 'logbook_task';
    public $timestamps = false;

    protected $fillable = [
        'logbook_id',
        'deskripsi_task',
        'status',
    ];

    public function logbook()
    {
        return $this->belongsTo(Logbook::class);
    }
}
