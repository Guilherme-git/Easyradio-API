<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person_fisica extends Model
{
    use HasFactory;
    protected $table = 'person_fisica';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'cpf',
        'image',
        'auth_user'
    ];
}
