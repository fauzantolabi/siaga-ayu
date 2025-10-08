<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jabatan extends Model
{
    use SoftDeletes;

    protected $table = 'jabatans';

    protected $fillable = [
        'jabatan',
        'id_perangkat_daerah',
        'created_at',
        'updated_at'
    ];

    protected $dates = ['deleted_at'];

    // Relasi ke Perangkat Daerah
    public function perangkatDaerah()
    {
        return $this->belongsTo(PerangkatDaerah::class, 'id_perangkat_daerah');
    }

    // Relasi ke Agenda
    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'id_jabatan');
    }

    // Relasi ke Surat
    public function surats()
    {
        return $this->hasMany(Surat::class, 'id_jabatan');
    }
}
