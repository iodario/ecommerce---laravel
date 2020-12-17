<?php

namespace App\Entidades\Sistema;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
require app_path().'/start/constants.php';

class Patente extends Model
{
    protected $table = 'sistema_patentes';
    public $timestamps = false;

    protected $fillable = [
        'idpatente',
        'nombre',
        'descripcion',
        'modulo',
        'submodulo',
        'tipo',
        'log_operacion'
    ];
    
     public function obtenerTodosPorFamilia($familiaID) {
        $sql = "SELECT 
                idpatente,
                nombre,
                descripcion,
                modulo,
                submodulo,
                tipo
                FROM sistema_patentes A
                INNER JOIN sistema_patente_familia B ON B.fk_idpatente = A.idpatente AND B.fk_idfamilia = ? ";
        $sql .= " ORDER BY nombre";
        $lstRetorno = DB::select($sql, [$familiaID]);
        return $lstRetorno;
    }

    public function obtenerCantidadGrillaDisponibles() {
        $sql = "SELECT count(idpatente) as cantidad
                FROM sistema_patentes A
                WHERE A.idpatente NOT IN (SELECT fk_idpatente FROM sistema_patente_familia)";
        $lstRetorno = DB::select($sql);
        return $lstRetorno[0]->cantidad;
    }

    public function obtenerFiltradoDisponibles() {
        /*
         * Obtiene todas las patentes que aun no fueron agregadas en la familia
         * 
         */
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.idpatente',
            1 => 'A.idpatente',
            2 => 'A.descripcion',
            3 => 'A.tipo',
            4 => 'A.modulo',
            5 => 'A.submodulo',
            6 => 'A.nombre'
        );
        $sql = "SELECT 
                    idpatente, 
                    nombre,
                    descripcion,
                    modulo,
                    submodulo,
                    tipo
                    FROM sistema_patentes A WHERE 1=1 ";

        if (!empty($request['search']['value'])) {          
            $sql.=" AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.descripcion LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.modulo LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.submodulo LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.tipo LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerPorId($idpatente) {
        $sql = "SELECT
                    idpatente,
                    nombre,
                    descripcion,
                    fk_idfamilia,
                    aud_usuario_ingreso,
                    aud_stm_ingreso,
                    aud_ip_ingreso,
                    aud_usuario_ultmod,
                    aud_stm_ultmod,
                    aud_ip_ultmod
                    FROM sistema_patentes WHERE idpatente = ?";
        $lstRetorno = DB::select($sql, [$idpatente]);
        return $lstRetorno[0];
    }

    public function obtenerPatentesDelUsuario() {
        $sql = "SELECT nombre, modulo, tipo, log_operacion
            FROM sistema_patentes A
            INNER JOIN sistema_patente_familia B ON B.fk_idpatente = A.idpatente
            INNER JOIN sistema_usuario_familia C ON C.fk_idfamilia = B.fk_idfamilia
            WHERE C.fk_idusuario = ? ";

        $lstRetorno = DB::select($sql, [Session::get('usuario_id')]);
        return $lstRetorno;
    }

    /**
     * 
     * @param type $idPatente 
     * @param type $log_operacion Indica desde el codigo si una operacion registra log en BBDD
     * @return boolean
     */
    public static function autorizarOperacion($nombrePatente) {
        /*
         * Busca que la patente este dentro de la variable de session que contiene
         * las patentes habilitadas para el usuario
         */
        $autorizado = false;
        $aPermisos = Session::get('array_permisos');

        if (isset($aPermisos) && $aPermisos != "" && count($aPermisos) > 0) {
            foreach ($aPermisos as $entidad) {
                if ($entidad->nombre == $nombrePatente) {
                    $autorizado = true;
                    break;
                }
            }
        }

        return $autorizado;
    }

    public static function autorizarModulo($nombreModulo) {
        /*
         * Busca que el modulo este dentro de la variable de session que contiene
         * los modulos habilitados para el usuario
         */
        $autorizado = false;
        $aPermisos = getPermisos();
        if (isset($aPermisos) && $aPermisos != "" && count($aPermisos) > 0) {
            foreach ($aPermisos as $entidad) {

                if ($entidad->modulo == $nombreModulo) {
                    $autorizado = true;
                    break;
                }
            }
        }
        return $autorizado;
    }

    public static function errorOperacion($nombrePatente, $mensaje) {
        ?>
        <br><div class="col-lg-12">
            <div id = "msg-error" class="alert alert-danger">
                <p><strong>&#161;Error&#33;</strong></p><?php echo "<p>$mensaje </p><p>Err: $nombrePatente</p>"; ?>
            </div>
        </div>
        <?php
    }


}
