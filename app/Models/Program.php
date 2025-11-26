<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_misi',
        'description',
    ];

    // Relasi ke Misi (Many to One)
    public function misi()
    {
        return $this->belongsTo(Misi::class, 'id_misi');
    }

    // Relasi ke Agenda (One to Many)
    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'id_program');
    }
}
