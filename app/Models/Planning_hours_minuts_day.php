<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning_hours_minuts_day extends Model
{
    use HasFactory;
    protected $table = 'planning_hours_minuts_day';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'ano',
        'dias',
        'insertion_selected',
        'mes',
        'planning'
    ];

    protected $hidden = [
        'planning',
    ];

    public function hours_minutes()
    {
        return $this->hasMany(Planning_hours_minuts::class,'planning_hours_minuts_day','id');
    }
}
