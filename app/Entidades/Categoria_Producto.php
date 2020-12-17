
<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Categoria_Producto extends Model
{
    protected $table = 'categoria_productos';
    public $timestamps = false;

    protected $fillable = [
     'fk_idcategoria', 'fk_idproducto'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
       
        $this->fk_idproducto = $request->input('lstProducto');
        $this->fk_idcategoria = $request->input('lstCategoria');
        
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.fk_idproducto,
                  A.fk_idcategoria
                FROM categoria_productos A";

        $sql .= " ORDER BY A.fk_idproducto";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    


      public  function eliminarPorProducto() {
        $sql = "DELETE FROM categoria_productos WHERE 
            fk_idproducto=?";
        $affected = DB::delete($sql, [$this->fk_idproducto]);
    }


 public function insertar() {
        $sql = "INSERT INTO categoria_productos (
                fk_idproducto,
                fk_idcategoria
            ) VALUES (?, ?);";
       $result = DB::insert($sql, [
            $this->fk_idproducto, 
            $this->fk_idcategoria
        ]);
       
    }


}

?>