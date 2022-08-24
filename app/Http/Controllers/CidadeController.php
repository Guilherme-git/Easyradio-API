<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CidadeController extends Controller
{
    public function cadastrar(Request $request)
    {
        foreach ($request->cidades as $c) {
            $cidade = new City();
            $cidade->nome = $c['nome'];
            $cidade->state = $c['state'];
            $cidade->save();
        }

        return City::all();
    }

    public function listar() {
        return City::all();
    }
}
