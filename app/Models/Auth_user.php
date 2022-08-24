<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auth_user extends Model
{
    use HasFactory;
    protected $table = 'auth_user';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'nome_usuario',
        'nome',
        'sobrenome',
        'email',
        'senha',
        'cpf',
        'type_user',
        'data_criacao',
        'nivel',
        'person_juridica',
        'auth_user_master'
    ];

    public function auth_user_secundario()
    {
        return $this->hasMany(Auth_user::class,'auth_user_master','id');
    }

    public function type_user()
    {
        return $this->hasOne(Type_user::class,'id','type_user');
    }

    public function person_juridica()
    {
        return $this->hasOne(Person_juridica::class,'id','person_juridica');
    }

    public function person_fisica()
    {
        return $this->hasOne(Person_fisica::class,'auth_user','id');
    }

    protected $hidden = [
        'senha',
        'auth_user_master',
    ];
}
