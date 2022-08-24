<?php

namespace App\Http\Controllers;

use App\Models\Spot;
use Illuminate\Http\Request;

class SpotController extends Controller
{
    public function cadastrar(Request $request)
    {
        try {
            $spot = new Spot();
            $spot->nome = $request->nome;
            $spot->save();

            return response()->json(['message'=>"Salvo"]);
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function listar()
    {
        $spots = Spot::all();
        return $spots;
    }
}
