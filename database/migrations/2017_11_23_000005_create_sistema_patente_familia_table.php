<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSistemaPatenteFamiliaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sistema_patente_familia', function (Blueprint $table) {
            $table->integer('fk_patente_id')->unsigned(); 
            $table->integer('fk_familia_id')->unsigned(); 
            $table->foreign('fk_patente_id')->references('id')->on('sistema_patente'); 
            $table->foreign('fk_familia_id')->references('id')->on('sistema_familia'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sistema_patente_familia', function (Blueprint $table) {
            $table->dropForeign(['fk_patente_id'])->unsigned(); 
            $table->dropForeign(['fk_familia_id'])->unsigned(); 
        });
        Schema::dropIfExists('sistema_patente_familia');
    }
}
