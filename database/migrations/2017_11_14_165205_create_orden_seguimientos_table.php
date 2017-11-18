<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenSeguimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_seguimiento', function (Blueprint $table) {
            $table->increments('id_orden_seguimiento');
            $table->integer('id_comentario')->unsigned();
            $table->string('titulo', 100);
            $table->string('descripcion', 700);
            $table->date('fecha_comentario');
            $table->integer('id_usuario');
            $table->foreign('id_usuario')->references('id')->on('usuario');
            $table->integer('id_comentario_anterior')->unsigned();            
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
        Schema::dropIfExists('orden_seguimiento');
    }
}
