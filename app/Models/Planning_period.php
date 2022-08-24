<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning_period extends Model
{
    use HasFactory;
    protected $table = 'planning_period';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'startDate',
        'endDate',
        'planning',
    ];

    protected $hidden = [
        'planning',
    ];
}
