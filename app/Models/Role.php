<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class role extends Model
{
    use SoftDeletes;
    protected $table = 'roles';
    protected $fillable = [
        'name',
        'description',
        'created_at',
        'updated_at'
    ];

    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->hasMany(User::class, 'id_role');
    }
}
