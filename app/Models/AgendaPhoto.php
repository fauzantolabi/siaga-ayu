<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaPhoto extends Model
{
    use HasFactory;

    protected $fillable = ['agenda_id', 'path'];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }
}
