<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Radio extends Model
{
    use HasFactory;
    protected $table = 'radio';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'nome_fantasia',
        'dial',
        'fm_am',
        'concessao',
        'telefone_comercial',
        'email_comercial',
        'facebook',
        'site',
        'instragram',
        'midia_kit',
        'logo',
        'descricao',
        'data_criacao',
        'preco',
        'profile',
        'person_juridica'
    ];

    public function person_juridica()
    {
        return $this->hasOne(Person_juridica::class,'id','person_juridica');
    }

    public function midia_kit()
    {
        return $this->hasMany(Midia_kit::class,'radio','id');
    }

    public function reach_radio()
    {
        return $this->hasMany(Reach_radio::class,'radio','id');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class,'id','profile');
    }

    public function spot_radio()
    {
        return $this->hasMany(Spot_radio::class,'radio','id');
    }

    public function planejamento()
    {
        if(session()->get('compaign'))
        {
            return $this->hasOne(Planning::class,'radio','id')
                ->where('campaign','=',session()->get('compaign'))
                ->orderBy('id','DESC');
        } else {
            return $this->hasOne(Planning::class,'radio','id')->orderBy('id','DESC');
        }
    }

    public function proposta()
    {
        if(session()->get('compaign'))
        {
            return $this->hasMany(Proposal::class,'radio','id')
                ->where('campaign','=',session()->get('compaign'))
                ->orderBy('id','DESC');
        } else {
            return $this->hasMany(Proposal::class,'radio','id')->orderBy('id','DESC');
        }
    }

    public function proposta_recusada()
    {
        if(session()->get('compaign'))
        {
            return $this->hasMany(Proposal_refused::class,'radio','id')
                ->where('campaign','=',session()->get('compaign'))
                ->orderBy('id','DESC');
        } else {
            return $this->hasMany(Proposal_refused::class,'planning','id') ->orderBy('id','DESC');
        }

    }
}
