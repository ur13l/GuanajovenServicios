<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentoServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento_servicio', function (Blueprint $table) {
            $table->increments('id_documento_servicio');
            $table->string('titulo', 80);
            $table->string('url', 250);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('orden_documento', function (Blueprint $table) {
            $table->integer('id_orden_atencion')->unsigned();
            $table->foreign('id_orden_atencion')->references('id_orden_atencion')->on('orden_atencion');
            $table->integer('id_documento_servicio')->unsigned();
            $table->foreign('id_documento_servicio')->references('id_documento_servicio')->on('documento_servicio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documento_servicio');
    }
}
