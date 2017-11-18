<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationshipTablesOrden extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_servicio', function (Blueprint $table) {
            $table->integer('id_orden_atencion')->unsigned();
            $table->foreign('id_orden_atencion')->references('id_orden_atencion')->on('orden_atencion');
            $table->integer('id_servicio')->unsigned();
            $table->foreign('id_servicio')->references('id_servicio')->on('servicio');
        });

        Schema::create('orden_beneficiados', function (Blueprint $table) {
            $table->integer('id_orden_atencion')->unsigned();
            $table->foreign('id_orden_atencion')->references('id_orden_atencion')->on('orden_atencion');
            $table->integer('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');
        });

        Schema::create('orden_involucrados', function (Blueprint $table) {
            $table->integer('id_orden_atencion')->unsigned();
            $table->foreign('id_orden_atencion')->references('id_orden_atencion')->on('orden_atencion');
            $table->integer('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
