<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'fullname',
        'username',
        'email',
        'password',
        'phone',
        'foto',
        'role_id',
        'id_perangkat_daerah',
        'created_at',
        'updated_at'
    ];

    protected $hidden = ['password'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function setRememberToken($value)
    {
        // Do nothing
    }
    public function getRememberToken()
    {
        return null;
    }

    protected $dates = ['deleted_at'];

    // Relasi ke Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // Relasi ke Perangkat Daerah
    public function perangkatDaerah()
    {
        return $this->belongsTo(PerangkatDaerah::class, 'id_perangkat_daerah');
    }

    // Relasi ke Agenda
    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'id_user');
    }

    // Relasi ke Surat
    public function surats()
    {
        return $this->hasMany(Surat::class, 'id_user');
    }
}
