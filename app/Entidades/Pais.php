<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Pais extends Model
{
    protected $table = 'paises';
    public $timestamps = false;

    protected $fillable = [
        'idpais', 'descpais', 'ncpais'
    ];

    protected $hidden = [

    ];


    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idpais,
                  A.descpais
                FROM paises A ORDER BY A.descpais";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
}