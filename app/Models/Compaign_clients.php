<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compaign_clients extends Model
{
    use HasFactory;
    protected $table = 'campaign_clients';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'nome',
        'person',
        'cpf_cnpj',
        'selected',
        'campaign',
    ];
}
