<?php

namespace App\Http\Controllers;

use App\Models\Auth_user;
use App\Models\Radio;
use Illuminate\Http\Request;

class RadioController extends Controller
{
    public function listar()
    {
        $radios = Radio::with('person_juridica')
            ->with('midia_kit')
            ->with('profile')
            ->with('person_juridica')
            ->with('reach_radio.city')
            ->with('reach_radio.city.state')
            ->with('planejamento')
            ->with('planejamento.periodo')
            ->with('planejamento.insertion')
            ->with('planejamento.insertion.diasMes')
            ->with('planejamento.insertion.diasMesSelecionados')
            ->get();

        return $radios;
    }
}
