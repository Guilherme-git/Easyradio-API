<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EsqueciSenhaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/alterar-senha', function () {
    return view('form-alterar-senha');
});

Route::get('/senha-alterada', function () {
    return view('senha-alterada');
});

Route::get('captando-email',[EsqueciSenhaController::class, 'captandoEmail']);
Route::post('salvar-senha', [EsqueciSenhaController::class, 'alterarSenha']);
