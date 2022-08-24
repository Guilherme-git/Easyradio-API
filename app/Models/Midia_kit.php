<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Midia_kit extends Model
{
    use HasFactory;
    protected $table = 'midia_kit';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'midia_kit',
        'radio',
    ];
}
