<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning_insertion extends Model
{
    use HasFactory;
    protected $table = 'planning_insertion';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'mes',
        'ano',
        'planning'
    ];

    public function diasMes()
    {
        return $this->hasMany(Planning_insertion_dias_mes::class,'planning_insertion','id');
    }

    public function diasMesSelecionados()
    {
        return $this->hasMany(Planning_insertion_dias_mes_select::class,'planning_insertion','id');
    }

    protected $hidden = [
        'planning',
    ];
}
