<?php

namespace App\Entidades\Sistema;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
require app_path().'/start/constants.php';

class Usuario_familia extends Model
{
    protected $table = 'sistema_usuario_familia';
    public $timestamps = false;

    protected $fillable = [
        'fk_idfamilia',
        'fk_idusuario', 
        'fk_idarea'
    ];

    public function insertar() {
        $sql = "INSERT INTO sistema_usuario_familia (
                    fk_idfamilia,
                    fk_idusuario,
                    fk_idarea
                    ) VALUES (?, ?, ?);";
        $result = DB::insert($sql, [$this->fk_idfamilia, $this->fk_idusuario, $this->fk_idarea]);
    }

    public function eliminarPorUsuario($idUsuario) {
        $sql = "DELETE FROM sistema_usuario_familia WHERE fk_idusuario=$idUsuario";
        $deleted = DB::delete($sql);
    }

    public function obtenerFamiliaDelUsuario($usuarioID) {
        $sql = "SELECT fk_idfamilia FROM sistema_usuario_familia A
        INNER JOIN sistema_usuario_area B ON A.fk_idusuario = B.fk_idusuario
        WHERE A.fk_idusuario='$usuarioID' AND B.fk_idarea=" .Session::get('grupo_id');
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function comprobarFamiliaDelUsuario($usuarioID, $familiaID) {
        $sql = "SELECT fk_idfamilia FROM sistema_usuario_familia A
        WHERE A.fk_idusuario='$usuarioID' AND A.fk_idfamilia= '$familiaID'";
        $lstRetorno = DB::select($sql);
        return count($lstRetorno);
    }
}

?>