<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRadio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radio', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome_fantasia');
            $table->string('dial');
            $table->string('fm_am');
            $table->string('concessao');
            $table->string('telefone_comercial');
            $table->string('email_comercial');
            $table->string('facebook')->nullable();
            $table->string('site')->nullable();
            $table->string('instagram')->nullable();
            $table->text('logo');
            $table->text('descricao');
            $table->date('data_criacao');
            $table->string('preco');
            $table->integer('person_juridica');
            $table->integer('profile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('radio');
    }
}
