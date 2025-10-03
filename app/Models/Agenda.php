<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use SoftDeletes;
    protected $table = 'agendas';

    public function scopeNearest($query)
    {
        return $query->orderByRaw("CONCAT(tanggal, ' ', waktu) ASC");
    }
    protected $fillable = [
        'id_surat',
        'id_user',
        'tanggal',
        'waktu',
        'agenda',
        'tempat',
        'id_pakaian',
        'id_jabatan',
        'resume',
        'foto',
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
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id');
    }


}
