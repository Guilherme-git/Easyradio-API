<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reach_radio extends Model
{
    use HasFactory;
    protected $table = 'reach_radio';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'city',
        'radio'
    ];

    public function city()
    {
        return $this->hasOne(City::class,'id','city');
    }
}
