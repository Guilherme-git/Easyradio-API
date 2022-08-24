<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal_refused extends Model
{
    use HasFactory;
    protected $table = 'proposal_refused';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'descricao',
        'radio',
        'data',
        'planning',
        'campaign'
    ];

    public function radio()
    {
        return $this->hasOne(Radio::class,'id','radio');
    }
}
