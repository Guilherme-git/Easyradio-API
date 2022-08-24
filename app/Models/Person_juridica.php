<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person_juridica extends Model
{
    use HasFactory;
    protected $table = 'person_juridica';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'razao_social',
        'cnpj',
        'cep',
        'logradouro',
        'estado',
        'bairro',
        'cidade',
        'complemento',
        'inscricao_municipal',
        'inscricao_estadual',
    ];

    public function emissora_radio()
    {
        return $this->hasOne(Radio::class,'person_juridica','id');
    }

    public function agencia()
    {
        return $this->hasOne(Agency::class,'person_juridica','id');
    }

    public function empresa_anuciante()
    {
        return $this->hasOne(Advertiser_company::class,'person_juridica','id');
    }
}
