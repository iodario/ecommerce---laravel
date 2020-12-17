<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSistemaUsuarioGrupoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sistema_usuario_grupo', function (Blueprint $table) {
            $table->integer('fk_usuario_id')->unsigned(); 
            $table->integer('fk_grupo_id')->unsigned(); 
            $table->foreign('fk_usuario_id')->references('id')->on('sistema_usuario'); 
            $table->foreign('fk_grupo_id')->references('id')->on('sistema_grupo'); 
            $table->integer('predeterminado')->unsigned(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sistema_usuario_grupo', function (Blueprint $table) {
            $table->dropForeign(['fk_usuario_id'])->unsigned(); 
            $table->dropForeign(['fk_grupo_id'])->unsigned(); 
        });
        Schema::dropIfExists('sistema_usuario_grupo');
    }
}
