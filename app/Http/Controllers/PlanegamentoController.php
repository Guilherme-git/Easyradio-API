<?php

namespace App\Http\Controllers;

use App\Models\Compaign_data;
use App\Models\Planning_hours_minuts;
use App\Models\Planning_hours_minuts_day;
use App\Models\Midia_kit;
use App\Models\Planning;
use App\Models\Planning_insertion;
use App\Models\Planning_insertion_dias_mes;
use App\Models\Planning_insertion_dias_mes_select;
use App\Models\Planning_period;
use App\Models\Radio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlanegamentoController extends Controller
{

    public function editar(Request $request)
    {
        $planejamento = Planning::find($request->id);

        $planejamento->spot_radio = $request->spot;
        $planejamento->radio = $request->radio;
        $planejamento->campaign = $request->campanha;
        $planejamento->volume = $request->volume;
        $planejamento->desconto = $request->desconto;
        $planejamento->total = $request->total;
        $planejamento->status = $request->status;
        $planejamento->save();

        $planegamento_period = Planning_period::where('planning', '=', $request->id)->get();
        $planegamento_period_delete = Planning_period::find($planegamento_period->get(0)->id);
        $planegamento_period_delete->delete();

        $planejamento_period = new Planning_period();
        $planejamento_period->startDate = $request->periodo['startDate'];
        $planejamento_period->endDate = $request->periodo['endDate'];
        $planejamento_period->planning = $planejamento->id;
        $planejamento_period->save();

        $horas_minutos_day_selecionado = Planning_hours_minuts_day::where('planning', $request->id)->get();

        foreach ($horas_minutos_day_selecionado as $hms) {
            $horas_minutos_day_selecionado_delete = Planning_hours_minuts_day::find($hms['id']);
            $horas_minutos_day_selecionado_delete->delete();

            $horas_minutos = Planning_hours_minuts::where('planning_hours_minuts_day', '=', $hms['id'])->get();
            foreach ($horas_minutos as $horas_minuto) {
                $horas_minutos_delete = Planning_hours_minuts::find($horas_minuto['id']);
                $horas_minutos_delete->delete();
            }
        }

        foreach ($request->hours_minutes_day as $key => $hmd) {

            $horas_minutos_day = new Planning_hours_minuts_day();
            $horas_minutos_day->ano = $hmd['ano'];
            $horas_minutos_day->dias = $hmd['dias'];
            $horas_minutos_day->insertion_selected = $hmd['insertion_selected'];
            $horas_minutos_day->mes = $hmd['mes'];
            $horas_minutos_day->planning = $request->id;
            $horas_minutos_day->save();

            foreach ($hmd['hours_minutes'] as $key => $hm) {
                $horas_minutos = new Planning_hours_minuts();
                $horas_minutos->value = $hm['value'];
                $horas_minutos->planning_hours_minuts_day = $horas_minutos_day->id;
                $horas_minutos->save();
            }
        }

        $planejamento_insert = Planning_insertion::where('planning', '=', $request->id)->get();

        foreach ($planejamento_insert as $pi)
        {
            $planejamento_insert_delete = Planning_insertion::find($pi['id']);
            $planejamento_insert_delete->delete();
        }

        foreach ($request->insertion as $i) {
            $planejamento_insert_new = new Planning_insertion();
            $planejamento_insert_new->mes = $i['mes'];
            $planejamento_insert_new->ano = $i['ano'];
            $planejamento_insert_new->planning = $planejamento->id;
            $planejamento_insert_new->save();

            foreach ($i['dias_mes'] as $key => $dm) {
                $planegamento_dias_mes = Planning_insertion_dias_mes::where('planning_insertion', '=', $planejamento_insert->get(0)->id)->get();

                foreach ($planegamento_dias_mes as $pdm)
                {
                    $planegamento_dias_mes_delete = Planning_insertion_dias_mes::find($pdm['id']);
                    $planegamento_dias_mes_delete->delete();
                }

                $planegamento_dias_mes = new Planning_insertion_dias_mes();
                $planegamento_dias_mes->value = $dm['value'];
                $planegamento_dias_mes->planning_insertion = $planejamento_insert_new->id;
                $planegamento_dias_mes->save();
            }
            foreach ($i['dias_mes_selecionados'] as $key => $dms) {
                $planejamento_dias_mes_selecionado = Planning_insertion_dias_mes_select::where('planning_insertion', '=', $planejamento_insert->get(0)->id)->get();

                foreach ($planejamento_dias_mes_selecionado as $pdms)
                {
                    $planejamento_dias_mes_selecionado_delete = Planning_insertion_dias_mes_select::find($pdms['id']);
                    $planejamento_dias_mes_selecionado_delete->delete();
                }

                $planejamento_dias_mes_selecionado = new Planning_insertion_dias_mes_select();
                $planejamento_dias_mes_selecionado->value = $dms['value'];
                $planejamento_dias_mes_selecionado->planning_insertion = $planejamento_insert_new->id;
                $planejamento_dias_mes_selecionado->save();
            }
        }

        $return = Planning::where('id', '=', $request->id)
            ->with('periodo')
            ->with('insertion')
            ->with('spot_radio.spot')
            ->with('hours_minutes_day')
            ->with('hours_minutes_day.hours_minutes')
            ->with('insertion.diasMes')
            ->with('insertion.diasMesSelecionados')
            ->get();

        return $return->get(0);
    }

    public function alterarStatus(Request $request)
    {
        $planejamento = Planning::find($request->id);
        $planejamento->status = $request->status;
        $planejamento->save();

        return response()->json(['message'=> "Status alterado"]);
    }
}
