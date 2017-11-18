<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullableFecha extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orden_atencion', function(Blueprint $table) {
            $table->date('fecha_resolucion')->nullable()->change();
            $table->float('costo_real')->nullable()->change();
            $table->string('resultado')->nullable()->change();
            $table->string('observaciones')->nullable()->change();
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
