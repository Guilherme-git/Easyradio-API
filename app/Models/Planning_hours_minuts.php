<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning_hours_minuts extends Model
{
    use HasFactory;
    protected $table = 'planning_hours_minuts';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'value',
        'planning_hours_minuts_day',
    ];

    protected $hidden = [
        'planning_hours_minuts_day',
    ];

}
