<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jabatan extends Model
{
    use SoftDeletes;
    protected $table = 'jabatans';
    protected $fillable = [
        'nama_jabatan',
        'deskripsi',
        'id_perangkat_daerah',
        'created_at',
        'updated_at'
    ];
    protected $dates = ['deleted_at'];

    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'id_jabatan');
    }
    public function perangkat_daerah()
    {
        return $this->belongsTo(Perangkat_Daerah::class, 'id_perangkat_daerah');
    }
}
