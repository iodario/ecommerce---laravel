<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Moneda extends Model
{
    protected $table = 'monedas';
    public $timestamps = false;

    protected $fillable = [
        'idmoneda', 'nombre', 'abreviatura'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idmoneda = $request->input('id')!="0" ? $request->input('id') : $this->idmoneda;
        $this->nombre = $request->input('txtNombre');
        $this->abreviatura = $request->input('txtAbreviatura');
       
    }


    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idmoneda,
                  A.nombre,
                  A.abreviatura
                FROM monedas A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idmoneda) {
        $sql = "SELECT
                idmoneda,
                nombre,
                abreviatura
                FROM monedas WHERE idmoneda = '$idmoneda'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idmoneda = $lstRetorno[0]->idmoneda;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->abreviatura = $lstRetorno[0]->abreviatura;
            return $this;
        }
        return null;
    }
  


}

?>