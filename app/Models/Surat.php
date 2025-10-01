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
        'created_at',
        'updated_at'
    ];
    protected $dates = ['deleted_at'];

    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'id_surat');
    }

}
