<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertiser_company extends Model
{
    use HasFactory;
    protected $table = 'advertiser_company';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'nome_fantasia',
        'telefone_comercial',
        'email_comercial',
        'facebook',
        'site',
        'instagram',
        'logo',
        'person_juridica',
    ];
}
