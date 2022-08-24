<?php

namespace App\Http\Controllers;

use App\Models\Type_user;
use Illuminate\Http\Request;

class Tipo_usuarioController extends Controller
{
    public function cadastrar(Request $request)
    {
        try {
            $tipo = new Type_user();
            $tipo->nome = $request->nome;
            $tipo->save();

            return $tipo;
        } catch (\Exception $e) {
            if($e->getCode() == 23000) {
                return response()->json(['message'=>"Preencha todas as informações"],400);
            }
        }
    }

    public function listar()
    {
        $tipos = Type_user::all();
        return $tipos;
    }
}
