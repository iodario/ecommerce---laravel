<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSistemaUsuarioFamiliaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sistema_usuario_familia', function (Blueprint $table) {
            $table->integer('fk_familia_id')->unsigned(); 
            $table->integer('fk_usuario_id')->unsigned(); 
            $table->foreign('fk_familia_id')->references('id')->on('sistema_familia'); 
            $table->foreign('fk_usuario_id')->references('id')->on('sistema_usuario'); 
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sistema_usuario_familia', function (Blueprint $table) {
            $table->dropForeign(['fk_familia_id'])->unsigned(); 
            $table->dropForeign(['fk_usuario_id'])->unsigned(); 
        });
        Schema::dropIfExists('sistema_usuario_familia');
    }
}
