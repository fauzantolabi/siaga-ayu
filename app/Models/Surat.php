<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surat extends Model
{
    use SoftDeletes;

    protected $table = 'surats';

    protected $fillable = [
        'asal_surat',
        'nomor_surat',
        'perihal',
        'tanggal_surat',
        'tanggal_terima',
        'sifat_surat',
        'hal',
        'id_jabatan',
        'id_perangkat_daerah',
        'created_at',
        'updated_at'
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }

    public function perangkatDaerah()
    {
        return $this->belongsTo(PerangkatDaerah::class, 'id_perangkat_daerah');
    }
}
