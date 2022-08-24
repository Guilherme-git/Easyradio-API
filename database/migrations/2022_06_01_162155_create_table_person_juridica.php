<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePersonJuridica extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_juridica', function (Blueprint $table) {
            $table->increments('id');
            $table->string('razao_social');
            $table->string('cnpj');
            $table->string('cep');
            $table->string('logradouro');
            $table->string('estado')->nullable();
            $table->string('bairro');
            $table->string('cidade');
            $table->string('complemento');
            $table->string('inscricao_municipal')->nullable();
            $table->string('inscricao_estadual')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person_juridica');
    }
}
