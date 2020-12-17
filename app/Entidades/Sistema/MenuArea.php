<?php

namespace App\Entidades\Sistema;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class MenuArea extends Model
{
    protected $table = 'sistema_menu_area';
    public $timestamps = false;

    protected $fillable = [
    	'fk_idmenu', 'fk_idarea'
    ];

    public function eliminarPorMenu() {
        $sql = "DELETE FROM sistema_menu_area WHERE 
            fk_idmenu=?";
        $affected = DB::delete($sql, [$this->fk_idmenu]);
    }

    public function insertar() {
        $sql = "INSERT INTO sistema_menu_area (
        fk_idmenu,
        fk_idarea
        ) VALUES (?, ?);";
       $result = DB::insert($sql, [$this->fk_idmenu, $this->fk_idarea]);
    }

    public function obtenerPorMenu($menuID){
        $sql = "SELECT fk_idarea FROM sistema_menu_area WHERE fk_idmenu = $menuID";
        $resultado = DB::select($sql);
        return $resultado;
    }

}
