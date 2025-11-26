<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Misi extends Model
{
    use HasFactory;

    protected $fillable = [
        'misi',
        'description',
    ];

    // Relasi ke Program (One to Many)
    public function programs()
    {
        return $this->hasMany(Program::class, 'id_misi');
    }
}
