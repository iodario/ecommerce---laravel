<?php

namespace App\Entidades\Sistema;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
require app_path().'/start/constants.php';

class Patente_familia extends Model
{
    protected $table = 'sistema_patente_familia';
    public $timestamps = false;

    protected $fillable = [
        'fk_idpatente',
        'fk_idfamilia'
    ];

    public function insertar() {
        $sql = "INSERT INTO sistema_patente_familia (
                fk_idpatente,
                fk_idfamilia
                ) VALUES (?, ?);";
        $result = DB::insert($sql, [$this->fk_idpatente, $this->fk_idfamilia]);
    }

    public function eliminarPorFamilia($familiaID) {
        $sql = "DELETE FROM sistema_patente_familia
                WHERE fk_idfamilia='$familiaID';";
        $deleted = DB::delete($sql);
    }
}

?>