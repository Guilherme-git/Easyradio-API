<?php

namespace App\Http\Controllers;

use App\Models\Advertiser_company;
use App\Models\Advertiser_company_secundary;
use App\Models\Agency;
use App\Models\Agency_secundary;
use App\Models\Auth_user;
use App\Models\City;
use App\Models\Midia_kit;
use App\Models\Person_fisica;
use App\Models\Person_juridica;
use App\Models\Radio;
use App\Models\Radio_secundary;
use App\Models\Reach_radio;
use App\Models\Spot_radio;
use App\Models\State;
use App\Models\Type_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CadastroController extends Controller
{
    public function cadastro(Request $request)
    {
        $type_user = Type_user::find($request->type_user['id']);

        try {
            $auth_user_email = Auth_user::where('email', '=', $request->auth_user['email'])->get();
            $auth_user_nome_usuario = Auth_user::where('nome_usuario', '=', $request->auth_user['nome_usuario'])->get();

            if (count($auth_user_email) > 0) {
                return response()->json(['message' => "Esse email já está cadastrado"], 400);
            }
            if (count($auth_user_nome_usuario) > 0) {
                return response()->json(['message' => "Esse usuário já está cadastrado"], 400);
            }
            $auth_user = new Auth_user();
            $auth_user->senha = md5($request->auth_user['senha']);
            $auth_user->nome_usuario = $request->auth_user['nome_usuario'];
            $auth_user->nome = $request->auth_user['nome'];
            $auth_user->sobrenome = $request->auth_user['sobrenome'];
            $auth_user->email = $request->auth_user['email'];
            $auth_user->data_criacao = date('Y-m-d');
            $auth_user->type_user = $request->type_user['id'];
            $auth_user->nivel = 'Master';

            if ($type_user->nome == 'AGÊNCIA' || $type_user->nome == 'EMISSORA DE RÁDIO' || $type_user->nome == 'EMPRESA ANUNCIANTE') {
                $person_juridica = Person_juridica::where('cnpj', '=', $request->person_juridica['cnpj'])->get();

                if (count($person_juridica) > 0) {
                    return response()->json(['message' => 'Esse CNPJ já está cadastrado'], 400);
                } else {
                    $person_juridica = new Person_juridica();
                    $person_juridica->razao_social = $request->person_juridica['razao_social'];
                    $person_juridica->cnpj = $request->person_juridica['cnpj'];
                    $person_juridica->cep = $request->person_juridica['cep'];
                    $person_juridica->logradouro = $request->person_juridica['logradouro'];
                    $person_juridica->estado = $request->person_juridica['estado'];
                    $person_juridica->bairro = $request->person_juridica['bairro'];
                    $person_juridica->cidade = $request->person_juridica['cidade'];
                    $person_juridica->complemento = $request->person_juridica['complemento'];
                    $person_juridica->inscricao_municipal = $request->person_juridica['inscricao_municipal'];
                    $person_juridica->inscricao_estadual = $request->person_juridica['inscricao_estadual'];
                }

                if ($type_user->nome == 'AGÊNCIA') {
                    $agency = new Agency();
                    $agency->nome_fantasia = $request->registry_main['nome_fantasia'];
                    $agency->telefone_comercial = $request->registry_main['telefone_comercial'];
                    $agency->email_comercial = $request->registry_main['email_comercial'];
                    $agency->facebook = $request->registry_main['facebook'];
                    $agency->site = $request->registry_main['site'];
                    $agency->instagram = $request->registry_main['instagram'];

                    $base64 = $request->registry_main['logo'];
                    //obtem a extensão
                    $extension = explode('/', $base64);
                    $extension = explode(';', $extension[1]);
                    $extension = '.' . $extension[0];

                    //gera o nome
                    $name = time() . $extension;

                    //obtem o arquivo
                    $separatorFile = explode(',', $base64);
                    $file = $separatorFile[1];
                    $path = 'logo_agency';

                    //envia o arquivo
                    Storage::put("$path/$path.$name", base64_decode($file));
                    $agency->logo = "$path/$path.$name";
                }

                if ($type_user->nome == 'EMPRESA ANUNCIANTE') {
                    $advertiser_company = new Advertiser_company();
                    $advertiser_company->nome_fantasia = $request->registry_main['nome_fantasia'];
                    $advertiser_company->telefone_comercial = $request->registry_main['telefone_comercial'];
                    $advertiser_company->email_comercial = $request->registry_main['email_comercial'];
                    $advertiser_company->facebook = $request->registry_main['facebook'];
                    $advertiser_company->site = $request->registry_main['site'];
                    $advertiser_company->instagram = $request->registry_main['instagram'];

                    $base64 = $request->registry_main['logo'];
                    //obtem a extensão
                    $extension = explode('/', $base64);
                    $extension = explode(';', $extension[1]);
                    $extension = '.' . $extension[0];

                    //gera o nome
                    $name = time() . $extension;

                    //obtem o arquivo
                    $separatorFile = explode(',', $base64);
                    $file = $separatorFile[1];
                    $path = 'logo_advertiser_company';

                    //envia o arquivo
                    Storage::put("$path/$path.$name", base64_decode($file));
                    $advertiser_company->logo = "$path/$path.$name";
                }

                if ($type_user->nome == 'EMISSORA DE RÁDIO') {
                    $radio = new Radio();
                    $radio->nome_fantasia = $request->registry_main['nome_fantasia'];
                    $radio->dial = $request->registry_main['dial'];
                    $radio->fm_am = $request->registry_main['fm_am'];
                    $radio->concessao = $request->registry_main['concessao'];
                    $radio->telefone_comercial = $request->registry_main['telefone_comercial'];
                    $radio->email_comercial = $request->registry_main['email_comercial'];
                    $radio->facebook = $request->registry_main['facebook'];
                    $radio->site = $request->registry_main['site'];
                    $radio->instagram = $request->registry_main['instagram'];
                    $radio->descricao = $request->registry_main['descricao'];
                    $radio->data_criacao = date('Y-m-d');
                    $radio->preco = $request->registry_main['preco'];
                    $radio->profile = $request->registry_main['profile'];
                    $radio->instagram = $request->registry_main['instagram'];

                    //LOGO RADIO-----------------------------------------------------------
                    $base64 = $request->registry_main['logo'];
                    //obtem a extensão
                    $extension = explode('/', $base64);
                    $extension = explode(';', $extension[1]);
                    $extension = '.' . $extension[0];

                    //gera o nome
                    $name = time() . $extension;

                    //obtem o arquivo
                    $separatorFile = explode(',', $base64);
                    $file = $separatorFile[1];
                    $path = 'logo_radio';

                    //envia o arquivo
                    Storage::put("$path/$path.$name", base64_decode($file));
                    $radio->logo = "$path/$path.$name";
                    //---------------------------------------------------------------------
                }

                $person_juridica->save();

                $auth_user->person_juridica = $person_juridica->id;
                $auth_user->save();

                if ($type_user->nome == 'AGÊNCIA') {
                    $agency->person_juridica = $person_juridica->id;
                    $agency->save();

                    if (count($request->registry_secundary) > 0) {
                        foreach ($request->registry_secundary as $rs)
                        {
                            $auth_user_secundary = new Auth_user();
                            $auth_user_secundary->senha = md5($rs['senha']);
                            $auth_user_secundary->nome_usuario = $rs['nome_usuario'];
                            $auth_user_secundary->nome = $rs['nome'];
                            $auth_user_secundary->sobrenome = $rs['sobrenome'];
                            $auth_user_secundary->cpf = $rs['cpf'];
                            $auth_user_secundary->email = $rs['email'];
                            $auth_user_secundary->data_criacao = date('Y-m-d');
                            $auth_user_secundary->type_user = $request->type_user['id'];
                            $auth_user_secundary->auth_user_master = $auth_user->id;
                            $auth_user_secundary->person_juridica = $person_juridica->id;
                            $auth_user_secundary->nivel = 'Secundario';
                            $auth_user_secundary->save();
                        }
                    }
                }
                if ($type_user->nome == 'EMPRESA ANUNCIANTE') {
                    $advertiser_company->person_juridica = $person_juridica->id;
                    $advertiser_company->save();

                    if (count($request->registry_secundary) > 0) {
                        foreach ($request->registry_secundary as $rs)
                        {
                            $auth_user_secundary = new Auth_user();
                            $auth_user_secundary->senha = md5($rs['senha']);
                            $auth_user_secundary->nome_usuario = $rs['nome_usuario'];
                            $auth_user_secundary->nome = $rs['nome'];
                            $auth_user_secundary->sobrenome = $rs['sobrenome'];
                            $auth_user_secundary->cpf = $rs['cpf'];
                            $auth_user_secundary->email = $rs['email'];
                            $auth_user_secundary->data_criacao = date('Y-m-d');
                            $auth_user_secundary->type_user = $request->type_user['id'];
                            $auth_user_secundary->auth_user_master = $auth_user->id;
                            $auth_user_secundary->person_juridica = $person_juridica->id;
                            $auth_user_secundary->nivel = 'Secundario';
                            $auth_user_secundary->save();
                        }
                    }
                }
                if ($type_user->nome == 'EMISSORA DE RÁDIO') {
                    $radio->person_juridica = $person_juridica->id;
                    $radio->save();

                    if (count($request->registry_secundary) > 0) {
                        foreach ($request->registry_secundary as $rs)
                        {
                            $auth_user_secundary = new Auth_user();
                            $auth_user_secundary->senha = md5($rs['senha']);
                            $auth_user_secundary->nome_usuario = $rs['nome_usuario'];
                            $auth_user_secundary->nome = $rs['nome'];
                            $auth_user_secundary->sobrenome = $rs['sobrenome'];
                            $auth_user_secundary->cpf = $rs['cpf'];
                            $auth_user_secundary->email = $rs['email'];
                            $auth_user_secundary->data_criacao = date('Y-m-d');
                            $auth_user_secundary->type_user = $request->type_user['id'];
                            $auth_user_secundary->auth_user_master = $auth_user->id;
                            $auth_user_secundary->person_juridica = $person_juridica->id;
                            $auth_user_secundary->nivel = 'Secundario';
                            $auth_user_secundary->save();
                        }
                    }

                    foreach ($request->spot_radio as $sr) {
                        $spot_radio = new Spot_radio();
                        $spot_radio->spot = $sr['spot'];
                        $spot_radio->horario = $sr['horario'];
                        $spot_radio->valor = $sr['valor'];
                        $spot_radio->radio = $radio->id;
                        $spot_radio->save();
                    }


                    foreach ($request->registry_main['alcance'] as $al) {
                        $city = City::where('nome','=',$al['city'])->get();
                        $state = State::where('nome','=',$al['state'])->get();

                        if(count($state) > 0)
                        {
                            if(count($city) > 0)
                            {
                                $alcance_radio = new Reach_radio();
                                $alcance_radio->city = $city->get(0)->id;
                                $alcance_radio->radio = $radio->id;
                                $alcance_radio->save();
                            } else {
                                $city = new City();
                                $city->nome = $al['city'];
                                $city->state = $state->get(0)->id;
                                $city->save();

                                $alcance_radio = new Reach_radio();
                                $alcance_radio->city = $city->id;
                                $alcance_radio->radio = $radio->id;
                                $alcance_radio->save();
                            }
                        } else {
                            $state = new State();
                            $state->nome = $al['state'];
                            $state->save();

                            if(count($city) > 0)
                            {
                                $alcance_radio = new Reach_radio();
                                $alcance_radio->city = $city->get(0)->id;
                                $alcance_radio->radio = $radio->id;
                                $alcance_radio->save();
                            } else {
                                $city = new City();
                                $city->nome = $al['city'];
                                $city->state = $state->id;
                                $city->save();

                                $alcance_radio = new Reach_radio();
                                $alcance_radio->city = $city->id;
                                $alcance_radio->radio = $radio->id;
                                $alcance_radio->save();
                            }
                        }
                    }

                    foreach ($request->registry_main['midia_kit'] as $key => $m) {
                        $midia_kit = new Midia_kit();

                        //MIDIA RADIO----------------------------------------------------------
                        $base64 = $m['midia'];

                        //obtem a extensão
                        $extension = explode('/', $base64);
                        $extension = explode(';', $extension[1]);
                        $extension = '.' . $extension[0];

                        //gera o nome
                        $name = time() . $key . $extension;

                        //obtem o arquivo
                        $separatorFile = explode(',', $base64);
                        $file = $separatorFile[1];
                        $path = 'midia_kit_radio';

                        //envia o arquivo
                        Storage::put("$path/$path.$name", base64_decode($file));
                        $midia_kit->midia_kit = "$path/$path.$name";
                        $midia_kit->radio = $radio->id;
                        $midia_kit->save();
                        //---------------------------------------------------------------------
                    }
                }

                $auth = Auth_user::where('nome_usuario', $request->auth_user['nome_usuario'])
                    ->where('senha', '=', md5($request->auth_user['senha']))
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

                return $auth->get(0);
            } else {
                $person_fisica = Person_fisica::where('cpf', '=', $request->person_fisica['cpf'])->get();

                if (count($person_fisica) > 0) {
                    return response()->json(['message' => 'Esse CPF já está cadastrado'], 400);
                } else {
                    $person_fisica = new Person_fisica();
                    $person_fisica->cpf = $request->person_fisica['cpf'];

                    $auth_user->save();

                    $person_fisica->auth_user = $auth_user->id;
                    $person_fisica->save();
                }


                $auth = Auth_user::where('nome_usuario', $request->auth_user['nome_usuario'])
                    ->where('senha', '=', md5($request->auth_user['senha']))
                    ->with('auth_user_secundario')
                    ->with('person_juridica')
                    ->with('person_juridica.emissora_radio')
                    ->with('person_juridica.emissora_radio.midia_kit')
                    ->with('person_juridica.emissora_radio.profile')
                    ->with('person_juridica.emissora_radio.reach_radio.city')
                    ->with('person_juridica.emissora_radio.reach_radio.city.state')
                    ->with('person_juridica.agencia')
                    ->with('person_juridica.empresa_anuciante')
                    ->with('person_fisica')
                    ->with('type_user')
                    ->get();

                return $auth->get(0);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
//            if ($e->getCode() == 0) {
//                return response()->json(['message' => "Informações incorretas presentes na requisição", "full_message" => $e->getMessage()], 400);
//            }
//            if ($e->getCode() == 23000) {
//                return response()->json(['message' => "Preencha as informações obrigatórias", "full_message" => $e->getMessage()], 400);
//            }
        }
    }

    public function editar(Request $request)
    {
        $type_user = Type_user::find($request->type_user['id']);

        try {
            $auth_user_email = Auth_user::where('email', '=', $request->auth_user['email'])
                ->where('id', '!=', $request->auth_user['auth_user'])
                ->get();

            $auth_user_nome_usuario = Auth_user::where('nome_usuario', '=', $request->auth_user['nome_usuario'])
                ->where('id', '!=', $request->auth_user['auth_user'])
                ->get();

            if (count($auth_user_email) > 0) {
                return response()->json(['message' => "Esse email já está cadastrado"], 400);
            }
            if (count($auth_user_nome_usuario) > 0) {
                return response()->json(['message' => "Esse usuário já está cadastrado"], 400);
            }

            $auth_user = Auth_user::find($request->auth_user['auth_user']);
            $auth_user->nome = $request->auth_user['nome'];
            $auth_user->nome_usuario = $request->auth_user['nome_usuario'];
            $auth_user->sobrenome = $request->auth_user['sobrenome'];
            $auth_user->email = $request->auth_user['email'];
            if($request->auth_user['senha']){
                $auth_user->senha = md5($request->auth_user['senha']) ;
            }
            $auth_user->save();

            if ($type_user->nome == 'AGÊNCIA' || $type_user->nome == 'EMISSORA DE RÁDIO' || $type_user->nome == 'EMPRESA ANUNCIANTE') {
                //$person_juridica = Person_juridica::where('auth_user', '=', $request->auth_user['auth_user'])->get();
                $person_juridica_cnpj = Person_juridica::where('cnpj', '=', $request->person_juridica['cnpj'])->get();

                if (count($person_juridica_cnpj) == 0) {
                   // $person_juridica_edit = Person_juridica::find($person_juridica->get(0)->id);
                    $person_juridica_edit = Person_juridica::find($auth_user->person_juridica);
                    $person_juridica_edit->razao_social = $request->person_juridica['razao_social'];
                    $person_juridica_edit->cnpj = $request->person_juridica['cnpj'];
                    $person_juridica_edit->cep = $request->person_juridica['cep'];
                    $person_juridica_edit->logradouro = $request->person_juridica['logradouro'];
                    $person_juridica_edit->estado = $request->person_juridica['estado'];
                    $person_juridica_edit->bairro = $request->person_juridica['bairro'];
                    $person_juridica_edit->cidade = $request->person_juridica['cidade'];
                    $person_juridica_edit->complemento = $request->person_juridica['complemento'];
                    $person_juridica_edit->inscricao_municipal = $request->person_juridica['inscricao_municipal'];
                    $person_juridica_edit->inscricao_estadual = $request->person_juridica['inscricao_estadual'];
                    $person_juridica_edit->save();

                    if ($type_user->nome == 'AGÊNCIA') {
                       // $agency = Agency::where('person_juridica', '=', $person_juridica->get(0)->id)->get();
                        $agency = Agency::where('person_juridica', '=', $auth_user->person_juridica)->get();

                        $agency->get(0)->nome_fantasia = $request->registry_main['nome_fantasia'];
                        $agency->get(0)->telefone_comercial = $request->registry_main['telefone_comercial'];
                        $agency->get(0)->email_comercial = $request->registry_main['email_comercial'];
                        $agency->get(0)->facebook = $request->registry_main['facebook'];
                        $agency->get(0)->site = $request->registry_main['site'];
                        $agency->get(0)->instagram = $request->registry_main['instagram'];

                        if ($request->registry_main['logo']) {
                            Storage::delete($agency->get(0)->logo);

                            $base64 = $request->registry_main['logo'];
                            //obtem a extensão
                            $extension = explode('/', $base64);
                            $extension = explode(';', $extension[1]);
                            $extension = '.' . $extension[0];

                            //gera o nome
                            $name = time() . $extension;

                            //obtem o arquivo
                            $separatorFile = explode(',', $base64);
                            $file = $separatorFile[1];
                            $path = 'logo_advertiser_company';

                            //envia o arquivo
                            Storage::put("$path/$path.$name", base64_decode($file));
                            $agency->get(0)->logo = "$path/$path.$name";
                        }
                        $agency->get(0)->save();

                        if (count($request->registry_secundary) > 0) {
//                            $auth_secundary = Auth_user::where('auth_user_master','=',$request->auth_user['auth_user'])->get();
//
//                            foreach ($auth_secundary as $as)
//                            {
//                                $auth_secundary_delete = Auth_user::find($as['id']);
//                                $auth_secundary_delete->delete();
//                            }

                            foreach ($request->registry_secundary as $rs)
                            {
                                $auth_user_secundary = new Auth_user();
                                $auth_user_secundary->senha = md5($rs['senha']);
                                $auth_user_secundary->nome_usuario = $rs['nome_usuario'];
                                $auth_user_secundary->nome = $rs['nome'];
                                $auth_user_secundary->sobrenome = $rs['sobrenome'];
                                $auth_user_secundary->cpf = $rs['cpf'];
                                $auth_user_secundary->email = $rs['email'];
                                $auth_user_secundary->data_criacao = date('Y-m-d');
                                $auth_user_secundary->type_user = $request->type_user['id'];
                                $auth_user_secundary->auth_user_master = $auth_user->id;
                                $auth_user_secundary->person_juridica = $auth_user->person_juridica;
                                $auth_user_secundary->nivel = 'Secundario';
                                $auth_user_secundary->save();
                            }
                        }
                    }

                    if ($type_user->nome == 'EMPRESA ANUNCIANTE') {
                        //$advertiser_company = Advertiser_company::where('person_juridica', '=', $person_juridica->get(0)->id)->get();
                        $advertiser_company = Advertiser_company::where('person_juridica', '=', $auth_user->person_juridica)->get();

                        $advertiser_company->get(0)->nome_fantasia = $request->registry_main['nome_fantasia'];
                        $advertiser_company->get(0)->telefone_comercial = $request->registry_main['telefone_comercial'];
                        $advertiser_company->get(0)->email_comercial = $request->registry_main['email_comercial'];
                        $advertiser_company->get(0)->facebook = $request->registry_main['facebook'];
                        $advertiser_company->get(0)->site = $request->registry_main['site'];
                        $advertiser_company->get(0)->instagram = $request->registry_main['instagram'];

                        if ($request->registry_main['logo']) {
                            Storage::delete($advertiser_company->get(0)->logo);

                            $base64 = $request->registry_main['logo'];
                            //obtem a extensão
                            $extension = explode('/', $base64);
                            $extension = explode(';', $extension[1]);
                            $extension = '.' . $extension[0];

                            //gera o nome
                            $name = time() . $extension;

                            //obtem o arquivo
                            $separatorFile = explode(',', $base64);
                            $file = $separatorFile[1];
                            $path = 'logo_advertiser_company';

                            //envia o arquivo
                            Storage::put("$path/$path.$name", base64_decode($file));
                            $advertiser_company->get(0)->logo = "$path/$path.$name";
                        }

                        $advertiser_company->get(0)->save();

                        if (count($request->registry_secundary) > 0) {
//                            $auth_secundary = Auth_user::where('auth_user_master','=',$request->auth_user['auth_user'])->get();
//
//                            foreach ($auth_secundary as $as)
//                            {
//                                $auth_secundary_delete = Auth_user::find($as['id']);
//                                $auth_secundary_delete->delete();
//                            }

                            foreach ($request->registry_secundary as $rs)
                            {
                                $auth_user_secundary = new Auth_user();
                                $auth_user_secundary->senha = md5($rs['senha']);
                                $auth_user_secundary->nome_usuario = $rs['nome_usuario'];
                                $auth_user_secundary->nome = $rs['nome'];
                                $auth_user_secundary->sobrenome = $rs['sobrenome'];
                                $auth_user_secundary->cpf = $rs['cpf'];
                                $auth_user_secundary->email = $rs['email'];
                                $auth_user_secundary->data_criacao = date('Y-m-d');
                                $auth_user_secundary->type_user = $request->type_user['id'];
                                $auth_user_secundary->auth_user_master = $auth_user->id;
                                $auth_user_secundary->person_juridica = $auth_user->person_juridica;
                                $auth_user_secundary->nivel = 'Secundario';
                                $auth_user_secundary->save();
                            }
                        }
                    }

                    if ($type_user->nome == 'EMISSORA DE RÁDIO') {
                        //$radio = Radio::where('person_juridica', '=', $person_juridica->get(0)->id)->get();
                        $radio = Radio::where('person_juridica', '=', $auth_user->person_juridica)->get();

                        $radio->get(0)->nome_fantasia = $request->registry_main['nome_fantasia'];
                        $radio->get(0)->dial = $request->registry_main['dial'];
                        $radio->get(0)->fm_am = $request->registry_main['fm_am'];
                        $radio->get(0)->concessao = $request->registry_main['concessao'];
                        $radio->get(0)->telefone_comercial = $request->registry_main['telefone_comercial'];
                        $radio->get(0)->email_comercial = $request->registry_main['email_comercial'];
                        $radio->get(0)->facebook = $request->registry_main['facebook'];
                        $radio->get(0)->site = $request->registry_main['site'];
                        $radio->get(0)->instagram = $request->registry_main['instagram'];
                        $radio->get(0)->descricao = $request->registry_main['descricao'];
                        $radio->get(0)->data_criacao = date('Y-m-d');
                        $radio->get(0)->preco = $request->registry_main['preco'];
                        $radio->get(0)->profile = $request->registry_main['profile'];
                        $radio->get(0)->instagram = $request->registry_main['instagram'];

                        if ($request->registry_main['logo']) {
                            //LOGO RADIO-------------------------------------;----------------------
                            Storage::delete($radio->get(0)->logo);
                            $base64 = $request->registry_main['logo'];
                            //obtem a extensão
                            $extension = explode('/', $base64);
                            $extension = explode(';', $extension[1]);
                            $extension = '.' . $extension[0];

                            //gera o nome
                            $name = time() . $extension;

                            //obtem o arquivo
                            $separatorFile = explode(',', $base64);
                            $file = $separatorFile[1];
                            $path = 'logo_radio';

                            //envia o arquivo
                            Storage::put("$path/$path.$name", base64_decode($file));
                            $radio->get(0)->logo = "$path/$path.$name";
                            //---------------------------------------------------------------------
                        }
                        $radio->get(0)->save();

                        if (count($request->registry_secundary) > 0) {
//                            $auth_secundary = Auth_user::where('auth_user_master','=',$request->auth_user['auth_user'])->get();
//
//                            foreach ($auth_secundary as $as)
//                            {
//                                $auth_secundary_delete = Auth_user::find($as['id']);
//                                $auth_secundary_delete->delete();
//                            }

                            foreach ($request->registry_secundary as $rs)
                            {
                                $auth_user_secundary = new Auth_user();
                                $auth_user_secundary->senha = md5($rs['senha']);
                                $auth_user_secundary->nome_usuario = $rs['nome_usuario'];
                                $auth_user_secundary->nome = $rs['nome'];
                                $auth_user_secundary->sobrenome = $rs['sobrenome'];
                                $auth_user_secundary->cpf = $rs['cpf'];
                                $auth_user_secundary->email = $rs['email'];
                                $auth_user_secundary->data_criacao = date('Y-m-d');
                                $auth_user_secundary->type_user = $request->type_user['id'];
                                $auth_user_secundary->auth_user_master = $auth_user->id;
                                $auth_user_secundary->person_juridica = $auth_user->person_juridica;
                                $auth_user_secundary->nivel = 'Secundario';
                                $auth_user_secundary->save();
                            }
                        }

                        if(count($request->spot_radio) > 0)
                        {
                            $spot_radio = Spot_radio::where('radio','=', $radio->get(0)->id)->get();
                            if(count($spot_radio) > 0)
                            {
                                foreach ($request->spot_radio as $sr)
                                {
                                    $spot_radio_verificar = Spot_radio::where('spot','=',$sr['spot'])->get();
                                    if (count($spot_radio_verificar) == 0)
                                    {
                                        $spot_radio_save = new Spot_radio();
                                        $spot_radio_save->spot = $sr['spot'];
                                        $spot_radio_save->horario = $sr['horario'];
                                        $spot_radio_save->valor = $sr['valor'];
                                        $spot_radio_save->radio = $radio->get(0)->id;
                                        $spot_radio_save->save();
                                    }
                                }
                            } else {
                                foreach ($request->spot_radio as $sr)
                                {

                                    $spot_radio_save = new Spot_radio();
                                    $spot_radio_save->spot = $sr['spot'];
                                    $spot_radio_save->horario = $sr['horario'];
                                    $spot_radio_save->valor = $sr['valor'];
                                    $spot_radio_save->radio = $radio->get(0)->id;
                                    $spot_radio_save->save();

                                }
                            }

                        }

                        if(count($request->registry_main['alcance']) > 0)
                        {
                            $alances = Reach_radio::where('radio','=',$radio->get(0)->id)->get();
                            foreach ($alances as $a)
                            {
                                $alcance_delete = Reach_radio::find($a['id']);
                                $alcance_delete->delete();
                            }
                            foreach ($request->registry_main['alcance'] as $al) {
                                $city = City::where('nome','=',$al['city'])->get();
                                $state = State::where('nome','=',$al['state'])->get();

                                if(count($state) > 0)
                                {
                                    if(count($city) > 0)
                                    {
                                        $alcance_radio = new Reach_radio();
                                        $alcance_radio->city = $city->get(0)->id;
                                        $alcance_radio->radio = $radio->get(0)->id;
                                        $alcance_radio->save();
                                    } else {
                                        $city = new City();
                                        $city->nome = $al['city'];
                                        $city->state = $state->get(0)->id;
                                        $city->save();

                                        $alcance_radio = new Reach_radio();
                                        $alcance_radio->city = $city->id;
                                        $alcance_radio->radio = $radio->get(0)->id;
                                        $alcance_radio->save();
                                    }
                                } else {
                                    $state = new State();
                                    $state->nome = $al['state'];
                                    $state->save();

                                    if(count($city) > 0)
                                    {
                                        $alcance_radio = new Reach_radio();
                                        $alcance_radio->city = $city->get(0)->id;
                                        $alcance_radio->radio = $radio->get(0)->id;
                                        $alcance_radio->save();
                                    } else {
                                        $city = new City();
                                        $city->nome = $al['city'];
                                        $city->state = $state->id;
                                        $city->save();

                                        $alcance_radio = new Reach_radio();
                                        $alcance_radio->city = $city->id;
                                        $alcance_radio->radio = $radio->get(0)->id;
                                        $alcance_radio->save();
                                    }
                                }
                            }
                        }

                        if(count($request->registry_main['midia_kit']) > 0)
                        {
                            $midias = Midia_kit::where('radio','=',$radio->get(0)->id)->get();
                            foreach ($midias as $mds)
                            {
                                Storage::delete($mds['midia_kit']);
                                $midia_delete = Midia_kit::find($mds['id']);
                                $midia_delete->delete();

                            }
                            foreach ($request->registry_main['midia_kit'] as $key => $m) {
                                $midia_kit = new Midia_kit();

                                //MIDIA RADIO----------------------------------------------------------
                                $base64 = $m['midia'];

                                //obtem a extensão
                                $extension = explode('/', $base64);
                                $extension = explode(';', $extension[1]);
                                $extension = '.' . $extension[0];

                                //gera o nome
                                $name = time() . $key . $extension;

                                //obtem o arquivo
                                $separatorFile = explode(',', $base64);
                                $file = $separatorFile[1];
                                $path = 'midia_kit_radio';

                                //envia o arquivo
                                Storage::put("$path/$path.$name", base64_decode($file));
                                $midia_kit->midia_kit = "$path/$path.$name";
                                $midia_kit->radio = $radio->get(0)->id;
                                $midia_kit->save();
                                //---------------------------------------------------------------------
                            }
                        }

                    }
                } else {
                    $person_juridica_edit = Person_juridica::find($auth_user->person_juridica);

                    if ($person_juridica_cnpj->get(0)->cnpj == $person_juridica_edit->cnpj) {
                        $person_juridica_edit->razao_social = $request->person_juridica['razao_social'];
                        $person_juridica_edit->cnpj = $request->person_juridica['cnpj'];
                        $person_juridica_edit->cep = $request->person_juridica['cep'];
                        $person_juridica_edit->logradouro = $request->person_juridica['logradouro'];
                        $person_juridica_edit->estado = $request->person_juridica['estado'];
                        $person_juridica_edit->bairro = $request->person_juridica['bairro'];
                        $person_juridica_edit->cidade = $request->person_juridica['cidade'];
                        $person_juridica_edit->complemento = $request->person_juridica['complemento'];
                        $person_juridica_edit->inscricao_municipal = $request->person_juridica['inscricao_municipal'];
                        $person_juridica_edit->inscricao_estadual = $request->person_juridica['inscricao_estadual'];
                        $person_juridica_edit->save();

                        if ($type_user->nome == 'AGÊNCIA') {
                            // $agency = Agency::where('person_juridica', '=', $person_juridica->get(0)->id)->get();
                            $agency = Agency::where('person_juridica', '=', $auth_user->person_juridica)->get();

                            $agency->get(0)->nome_fantasia = $request->registry_main['nome_fantasia'];
                            $agency->get(0)->telefone_comercial = $request->registry_main['telefone_comercial'];
                            $agency->get(0)->email_comercial = $request->registry_main['email_comercial'];
                            $agency->get(0)->facebook = $request->registry_main['facebook'];
                            $agency->get(0)->site = $request->registry_main['site'];
                            $agency->get(0)->instagram = $request->registry_main['instagram'];

                            if ($request->registry_main['logo']) {
                                Storage::delete($agency->get(0)->logo);

                                $base64 = $request->registry_main['logo'];
                                //obtem a extensão
                                $extension = explode('/', $base64);
                                $extension = explode(';', $extension[1]);
                                $extension = '.' . $extension[0];

                                //gera o nome
                                $name = time() . $extension;

                                //obtem o arquivo
                                $separatorFile = explode(',', $base64);
                                $file = $separatorFile[1];
                                $path = 'logo_advertiser_company';

                                //envia o arquivo
                                Storage::put("$path/$path.$name", base64_decode($file));
                                $agency->get(0)->logo = "$path/$path.$name";
                            }
                            $agency->get(0)->save();

                            if (count($request->registry_secundary) > 0) {
//                                $auth_secundary = Auth_user::where('auth_user_master','=',$request->auth_user['auth_user'])->get();
//
//                                foreach ($auth_secundary as $as)
//                                {
//                                    $auth_secundary_delete = Auth_user::find($as['id']);
//                                    $auth_secundary_delete->delete();
//                                }

                                foreach ($request->registry_secundary as $rs)
                                {
                                    $auth_user_secundary = new Auth_user();
                                    $auth_user_secundary->senha = md5($rs['senha']);
                                    $auth_user_secundary->nome_usuario = $rs['nome_usuario'];
                                    $auth_user_secundary->nome = $rs['nome'];
                                    $auth_user_secundary->sobrenome = $rs['sobrenome'];
                                    $auth_user_secundary->cpf = $rs['cpf'];
                                    $auth_user_secundary->email = $rs['email'];
                                    $auth_user_secundary->data_criacao = date('Y-m-d');
                                    $auth_user_secundary->type_user = $request->type_user['id'];
                                    $auth_user_secundary->auth_user_master = $auth_user->id;
                                    $auth_user_secundary->person_juridica = $auth_user->person_juridica;
                                    $auth_user_secundary->nivel = 'Secundario';
                                    $auth_user_secundary->save();
                                }
                            }
                        }

                        if ($type_user->nome == 'EMPRESA ANUNCIANTE') {
                            //$advertiser_company = Advertiser_company::where('person_juridica', '=', $person_juridica->get(0)->id)->get();
                            $advertiser_company = Advertiser_company::where('person_juridica', '=', $auth_user->person_juridica)->get();

                            $advertiser_company->get(0)->nome_fantasia = $request->registry_main['nome_fantasia'];
                            $advertiser_company->get(0)->telefone_comercial = $request->registry_main['telefone_comercial'];
                            $advertiser_company->get(0)->email_comercial = $request->registry_main['email_comercial'];
                            $advertiser_company->get(0)->facebook = $request->registry_main['facebook'];
                            $advertiser_company->get(0)->site = $request->registry_main['site'];
                            $advertiser_company->get(0)->instagram = $request->registry_main['instagram'];

                            if ($request->registry_main['logo']) {
                                Storage::delete($advertiser_company->get(0)->logo);

                                $base64 = $request->registry_main['logo'];
                                //obtem a extensão
                                $extension = explode('/', $base64);
                                $extension = explode(';', $extension[1]);
                                $extension = '.' . $extension[0];

                                //gera o nome
                                $name = time() . $extension;

                                //obtem o arquivo
                                $separatorFile = explode(',', $base64);
                                $file = $separatorFile[1];
                                $path = 'logo_advertiser_company';

                                //envia o arquivo
                                Storage::put("$path/$path.$name", base64_decode($file));
                                $advertiser_company->get(0)->logo = "$path/$path.$name";
                            }

                            $advertiser_company->get(0)->save();

                            if (count($request->registry_secundary) > 0) {
//                                $auth_secundary = Auth_user::where('auth_user_master','=',$request->auth_user['auth_user'])->get();
//
//                                foreach ($auth_secundary as $as)
//                                {
//                                    $auth_secundary_delete = Auth_user::find($as['id']);
//                                    $auth_secundary_delete->delete();
//                                }

                                foreach ($request->registry_secundary as $rs)
                                {
                                    $auth_user_secundary = new Auth_user();
                                    $auth_user_secundary->senha = md5($rs['senha']);
                                    $auth_user_secundary->nome_usuario = $rs['nome_usuario'];
                                    $auth_user_secundary->nome = $rs['nome'];
                                    $auth_user_secundary->sobrenome = $rs['sobrenome'];
                                    $auth_user_secundary->cpf = $rs['cpf'];
                                    $auth_user_secundary->email = $rs['email'];
                                    $auth_user_secundary->data_criacao = date('Y-m-d');
                                    $auth_user_secundary->type_user = $request->type_user['id'];
                                    $auth_user_secundary->auth_user_master = $auth_user->id;
                                    $auth_user_secundary->person_juridica = $auth_user->person_juridica;
                                    $auth_user_secundary->nivel = 'Secundario';
                                    $auth_user_secundary->save();
                                }
                            }
                        }

                        if ($type_user->nome == 'EMISSORA DE RÁDIO') {
                            //$radio = Radio::where('person_juridica', '=', $person_juridica->get(0)->id)->get();
                            $radio = Radio::where('person_juridica', '=', $auth_user->person_juridica)->get();

                            $radio->get(0)->nome_fantasia = $request->registry_main['nome_fantasia'];
                            $radio->get(0)->dial = $request->registry_main['dial'];
                            $radio->get(0)->fm_am = $request->registry_main['fm_am'];
                            $radio->get(0)->concessao = $request->registry_main['concessao'];
                            $radio->get(0)->telefone_comercial = $request->registry_main['telefone_comercial'];
                            $radio->get(0)->email_comercial = $request->registry_main['email_comercial'];
                            $radio->get(0)->facebook = $request->registry_main['facebook'];
                            $radio->get(0)->site = $request->registry_main['site'];
                            $radio->get(0)->instagram = $request->registry_main['instagram'];
                            $radio->get(0)->descricao = $request->registry_main['descricao'];
                            $radio->get(0)->data_criacao = date('Y-m-d');
                            $radio->get(0)->preco = $request->registry_main['preco'];
                            $radio->get(0)->profile = $request->registry_main['profile'];
                            $radio->get(0)->instagram = $request->registry_main['instagram'];

                            if ($request->registry_main['logo']) {
                                //LOGO RADIO-------------------------------------;----------------------
                                Storage::delete($radio->get(0)->logo);
                                $base64 = $request->registry_main['logo'];
                                //obtem a extensão
                                $extension = explode('/', $base64);
                                $extension = explode(';', $extension[1]);
                                $extension = '.' . $extension[0];

                                //gera o nome
                                $name = time() . $extension;

                                //obtem o arquivo
                                $separatorFile = explode(',', $base64);
                                $file = $separatorFile[1];
                                $path = 'logo_radio';

                                //envia o arquivo
                                Storage::put("$path/$path.$name", base64_decode($file));
                                $radio->get(0)->logo = "$path/$path.$name";
                                //---------------------------------------------------------------------
                            }
                            $radio->get(0)->save();

                            if (count($request->registry_secundary) > 0) {
//                                $auth_secundary = Auth_user::where('auth_user_master','=',$request->auth_user['auth_user'])->get();
//
//                                foreach ($auth_secundary as $as)
//                                {
//                                    $auth_secundary_delete = Auth_user::find($as['id']);
//                                    $auth_secundary_delete->delete();
//                                }

                                foreach ($request->registry_secundary as $rs)
                                {
                                    $auth_user_secundary = new Auth_user();
                                    $auth_user_secundary->senha = md5($rs['senha']);
                                    $auth_user_secundary->nome_usuario = $rs['nome_usuario'];
                                    $auth_user_secundary->nome = $rs['nome'];
                                    $auth_user_secundary->sobrenome = $rs['sobrenome'];
                                    $auth_user_secundary->cpf = $rs['cpf'];
                                    $auth_user_secundary->email = $rs['email'];
                                    $auth_user_secundary->data_criacao = date('Y-m-d');
                                    $auth_user_secundary->type_user = $request->type_user['id'];
                                    $auth_user_secundary->auth_user_master = $auth_user->id;
                                    $auth_user_secundary->person_juridica = $auth_user->person_juridica;
                                    $auth_user_secundary->nivel = 'Secundario';
                                    $auth_user_secundary->save();
                                }
                            }

                            if(count($request->spot_radio) > 0)
                            {
                                $spot_radio = Spot_radio::where('radio','=', $radio->get(0)->id)->get();
                                if(count($spot_radio) > 0)
                                {
                                    foreach ($request->spot_radio as $sr)
                                    {
                                        $spot_radio_verificar = Spot_radio::where('spot','=',$sr['spot'])->get();
                                        if (count($spot_radio_verificar) == 0)
                                        {
                                            $spot_radio_save = new Spot_radio();
                                            $spot_radio_save->spot = $sr['spot'];
                                            $spot_radio_save->horario = $sr['horario'];
                                            $spot_radio_save->valor = $sr['valor'];
                                            $spot_radio_save->radio = $radio->get(0)->id;
                                            $spot_radio_save->save();
                                        }
                                    }
                                } else {
                                    foreach ($request->spot_radio as $sr)
                                    {
                                        $spot_radio_save = new Spot_radio();
                                        $spot_radio_save->spot = $sr['spot'];
                                        $spot_radio_save->horario = $sr['horario'];
                                        $spot_radio_save->valor = $sr['valor'];
                                        $spot_radio_save->radio = $radio->get(0)->id;
                                        $spot_radio_save->save();

                                    }
                                }

                            }

                            if(count($request->registry_main['alcance']) > 0)
                            {
                                $alances = Reach_radio::where('radio','=',$radio->get(0)->id)->get();
                                foreach ($alances as $a)
                                {
                                    $alcance_delete = Reach_radio::find($a['id']);
                                    $alcance_delete->delete();
                                }

                                foreach ($request->registry_main['alcance'] as $al) {
                                    $city = City::where('nome','=',$al['city'])->get();
                                    $state = State::where('nome','=',$al['state'])->get();

                                    if(count($state) > 0)
                                    {
                                        if(count($city) > 0)
                                        {
                                            $alcance_radio = new Reach_radio();
                                            $alcance_radio->city = $city->get(0)->id;
                                            $alcance_radio->radio = $radio->get(0)->id;
                                            $alcance_radio->save();
                                        } else {
                                            $city = new City();
                                            $city->nome = $al['city'];
                                            $city->state = $state->get(0)->id;
                                            $city->save();

                                            $alcance_radio = new Reach_radio();
                                            $alcance_radio->city = $city->id;
                                            $alcance_radio->radio = $radio->get(0)->id;
                                            $alcance_radio->save();
                                        }
                                    } else {
                                        $state = new State();
                                        $state->nome = $al['state'];
                                        $state->save();

                                        if(count($city) > 0)
                                        {
                                            $alcance_radio = new Reach_radio();
                                            $alcance_radio->city = $city->get(0)->id;
                                            $alcance_radio->radio = $radio->get(0)->id;
                                            $alcance_radio->save();
                                        } else {
                                            $city = new City();
                                            $city->nome = $al['city'];
                                            $city->state = $state->id;
                                            $city->save();

                                            $alcance_radio = new Reach_radio();
                                            $alcance_radio->city = $city->id;
                                            $alcance_radio->radio = $radio->get(0)->id;
                                            $alcance_radio->save();
                                        }
                                    }
                                }
                            }

                            if(count($request->registry_main['midia_kit']) > 0)
                            {
                                $midias = Midia_kit::where('radio','=',$radio->get(0)->id)->get();
                                foreach ($midias as $mds)
                                {
                                    Storage::delete($mds['midia_kit']);
                                    $midia_delete = Midia_kit::find($mds['id']);
                                    $midia_delete->delete();

                                }
                                foreach ($request->registry_main['midia_kit'] as $key => $m) {
                                    $midia_kit = new Midia_kit();

                                    //MIDIA RADIO----------------------------------------------------------
                                    $base64 = $m['midia'];

                                    //obtem a extensão
                                    $extension = explode('/', $base64);
                                    $extension = explode(';', $extension[1]);
                                    $extension = '.' . $extension[0];

                                    //gera o nome
                                    $name = time() . $key . $extension;

                                    //obtem o arquivo
                                    $separatorFile = explode(',', $base64);
                                    $file = $separatorFile[1];
                                    $path = 'midia_kit_radio';

                                    //envia o arquivo
                                    Storage::put("$path/$path.$name", base64_decode($file));
                                    $midia_kit->midia_kit = "$path/$path.$name";
                                    $midia_kit->radio = $radio->get(0)->id;
                                    $midia_kit->save();
                                    //---------------------------------------------------------------------
                                }
                            }
                        }
                    } else {
                        return response()->json(['message' => 'Esse CNPJ já está cadastrado'], 400);
                    }
                }

                $auth = Auth_user::where('id', $request->auth_user['auth_user'])
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

                return $auth->get(0);

            } else {
                $person_fisica = Person_fisica::where('auth_user', '=', $request->auth_user['auth_user'])->get();
                $person_fisica_cpf = Person_fisica::where('cpf', '=', $request->person_fisica['cpf'])->get();

                if (count($person_fisica_cpf) == 0) {
                    $person_fisica_edit = Person_fisica::find($person_fisica->get(0)->id);
                    $person_fisica_edit->cpf = $request->person_fisica['cpf'];
                    if($request->person_fisica['image'])
                    {
                        Storage::delete($person_fisica_edit->image);
                        $base64 = $request->person_fisica['image'];
                        //obtem a extensão
                        $extension = explode('/', $base64);
                        $extension = explode(';', $extension[1]);
                        $extension = '.' . $extension[0];

                        //gera o nome
                        $name = time() . $extension;

                        //obtem o arquivo
                        $separatorFile = explode(',', $base64);
                        $file = $separatorFile[1];
                        $path = 'logo_person_fisica';

                        //envia o arquivo
                        Storage::put("$path/$path.$name", base64_decode($file));
                        $person_fisica_edit->image = "$path/$path.$name";
                        //---------------------------------------------------------------------
                    }
                    $person_fisica_edit->save();

                    $auth = Auth_user::where('id', $request->auth_user['auth_user'])
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

                    return $auth->get(0);
                } else {
                    if ($person_fisica_cpf->get(0)->cpf == $person_fisica->get(0)->cpf) {
                        $person_fisica_edit = Person_fisica::find($person_fisica->get(0)->id);
                        $person_fisica_edit->cpf = $request->person_fisica['cpf'];
                        if($request->person_fisica['image'])
                        {
                            Storage::delete($person_fisica_edit->image);
                            $base64 = $request->person_fisica['image'];
                            //obtem a extensão
                            $extension = explode('/', $base64);
                            $extension = explode(';', $extension[1]);
                            $extension = '.' . $extension[0];

                            //gera o nome
                            $name = time() . $extension;

                            //obtem o arquivo
                            $separatorFile = explode(',', $base64);
                            $file = $separatorFile[1];
                            $path = 'logo_person_fisica';

                            //envia o arquivo
                            Storage::put("$path/$path.$name", base64_decode($file));
                            $person_fisica_edit->image = "$path/$path.$name";
                            //---------------------------------------------------------------------
                        }
                        $person_fisica_edit->save();

                        $auth = Auth_user::where('id', $request->auth_user['auth_user'])
                            ->with('person_juridica')
                            ->with('person_juridica.emissora_radio')
                            ->with('person_juridica.emissora_radio.midia_kit')
                            ->with('person_juridica.emissora_radio.profile')
                            ->with('person_juridica.emissora_radio.spot_radio')
                            ->with('person_juridica.emissora_radio.radios_secundarios')
                            ->with('person_juridica.emissora_radio.reach_radio.city')
                            ->with('person_juridica.emissora_radio.reach_radio.city.state')
                            ->with('person_juridica.agencia')
                            ->with('person_juridica.agencia.agencia_secundarios')
                            ->with('person_juridica.empresa_anuciante')
                            ->with('person_juridica.empresa_anuciante.empresa_anuciante_secundarios')
                            ->with('person_fisica')
                            ->with('type_user')
                            ->get();

                        return $auth->get(0);
                    } else {
                        return response()->json(['message' => 'Esse CPF já está cadastrado'], 400);
                    }
                }
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 400);
        }

    }

    public function remover(Request $request)
    {
       $a = Auth_user::find($request->id)->delete();
       if($a)
       {
           return response()->json(['message'=>"Usuário removido"]);
       }

    }
}

