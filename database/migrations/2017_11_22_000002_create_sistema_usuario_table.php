<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSistemaUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sistema_usuario', function (Blueprint $table) {
            $table->increments('id'); //entero sin signo
            $table->string('usuario', 100);
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('email')->unique();
            $table->string('clave', 100)->nullable();
            $table->integer('activo');
            $table->integer('root');
            $table->integer('fk_grupo_id')->unsigned(); 
            $table->foreign('fk_grupo_id')->references('id')->on('sistema_grupo'); 
            $table->integer('ultimo_ingreso')->timestamp()->nullable();
            $table->timestamps();

            //$table->foreign('fk_grupo_id')->references('id')->on('grupo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sistema_usuario', function (Blueprint $table) {
            $table->dropForeign(['fk_grupo_id'])->unsigned(); 
        });
        Schema::dropIfExists('sistema_usuario');
    }
}
