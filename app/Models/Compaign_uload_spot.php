<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compaign_uload_spot extends Model
{
    use HasFactory;
    protected $table = 'compaign_upload_spot';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'upload',
        'campaign'
    ];

    protected $hidden = [
        'planning',
    ];
}
