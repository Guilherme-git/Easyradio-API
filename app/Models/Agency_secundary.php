<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency_secundary extends Model
{
    use HasFactory;
    protected $table = 'agency_secundary';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'nome',
        'sobrenome',
        'cpf',
        'email',
        'login',
        'senha',
        'agency'
    ];

    protected $hidden = [
        'senha'
    ];
}
