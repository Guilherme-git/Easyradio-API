<?php

namespace App\Http\Controllers;

use App\Models\Auth_user;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $auth = Auth_user::where('nome_usuario', $request->nome_usuario)
            ->where('senha','=',md5($request->senha))
            ->with('auth_user_secundario')
            ->with('person_juridica')
            ->with('person_juridica.emissora_radio')
            ->with('person_juridica.emissora_radio.midia_kit')
            ->with('person_juridica.emissora_radio.profile')
            ->with('person_juridica.emissora_radio.spot_radio')
            ->with('person_juridica.emissora_radio.reach_radio.city')
            ->with('person_juridica.emissora_radio.reach_radio.city.state')
            ->with('person_juridica.agencia')
            ->with('person_juridica.empresa_anuciante')
            ->with('person_fisica')
            ->with('type_user')
            ->get();

        if(count($auth) > 0)
        {
            return $auth->get(0);
        } else {
            return response()->json(['message'=>"Usuário ou senha incorretos"],400);
        }


    }
}
