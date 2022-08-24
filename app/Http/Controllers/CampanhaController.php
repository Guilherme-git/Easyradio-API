<?php

namespace App\Http\Controllers;

use App\Models\Auth_user;
use App\Models\City;
use App\Models\Compaign;
use App\Models\Compaign_clients;
use App\Models\Compaign_data;
use App\Models\Compaign_uload_pdf;
use App\Models\Compaign_uload_spot;
use App\Models\Person_fisica;
use App\Models\Person_juridica;
use App\Models\Planning;
use App\Models\Planning_hours_minuts;
use App\Models\Planning_hours_minuts_day;
use App\Models\Planning_insertion;
use App\Models\Planning_insertion_dias_mes;
use App\Models\Planning_insertion_dias_mes_select;
use App\Models\Planning_period;
use App\Models\Profile;
use App\Models\Proposal;
use App\Models\Radio;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CampanhaController extends Controller
{
    public function cadastrar(Request $request)
    {
        $auth_user = Auth_user::find($request->auth_user);

        try {
            $campanha = new Compaign();
            $campanha->nome = $request->nome;
            $campanha->orcamento = $request->orcamento;
            $campanha->status = $request->status;
            $campanha->duracao = $request->duracao;
            $campanha->total_gasto = $request->total_gasto;
            $campanha->localizacao = $request->localizacao;
            if($auth_user->nivel == 'Master')
            {
                $campanha->auth_user = $auth_user->id;
            } else {
                $campanha->auth_user = $auth_user->auth_user_master;
            }
            $campanha->save();

            foreach ($request->clientes as $cl) {
                $campanha_clientes = new Compaign_clients();
                $campanha_clientes->nome = $cl['nome'];
                $campanha_clientes->person = $cl['person'];
                $campanha_clientes->cpf_cnpj = $cl['cpf_cnpj'];
                $campanha_clientes->selected = $cl['selected'];
                $campanha_clientes->campaign = $campanha->id;
                $campanha_clientes->save();
            }

            foreach ($request->data as $dt) {
                $campanha_data = new Compaign_data();
                $campanha_data->estado = $dt['estado'];
                $campanha_data->cidade = $dt['cidade'];
                $campanha_data->perfil = $dt['perfil'];
                $campanha_data->radio_id = $dt['radio'];
                $campanha_data->campaign = $campanha->id;
                $campanha_data->save();

                $planejamento = new Planning();
                $planejamento->radio = $dt['radio'];
                $planejamento->campaign = $campanha->id;
                $planejamento->save();

                $planejamento_period = new Planning_period();
                $planejamento_period->planning = $planejamento->id;
                $planejamento_period->save();

                $planejamento_insert = new Planning_insertion();
                $planejamento_insert->planning = $planejamento->id;
                $planejamento_insert->save();

                $planegamento_dias_mes = new Planning_insertion_dias_mes();
                $planegamento_dias_mes->planning_insertion = $planejamento_insert->id;
                $planegamento_dias_mes->save();

                $planejamento_dias_mes_selecionado = new Planning_insertion_dias_mes_select();
                $planejamento_dias_mes_selecionado->planning_insertion = $planejamento_insert->id;
                $planejamento_dias_mes_selecionado->save();

                $horas_minutos_day = new Planning_hours_minuts_day();
                $horas_minutos_day->planning = $planejamento->id;
                $horas_minutos_day->save();

                $horas_minutos = new Planning_hours_minuts();
                $horas_minutos->planning_hours_minuts_day = $horas_minutos_day->id;
                $horas_minutos->save();
            }

            $return = Compaign::where('id','=',$campanha->id)
                ->with('clientes')
                ->with('data')
                ->with('data.radio')
                ->with('data.radio.person_juridica')
                ->with('data.radio.midia_kit')
                ->with('data.radio.profile')
                ->with('data.radio.planejamento')
                ->with('data.radio.planejamento.spot_radio.spot')
                ->with('data.radio.planejamento.periodo')
                ->with('data.radio.planejamento.hours_minutes_day')
                ->with('data.radio.planejamento.hours_minutes_day.hours_minutes')
                ->with('data.radio.planejamento.insertion')
                ->with('data.radio.planejamento.insertion.diasMes')
                ->with('data.radio.planejamento.insertion.diasMesSelecionados')
                ->with('data.radio.spot_radio')
                ->with('data.radio.spot_radio.spot')
                ->with('data.radio.reach_radio.city')
                ->with('data.radio.reach_radio.city.state')
                ->get();

            return $return->get(0);

        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage()],400) ;
        }
    }

    public function minhasCampanhas(Request $request)
    {
        $auth_user = Auth_user::find($request->auth_user);

        if($auth_user->nivel == 'Master')
        {
            $campanhas = Compaign::where('auth_user','=',$auth_user->id)->get();
        } else {
            $campanhas = Compaign::where('auth_user','=',$auth_user->auth_user_master)->get();
        }


        $array_return = [];

        foreach ($campanhas as $c)
        {
            session()->put('compaign',$c['id']);

            $return = Compaign::where('id','=',$c['id'])
                ->with('clientes')
                ->with('upload_pdf')
                ->with('upload_spot')
                ->with('data')
                ->with('data.radio')
                ->with('data.radio.person_juridica')
                ->with('data.radio.planejamento')
                ->with('data.radio.proposta')
                ->with('data.radio.proposta_recusada')
                ->with('data.radio.planejamento')
                ->with('data.radio.planejamento.spot_radio.spot')
                ->with('data.radio.planejamento.periodo')
                ->with('data.radio.planejamento.hours_minutes_day')
                ->with('data.radio.planejamento.hours_minutes_day.hours_minutes')
                ->with('data.radio.planejamento.insertion')
                ->with('data.radio.planejamento.insertion.diasMes')
                ->with('data.radio.planejamento.insertion.diasMesSelecionados')
                ->with('data.radio.midia_kit')
                ->with('data.radio.profile')
                ->with('data.radio.spot_radio')
                ->with('data.radio.spot_radio.spot')
                ->with('data.radio.reach_radio.city')
                ->with('data.radio.reach_radio.city.state')
                ->get();

            foreach ($return as $r)
            {
                array_push($array_return, [
                    "id"=>$r['id'],
                    "nome"=>$r['nome'],
                    "orcamento"=>$r['orcamento'],
                    "status"=>$r['status'],
                    "duracao"=>$r['duracao'],
                    "total_gasto"=>$r['total_gasto'],
                    "localizacao"=>$r['localizacao'],
                    "auth_user"=>$r['auth_user'],
                    "upload_pdf" => $r['upload_pdf'],
                    "upload_spot" => $r['upload_spot'],
                    "clientes"=> $r['clientes'],
                    "data"=> $r['data']
                ]);
            }
        }

        session()->forget('compaign');

        return $array_return;
    }

    public function listarInformacoes()
    {
        return response()->json([
            "estados" => State::all(),
            "cidades" => City::all(),
            "perfis" => Profile::all(),
            "radios" => Radio::with('reach_radio.city.state')->get()
        ]);
    }

    public function editar(Request $request)
    {
        $auth_user = Auth_user::find($request->auth_user);
        try {
            $campanha = Compaign::find($request->id);
            $campanha->nome = $request->nome;
            $campanha->orcamento = $request->orcamento;
            $campanha->status = $request->status;
            $campanha->duracao = $request->duracao;
            $campanha->total_gasto = $request->total_gasto;
            $campanha->localizacao = $request->localizacao;
            if($auth_user->nivel == 'Master')
            {
                $campanha->auth_user = $auth_user->id;
            } else {
                $campanha->auth_user = $auth_user->auth_user_master;
            }
            $campanha->save();

            $campanha_clientes = Compaign_clients::where('campaign','=',$request->id)->get();
            $campanha_data = Compaign_data::where('campaign','=',$request->id)->get();

            foreach ($campanha_clientes as $campanha_delete_clientes) {
                $campanhaDelete = Compaign_clients::find($campanha_delete_clientes->id);
                $campanhaDelete->delete();
            }

            foreach ($campanha_data as $campanha_delete_data) {
                $campanhaDelete = Compaign_data::find($campanha_delete_data->id);
                $campanhaDelete->delete();
            }

            foreach ($request->clientes as $cl) {
                $campanha_clientes = new Compaign_clients();
                $campanha_clientes->nome = $cl['nome'];
                $campanha_clientes->person = $cl['person'];
                $campanha_clientes->cpf_cnpj = $cl['cpf_cnpj'];
                $campanha_clientes->selected = $cl['selected'];
                $campanha_clientes->campaign = $request->id;
                $campanha_clientes->save();
            }

            foreach ($request->data as $dt) {
                $campanha_data = new Compaign_data();
                $campanha_data->estado = $dt['estado'];
                $campanha_data->cidade = $dt['cidade'];
                $campanha_data->perfil = $dt['perfil'];
                $campanha_data->radio_id = $dt['radio'];
                $campanha_data->campaign = $request->id;
                $campanha_data->save();

                $planejamento = Planning::where('radio','=',$dt['radio'])->get();

                if(count($planejamento) == 0)
                {
                    $planejamento = new Planning();
                    $planejamento->radio = $dt['radio'];
                    $planejamento->campaign = $campanha->id;
                    $planejamento->save();

                    $planejamento_period = new Planning_period();
                    $planejamento_period->planning = $planejamento->id;
                    $planejamento_period->save();

                    $planejamento_insert = new Planning_insertion();
                    $planejamento_insert->planning = $planejamento->id;
                    $planejamento_insert->save();

                    $planegamento_dias_mes = new Planning_insertion_dias_mes();
                    $planegamento_dias_mes->planning_insertion = $planejamento_insert->id;
                    $planegamento_dias_mes->save();

                    $planejamento_dias_mes_selecionado = new Planning_insertion_dias_mes_select();
                    $planejamento_dias_mes_selecionado->planning_insertion = $planejamento_insert->id;
                    $planejamento_dias_mes_selecionado->save();

                    $horas_minutos_day = new Planning_hours_minuts_day();
                    $horas_minutos_day->planning = $planejamento->id;
                    $horas_minutos_day->save();

                    $horas_minutos = new Planning_hours_minuts();
                    $horas_minutos->planning_hours_minuts_day = $horas_minutos_day->id;
                    $horas_minutos->save();
                }
            }

            $return = Compaign::where('id','=',$request->id)
                ->with('clientes')
                ->with('data')
                ->with('data.radio')
                ->with('data.radio.person_juridica')
                ->with('data.radio.midia_kit')
                ->with('data.radio.profile')
                ->with('data.radio.planejamento')
                ->with('data.radio.planejamento.hours_minutes_day')
                ->with('data.radio.planejamento.hours_minutes_day.hours_minutes')
                ->with('data.radio.planejamento.spot_radio.spot')
                ->with('data.radio.planejamento.periodo')
                ->with('data.radio.planejamento.insertion')
                ->with('data.radio.planejamento.insertion.diasMes')
                ->with('data.radio.planejamento.insertion.diasMesSelecionados')
                ->with('data.radio.spot_radio')
                ->with('data.radio.spot_radio.spot')
                ->with('data.radio.reach_radio.city')
                ->with('data.radio.reach_radio.city.state')
                ->get();

            return $return->get(0);

        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage()],400) ;
        }
    }

    public function mostrar(Request $request)
    {
        session()->put('compaign',$request->id);

        $return = Compaign::where('id','=',$request->id)
            ->with('clientes')
            ->with('upload_pdf')
            ->with('upload_spot')
            ->with('data')
            ->with('data.radio')
            ->with('data.radio.planejamento')
            ->with('data.radio.proposta')
            ->with('data.radio.proposta_recusada')
            ->with('data.radio.person_juridica')
            ->with('data.radio.planejamento.spot_radio.spot')
            ->with('data.radio.planejamento.periodo')
            ->with('data.radio.planejamento.hours_minutes_day')
            ->with('data.radio.planejamento.hours_minutes_day.hours_minutes')
            ->with('data.radio.planejamento.insertion')
            ->with('data.radio.planejamento.insertion.diasMes')
            ->with('data.radio.planejamento.insertion.diasMesSelecionados')
            ->with('data.radio.midia_kit')
            ->with('data.radio.profile')
            ->with('data.radio.spot_radio')
            ->with('data.radio.spot_radio.spot')
            ->with('data.radio.reach_radio.city')
            ->with('data.radio.reach_radio.city.state')
            ->get();


        session()->forget('compaign');

        return $return->get(0);
    }

    public function uplaodPDF(Request $request)
    {
        $upload = new Compaign_uload_pdf();

        $base64 = $request->base64;

        //obtem a extensão
        $extension = explode('/', $base64);
        $extension = explode(';', $extension[1]);
        $extension = '.' . $extension[0];

        //gera o nome
        $name = time() . $extension;

        //obtem o arquivo
        $separatorFile = explode(',', $base64);
        $file = $separatorFile[1];
        $path = 'compaign_upload_pdf';

        //envia o arquivo
        Storage::put("$path/$path.$name", base64_decode($file));
        $upload->upload = "$path/$path.$name";
        $upload->campaign = $request->campanha;
        $upload->save();

        return response()->json(['message'=>"Sucesso"]);
    }

    public function uplaodSPOT(Request $request)
    {
        $upload = new Compaign_uload_spot();

        $base64 = $request->base64;

        //obtem a extensão
        $extension = explode('/', $base64);
        $extension = explode(';', $extension[1]);
        $extension = '.' . $extension[0];

        //gera o nome
        $name = time() . $extension;

        //obtem o arquivo
        $separatorFile = explode(',', $base64);
        $file = $separatorFile[1];
        $path = 'compaign_upload_spot';

        //envia o arquivo
        Storage::put("$path/$path.$name", base64_decode($file));
        $upload->upload = "$path/$path.$name";
        $upload->campaign = $request->campanha;
        $upload->save();

        return response()->json(['message'=>"Sucesso"]);
    }

    public function delete(Request $request)
    {
        $campanha_data = Compaign_data::find($request->id);
        $campanha_data->delete();

        return response()->json(['message'=>"Deletado"]);
    }

    public function listarCampanhaRadio(Request $request)
    {
        session()->forget('radio');

        $array_return = [];

        $return = Compaign_data::where('radio_id','=',$request->radio)
//            ->with('campanha')
//            ->with('campanha.clientes')
//            ->with('campanha.auth_user')
//            ->with('radio')
//            ->with('radio.person_juridica')
//            ->with('radio.midia_kit')
//            ->with('radio.profile')
//            ->with('radio.proposta')
//            ->with('radio.proposta_recusada')
//            ->with('radio.planejamento')
//            ->with('radio.planejamento.hours_minutes_day')
//            ->with('radio.planejamento.hours_minutes_day.hours_minutes')
//            ->with('radio.planejamento.spot_radio.spot')
//            ->with('radio.planejamento.periodo')
//            ->with('radio.planejamento.insertion')
//            ->with('radio.planejamento.insertion.diasMes')
//            ->with('radio.planejamento.insertion.diasMesSelecionados')
//            ->with('radio.spot_radio')
//            ->with('radio.spot_radio.spot')
//            ->with('radio.reach_radio.city')
//            ->with('radio.reach_radio.city.state')
            ->get();


        foreach ($return as $r)
        {
            session()->put('compaign',$r['campaign']);

            $campanhas = Compaign_data::where('id','=',$r['id'])
                ->with('campanha')
                ->with('campanha.clientes')
                ->with('campanha.auth_user')
                ->with('radio')
                ->with('radio.person_juridica')
                ->with('radio.midia_kit')
                ->with('radio.profile')
                ->with('radio.proposta')
                ->with('radio.proposta_recusada')
                ->with('radio.planejamento')
                ->with('radio.planejamento.hours_minutes_day')
                ->with('radio.planejamento.hours_minutes_day.hours_minutes')
                ->with('radio.planejamento.spot_radio')
                ->with('radio.planejamento.spot_radio.spot')
                ->with('radio.planejamento.periodo')
                ->with('radio.planejamento.insertion')
                ->with('radio.planejamento.insertion.diasMes')
                ->with('radio.planejamento.insertion.diasMesSelecionados')
                ->with('radio.spot_radio')
                ->with('radio.spot_radio.spot')
                ->with('radio.reach_radio.city')
                ->with('radio.reach_radio.city.state')
                ->get();

            foreach ($campanhas as $c)
            {

                array_push($array_return, [
                    "id" => $c['id'],
                    "estado" => $c['estado'],
                    "cidade" => $c['cidade'],
                    "perfil" => $c['perfil'],
                    "radio" => $c['radio'],
                    "campanha" => $c['campanha']
                ]);
            }
        }

        return $array_return;
    }

    public function alterarStatus(Request $request)
    {
        $campanha = Compaign::find($request->campanha);
        $campanha->status = $request->status;
        $campanha->save();

        $return = Compaign::where('id','=',$request->campanha)
            ->with('clientes')
            ->with('data')
            ->with('data.radio')
            ->with('data.radio.person_juridica')
            ->with('data.radio.midia_kit')
            ->with('data.radio.profile')
            ->with('data.radio.proposta')
            ->with('data.radio.proposta_recusada')
            ->with('data.radio.planejamento')
            ->with('data.radio.planejamento.hours_minutes_day')
            ->with('data.radio.planejamento.hours_minutes_day.hours_minutes')
            ->with('data.radio.planejamento.spot_radio.spot')
            ->with('data.radio.planejamento.periodo')
            ->with('data.radio.planejamento.insertion')
            ->with('data.radio.planejamento.insertion.diasMes')
            ->with('data.radio.planejamento.insertion.diasMesSelecionados')
            ->with('data.radio.spot_radio')
            ->with('data.radio.spot_radio.spot')
            ->with('data.radio.reach_radio.city')
            ->with('data.radio.reach_radio.city.state')
            ->get();

        return $return->get(0);
    }
}
