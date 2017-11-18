<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenAtencionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_atencion', function (Blueprint $table) {
            $table->increments('id_orden_atencion');
            $table->integer('id_area')->unsigned();
            $table->foreign('id_area')->references('id')->on('area');
            $table->integer('id_usuario_captura');
            $table->foreign('id_usuario_captura')->references('id')->on('usuario');
            $table->integer('id_usuario_responsable');
            $table->foreign('id_usuario_responsable')->references('id')->on('usuario');
            $table->integer('id_joven_responsable');
            $table->foreign('id_joven_responsable')->references('id')->on('usuario');
            $table->integer('id_region');
            $table->foreign('id_region')->references('id_region')->on('region');
            $table->integer('id_centro_poder_joven')->unsigned();
            $table->foreign('id_centro_poder_joven')->references('id_centro_poder_joven')->on('centro_poder_joven');
            $table->string('titulo', 100);
            $table->string('descripcion', 500);
            $table->date('fecha_inicio');
            $table->date('fecha_propuesta');
            $table->date('fecha_resolucion');
            $table->float('costo_estimado');
            $table->float('costo_real');
            $table->string('resultado', 500);
            $table->string('observaciones', 500);
            $table->boolean('estatus');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_atencion');
    }
}
