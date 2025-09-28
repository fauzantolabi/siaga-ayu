<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pakaian extends Model
{
    use SoftDeletes;
    protected $table = 'pakaian';
    protected $fillable = [
        'nama_pakaian',
        'ukuran',
        'warna',
        'stok',
        'harga',
        'created_at',
        'updated_at'
    ];
    protected $dates = ['deleted_at'];

    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'id_pakaian');
    }
}
