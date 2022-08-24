<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compaign extends Model
{
    use HasFactory;
    protected $table = 'campaign';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'nome',
        'orcamento',
        'status',
        'duracao',
        'total_gasto',
        'localizacao',
        'auth_user'
    ];


    public function data()
    {
        return $this->hasMany(Compaign_data::class,'campaign','id');
    }

    public function clientes()
    {
        return $this->hasMany(Compaign_clients::class,'campaign','id');
    }

    public function upload_pdf()
    {
        return $this->hasOne(Compaign_uload_pdf::class,'campaign','id');
    }

    public function upload_spot()
    {
        return $this->hasOne(Compaign_uload_spot::class,'campaign','id');
    }

    public function auth_user()
    {
        return $this->hasOne(Auth_user::class,'id','auth_user');
    }
}
