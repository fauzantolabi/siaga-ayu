<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use SoftDeletes;

    protected $table = 'agendas';

    protected $fillable = [
        'tanggal',
        'waktu',
        'agenda',
        'tempat',
        'id_surat',
        'id_jabatan',
        'id_pakaian',
        'id_user',
        'id_perangkat_daerah',
        'resume',
        'created_at',
        'updated_at'
    ];

    protected $dates = ['deleted_at'];

    // 🔹 Relasi ke Surat
    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }

    // 🔹 Relasi ke Jabatan
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }

    // 🔹 Relasi ke Pakaian (INI yang bikin error tadi)
    public function pakaian()
    {
        return $this->belongsTo(Pakaian::class, 'id_pakaian');
    }

    // 🔹 Relasi ke User (pembuat agenda)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // 🔹 Relasi ke Perangkat Daerah
    public function perangkatDaerah()
    {
        return $this->belongsTo(PerangkatDaerah::class, 'id_perangkat_daerah');
    }

    public function photos()
    {
        return $this->hasMany(AgendaPhoto::class, 'agenda_id');
    }


}
