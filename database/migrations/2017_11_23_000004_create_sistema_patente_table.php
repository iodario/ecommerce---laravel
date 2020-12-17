<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSistemaPatenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sistema_patente', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 250);
            $table->string('descripcion', 500);
            $table->string('modulo', 100);
            $table->string('submodulo', 100);
            $table->string('tipo', 100);
            $table->integer('log_operacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sistema_patente');
    }
}
