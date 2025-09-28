<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surat extends Model
{
    use SoftDeletes;
    protected $table = 'surats';
    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'perihal',
        'tujuan',
        'isi_surat',
        'id_perangkat_daerah',
        'id_user',
        'created_at',
        'updated_at'
    ];
    protected $dates = ['deleted_at'];

    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'id_surat');
    }
    public function perangkat_daerah()
    {
        return $this->belongsTo(Perangkat_Daerah::class, 'id_perangkat_daerah');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
