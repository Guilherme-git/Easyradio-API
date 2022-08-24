<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function cadastrar(Request $request)
    {
        foreach ($request->perfil as $p) {
            $profile = new Profile();
            $profile->nome = $p['nome'];
            $profile->save();
        }

        return Profile::all();
    }

    public function listar()
    {
        return Profile::all();
    }
}
