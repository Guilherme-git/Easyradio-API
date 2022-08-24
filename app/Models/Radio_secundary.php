<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Radio_secundary extends Model
{
    use HasFactory;
    protected $table = 'radio_secundary';
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
        'radio',
    ];

    protected $hidden = [
        'senha'
    ];
}
