<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterColumnsOrdenEstatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orden_atencion', function(Blueprint $table) {
            $table->renameColumn('estatus', 'id_estatus');
            $table->integer('id_estatus')->unsigned()->nullable()->change();
        });

        Schema::table('orden_atencion', function(Blueprint $table) {
            $table->foreign('id_estatus')->references('id')->on('estatus_orden');
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
