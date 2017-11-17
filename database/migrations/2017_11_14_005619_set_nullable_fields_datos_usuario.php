<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetNullableFieldsDatosUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('datos_usuario', function($table) {
            $table->integer('id_genero')->nullable()->change();
            $table->integer('id_estado_nacimiento')->nullable()->change();
            $table->string('codigo_postal')->nullable()->change();
        });

        Schema::table('funcionario', function($table) {
            $table->string('rfc')->nullable()->change();
            $table->string('clave')->nullable()->change();
            $table->string('estatus')->nullable()->change();
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
