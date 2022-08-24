<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    public function cadastrar(Request $request)
    {
        foreach ($request->estados as $e) {
            $state = new State();
            $state->nome = $e['nome'];
            $state->save();
        }

        return State::all();
    }

    public function listar(Request $request)
    {
        return State::all();
    }
}
