<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SeederSistemaGrupo::class);
        $this->call(SeederSistemaUsuario::class);
        $this->call(SeederSistemaUsuarioGrupo::class);
    }
}


class SeederSistemaGrupo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*DB::statement('EXEC sp_msforeachtable "ALTER TABLE ? NOCHECK CONSTRAINT all";'); //Desactiva la revisión de claves foraneas
        
        DB::table('sistema_usuario')->truncate();
        DB::table('sistema_grupo')->truncate();
        
        DB::statement('exec sp_MSforeachtable @command1="print \'?\'", @command2="ALTER TABLE ? WITH CHECK CHECK CONSTRAINT all";'); //Vuelve a activar la revisión de claves foraneas
        */

        DB::table('sistema_grupo')->insert([
        	'nombre' => 'FCE',
        	'activo' => 1
        ]);
    }
}

class SeederSistemaUsuario extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*DB::statement('EXEC sp_msforeachtable "ALTER TABLE ? NOCHECK CONSTRAINT all";');
        
        DB::table('sistema_usuario')->truncate();
        
        DB::statement('exec sp_MSforeachtable @command1="print \'?\'", @command2="ALTER TABLE ? WITH CHECK CHECK CONSTRAINT all";'); 
        */

        DB::table('sistema_usuario')->insert([
        	'usuario' => 'nelson.tarche',
            'nombre' => 'Nelson Daniel',
            'apellido' => 'Tarche',
        	'email' => 'nelson.tarche@fce.uba.ar',
            'clave' => bcrypt('laravel'),
        	'activo' => 1,
            'root' => 1,
        	'fk_grupo_id' => 1
        ]);

        DB::table('sistema_usuario')->insert([
            'usuario' => 'usuario2',
            'nombre' => 'Nombre2',
            'apellido' => 'Apellido2',
            'email' => 'usuario2@mail.com',
            'clave' => bcrypt('laravel'),
            'activo' => 1,
            'root' => 1,
            'fk_grupo_id' => 1
        ]);

       DB::table('sistema_usuario')->insert([
            'usuario' => 'usuario3',
            'nombre' => 'Nombre3',
            'apellido' => 'Apellido3',
            'email' => 'usuario3@mail.com',
            'clave' => bcrypt('laravel'),
            'activo' => 1,
            'root' => 1,
            'fk_grupo_id' => 1
        ]);
        DB::table('sistema_usuario')->insert([
            'usuario' => 'usuario4',
            'nombre' => 'Nombre4',
            'apellido' => 'Apellido4',
            'email' => 'usuario4@mail.com',
            'clave' => bcrypt('laravel'),
            'activo' => 1,
            'root' => 1,
            'fk_grupo_id' => 1
        ]);
         DB::table('sistema_usuario')->insert([
            'usuario' => 'usuario5',
            'nombre' => 'Nombre5',
            'apellido' => 'Apellido5',
            'email' => 'usuario5@mail.com',
            'clave' => bcrypt('laravel'),
            'activo' => 1,
            'root' => 1,
            'fk_grupo_id' => 1
        ]);
    }
}


class SeederSistemaUsuarioGrupo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<=5;$i++)
        DB::table('sistema_usuario_grupo')->insert([
            'fk_usuario_id' => $i,
            'fk_grupo_id' => 1,
            'predeterminado' => 1
        ]);
    }
}
