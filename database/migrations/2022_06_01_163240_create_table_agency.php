<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAgency extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agency', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome_fantasia');
            $table->string('telefone_comercial');
            $table->string('email_comercial');
            $table->string('facebook')->nullable();
            $table->string('site')->nullable();
            $table->string('instagram')->nullable();
            $table->text('logo');
            $table->integer('person_juridica');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agency');
    }
}
