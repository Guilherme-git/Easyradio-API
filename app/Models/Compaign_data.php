<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compaign_data extends Model
{
    use HasFactory;
    protected $table = 'campaign_data';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'estado',
        'cidade',
        'perfil',
        'radio_id',
        'campaign',
    ];

    protected $hidden = [
        'radio_id',
        'campaign'
    ];

    public function campanha()
    {
        return $this->hasOne(Compaign::class,'id','campaign');
    }

    public function radio()
    {
        return $this->hasOne(Radio::class,'id','radio_id');
    }
}
