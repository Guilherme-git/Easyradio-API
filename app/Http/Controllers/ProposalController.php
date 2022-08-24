<?php

namespace App\Http\Controllers;

use App\Models\Planning;
use App\Models\Proposal;
use App\Models\Proposal_refused;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    public function cadastrar(Request $request)
    {
        $plajamento = Planning::find($request->plajamento);
        $plajamento->status = $request->status;
        $plajamento->save();

        $proposal = new Proposal();
        $proposal->valor = $request->valor;
        $proposal->data = date("d-m-Y");
        $proposal->planning = $request->plajamento;
        $proposal->radio = $request->radio;
        $proposal->campaign = $plajamento->campaign;
        $proposal->save();

        return response()->json(["message"=>"Proposta enviada"]);
    }

    public function recusar(Request $request)
    {
        $plajamento = Planning::find($request->plajamento);
        $plajamento->status = $request->status;
        $plajamento->save();

        $proposal = new Proposal_refused();
        $proposal->descricao = $request->descricao;
        $proposal->data = date("d-m-Y");
        $proposal->radio = $request->radio;
        $proposal->planning = $request->plajamento;
        $proposal->campaign = $plajamento->campaign;
        $proposal->save();

        return response()->json(["message"=>"Proposta recusada"]);
    }

    public function listarPropostas(Request $request)
    {
        $propostas = Proposal::where('planning','=',$request->planejamento)
            ->with('radio')
            ->get();

        $propostas_recusadas = Proposal_refused::where('planning','=',$request->planejamento)
            ->with('radio')
            ->get();

        return  response()->json(['propostas_aceitas'=>$propostas,"propostas_recusadas"=>$propostas_recusadas]);
    }
}
