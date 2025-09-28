<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    use Notifiable, HasFactory, SoftDeletes;
    protected $table = 'users';
    protected $fillable = [

        'email',
        'password',
        'username',
        'fullname',
        'phone',
        'foto',
        'role_id',
        'id_perangkat_daerah',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    protected $dates = ['deleted_at'];

    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'id_user');
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function perangkatDaerah()
    {
        return $this->belongsTo(Perangkat_Daerah::class, 'id_perangkat_daerah');
    }
}
