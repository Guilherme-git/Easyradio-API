<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spot_radio extends Model
{
    use HasFactory;
    protected $table = 'spot_radio';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'horario',
        'valor',
        'radio',
        'spot',
    ];

    public function spot()
    {
        return $this->hasOne(Spot::class,'id','spot');
    }
}
