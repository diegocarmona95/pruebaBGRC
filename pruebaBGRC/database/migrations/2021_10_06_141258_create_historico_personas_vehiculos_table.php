<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoricoPersonasVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_personas_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('persona_id')->unsigned();
            $table->integer('vehiculo_id')->unsigned();
            $table->integer('precio')->nullable();
        });

        Schema::table('historico_personas_vehiculos', function($table) {
            $table->foreign('persona_id')->references('id')->on('personas');
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historico_personas_vehiculos');
    }
}
