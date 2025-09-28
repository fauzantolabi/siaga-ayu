<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use SoftDeletes;
    protected $table = 'agendas';
    protected $fillable = [
        'id_surat',
        'tanggal_agenda',
        'waktu_agenda',
        'tempat_agenda',
        'keterangan',
        'id_user',
        'id_pakaian',
        'id_jabatan',
        'created_at',
        'updated_at'
    ];
    protected $dates = ['deleted_at'];
    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function pakaian()
    {
        return $this->belongsTo(Pakaian::class, 'id_pakaian');
    }
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }


}
