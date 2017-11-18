<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCentroPoderJovensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centro_poder_joven', function (Blueprint $table) {
            $table->increments('id_centro_poder_joven');
            $table->string('nombre', 40);
            $table->string('direccion', 300);
            $table->integer('id_usuario_responsable');
            $table->foreign('id_usuario_responsable')->references('id')->on('usuario');
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
        Schema::dropIfExists('centro_poder_joven');
    }
}
