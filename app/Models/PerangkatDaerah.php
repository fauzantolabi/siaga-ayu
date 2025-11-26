<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerangkatDaerah extends Model
{
    use SoftDeletes;

    protected $table = 'perangkat_daerahs';

    protected $fillable = [
        'perangkat_daerah',
        'singkatan',
        'created_at',
        'updated_at'
    ];

    protected $dates = ['deleted_at'];

    // Relasi ke User
    public function users()
    {
        return $this->hasMany(User::class, 'id_perangkat_daerah');
    }

    // Relasi ke Jabatan
    public function jabatans()
    {
        return $this->hasMany(Jabatan::class, 'id_perangkat_daerah');
    }

    // Relasi ke Agenda (jika agenda punya id_perangkat_daerah)
    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'id_perangkat_daerah');
    }

    // Relasi ke Surat (jika surat punya id_perangkat_daerah)
    public function surats()
    {
        return $this->hasMany(Surat::class, 'id_perangkat_daerah');
    }
}
