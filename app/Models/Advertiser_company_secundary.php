<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertiser_company_secundary extends Model
{
    use HasFactory;
    protected $table = 'advertiser_company_secundary';
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
        'advertiser_company'
    ];

    protected $hidden = [
        'senha'
    ];
}
