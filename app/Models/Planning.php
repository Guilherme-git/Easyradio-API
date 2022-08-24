<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    use HasFactory;
    protected $table = 'planning';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'volume',
        'desconto',
        'total',
        'status',
        'spot_radio',
        "radio",
        'campaign'
    ];

    public function periodo()
    {
        return $this->hasOne(Planning_period::class,'planning','id');
    }

    public function insertion()
    {
        return $this->hasMany(Planning_insertion::class,'planning','id');
    }

    public function spot_radio()
    {
        return $this->hasOne(Spot_radio::class,'id','spot_radio');
    }

    public function hours_minutes_day()
    {
        return $this->hasMany(Planning_hours_minuts_day::class,'planning','id');
    }


}
