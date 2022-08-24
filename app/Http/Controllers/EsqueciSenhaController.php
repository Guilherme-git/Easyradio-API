<?php

namespace App\Http\Controllers;

use App\Models\Auth_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;


class EsqueciSenhaController extends Controller
{
    public function enviarEmail(Request $request)
    {
        $auth_user = Auth_user::where('email','=',$request->email)->get();

       if(count($auth_user) > 0)
       {
           session()->put('email', $request->email);
           Mail::send('alterar-senha-email', ["email" => "$request->email"], function ($e) {
               $e->from('envio@contetecnologia.com.br', 'Easy Rádio');
               $e->subject("Alterar sua senha");
               $e->to(session()->get('email'));
           });

           return response()->json(['message' => 'Email enviado']);
       } else {
           return response()->json(['message'=>"Email não encontrado"],400);
       }
    }

    public function captandoEmail(Request $request)
    {
        session()->put('email', $request->email);
        return Redirect::to('/alterar-senha');
    }

    public function alterarSenha(Request $request)
    {
        $auth_user = Auth_user::where('email','=',session()->get('email'))->get();
        $auth_user->get(0)->senha = md5($request->nova_senha);
        $auth_user->get(0)->save();

        if($auth_user->get(0)->save())
        {
            return Redirect::to('senha-alterada');
        }
    }
}
