<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\Tipo_usuarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SpotController;
use App\Http\Controllers\CampanhaController;
use App\Http\Controllers\RadioController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\PlanegamentoController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\EsqueciSenhaController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login',[AuthController::class,'login']);
Route::post('cadastro',[CadastroController::class,'cadastro']);
Route::put('editar',[CadastroController::class,'editar']);
Route::delete('remover-secundario/{id}',[CadastroController::class,'remover']);
Route::post('esqueci-senha',[EsqueciSenhaController::class, 'enviarEmail']);

Route::prefix('tipo-usuario')->group(function (){
    Route::post('cadastrar', [Tipo_usuarioController::class, 'cadastrar']);
    Route::get('listar', [Tipo_usuarioController::class, 'listar']);
});

Route::prefix('spot')->group(function (){
    Route::post('cadastrar', [SpotController::class, 'cadastrar']);
    Route::get('listar', [SpotController::class, 'listar']);
});

Route::prefix('radio')->group(function (){
    Route::get('listar',[RadioController::class, 'listar']);
});

Route::prefix('campanha')->group(function (){
    Route::post('cadastrar',[CampanhaController::class, 'cadastrar']);
    Route::put('editar/{id}',[CampanhaController::class, 'editar']);
    Route::get('mostrar/{id}',[CampanhaController::class, 'mostrar']);
    Route::get('listar-campanha-radio',[CampanhaController::class, 'listarCampanhaRadio']);
    Route::get('minhas-campanhas/{auth_user}',[CampanhaController::class, 'minhasCampanhas']);
    Route::get('listar-informacoes',[CampanhaController::class, 'listarInformacoes']);
    Route::post('upload-pdf',[CampanhaController::class, 'uplaodPDF']);
    Route::post('upload-spot',[CampanhaController::class, 'uplaodSPOT']);
    Route::delete('delete/{id}',[CampanhaController::class, 'delete']);
    Route::put('alterar-status',[CampanhaController::class, 'alterarStatus']);
});

Route::prefix('perfil')->group(function (){
    Route::post('cadastrar',[PerfilController::class, 'cadastrar']);
    Route::get('listar',[PerfilController::class, 'listar']);
});

Route::prefix('proposta')->group(function (){
    Route::post('cadastrar',[ProposalController::class, 'cadastrar']);
    Route::post('recusar',[ProposalController::class, 'recusar']);
    Route::get('listar',[ProposalController::class, 'listarPropostas']);
});

Route::prefix('cidade')->group(function (){
    Route::post('cadastrar',[CidadeController::class, 'cadastrar']);
    Route::get('listar',[CidadeController::class, 'listar']);
});

Route::prefix('estado')->group(function (){
    Route::post('cadastrar',[EstadoController::class, 'cadastrar']);
    Route::get('listar',[EstadoController::class, 'listar']);
});

Route::prefix('planejamento')->group(function (){
    Route::put('editar/{id}',[PlanegamentoController::class, 'editar']);
    Route::put('alterar-status/{id}',[PlanegamentoController::class, 'alterarStatus']);
});

