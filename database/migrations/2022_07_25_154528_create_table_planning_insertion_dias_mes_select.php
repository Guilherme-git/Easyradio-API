<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePlanningInsertionDiasMesSelect extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planning_insertion_dias_mes_select', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value');
            $table->integer('planning_insertion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planning_insertion_dias_mes_select');
    }
}
