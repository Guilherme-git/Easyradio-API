<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning_insertion_dias_mes extends Model
{
    use HasFactory;
    protected $table = 'planning_insertion_dias_mes';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'value',
        'planning_insertion',
    ];

    protected $hidden = [
        'planning_insertion',
    ];

}
