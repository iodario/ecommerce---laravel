<?php

namespace App\Entidades\Sistema;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Menu extends Model
{
    protected $table = 'sistema_menues';
    public $timestamps = false;

    protected $fillable = [
        'idmenu', 'nombre', 'id_padre', 'orden', 'activo', 'url', 'css'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idmenu = $request->input('id')!="0" ? $request->input('id') : $this->idmenu;
        $this->nombre = $request->input('txtNombre');
        $this->id_padre = $request->input('lstMenuPadre');
        $this->orden = $request->input('txtOrden') != "" ? $request->input('txtOrden') : 0;
        $this->activo = $request->input('lstActivo');
        $this->url = $request->input('txtUrl');
        $this->css = $request->input('txtCss');
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.nombre',
           1 => 'B.nombre',
           2 => 'A.url',
           3 => 'A.activo'
            );
        $sql = "SELECT DISTINCT
                    A.idmenu,
                    A.nombre,
                    B.nombre as padre,
                    A.url,
                    A.activo
                    FROM sistema_menues A
                    LEFT JOIN sistema_menues B ON A.id_padre = B.idmenu
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR B.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.url LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idmenu,
                  A.nombre
                FROM sistema_menues A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

       public function obtenerMenuPadre() {
        $sql = "SELECT DISTINCT
                  A.idmenu,
                  A.nombre
                FROM sistema_menues A
                WHERE A.id_padre = 0 ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerSubMenu($idmenu=null){
        if($idmenu){
            $sql = "SELECT DISTINCT
                      A.idmenu,
                      A.nombre
                    FROM sistema_menues A
                    WHERE A.idmenu <> '$idmenu' ORDER BY A.nombre";
            $resultado = DB::select($sql);
        } else {
            $resultado = $this->obtenerTodos();
        }
        return $resultado;
    }

    public function obtenerPorId($idmenu) {
        $sql = "SELECT
                idmenu,
                nombre,
                id_padre,
                orden,
                activo,
                url,
                css
                FROM sistema_menues WHERE idmenu = '$idmenu'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idmenu = $lstRetorno[0]->idmenu;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->id_padre = $lstRetorno[0]->id_padre;
            $this->orden = $lstRetorno[0]->orden;
            $this->activo = $lstRetorno[0]->activo;
            $this->url = $lstRetorno[0]->url;
            $this->css = $lstRetorno[0]->css;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE sistema_menues SET
            nombre='$this->nombre',
            id_padre='$this->id_padre',
            orden=$this->orden,
            activo='$this->activo',
            url='$this->url',
            css='$this->css'
            WHERE idmenu=?";
        $affected = DB::update($sql, [$this->idmenu]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM sistema_menues WHERE 
            idmenu=?";
        $affected = DB::delete($sql, [$this->idmenu]);
    }

    public function insertar() {
        $sql = "INSERT INTO sistema_menues (
                nombre,
                id_padre,
                orden,
                activo,
                url,
                css
            ) VALUES (?, ?, ?, ?, ?, ?);";
       $result = DB::insert($sql, [
            $this->nombre, 
            $this->id_padre, 
            $this->orden, 
            $this->activo, 
            $this->url,
            $this->css
        ]);
       return $this->idmenu = DB::getPdo()->lastInsertId();
    }

    public function obtenerMenuDelGrupo($idGrupo){
        $sql = "SELECT DISTINCT
        A.idmenu,
        A.nombre,
        A.id_padre,
        A.orden,
        A.url,
        A.css
        FROM sistema_menues A
        INNER JOIN sistema_menu_area B ON A.idmenu = B.fk_idmenu
        WHERE A.activo = '1' AND B.fk_idarea = $idGrupo ORDER BY A.orden";
        $resultado = DB::select($sql);
        return $resultado;
    }

}
