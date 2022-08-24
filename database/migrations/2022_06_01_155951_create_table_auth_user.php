<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAuthUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('senha');
            $table->string('nome_usuario');
            $table->string('nome');
            $table->string('sobrenome');
            $table->string('email');
            $table->string('cpf')->nullable();
            $table->date('data_criacao');
            $table->date('nivel')->nullable();
            $table->integer('person_juridica')->nullable();
            $table->integer('auth_user_master')->nullable();
            $table->integer('type_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_user');
    }
}
