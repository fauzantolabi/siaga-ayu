<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perangkat_Daerah extends Model
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
    public function users()
    {
        return $this->hasMany(User::class, 'id_perangkat_daerah');
    }

    public function Jabatans()
    {
        return $this->hasMany(Jabatan::class, 'id_perangkat_daerah');
    }
}
