<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableHoursMinutsDay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planning_insertion_hours_minuts_day', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ano');
            $table->string('dias');
            $table->string('insertion_selected');
            $table->string('mes');
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
        Schema::dropIfExists('hours_minuts_day');
    }
}
