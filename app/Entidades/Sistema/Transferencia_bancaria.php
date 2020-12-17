<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
require app_path().'/start/constants.php';

class Transferencia_bancaria extends Model
{
    protected $table = 'transferencias';
    public $timestamps = false;
    protected $fillable = [
        'idtranferencia',
        'fk_idbanco',
        'sucursal',
        'cbu',
        'alias',
        'cuenta',
        'cuit',
        'razonsocial'];

    public function guardar(){
        $sql = "UPDATE transferencias SET
                        fk_idbanco = '$this->fk_idbanco',
                        sucursal = '$this->sucursal',
                        cbu = '$this->cbu',
                        alias = '$this->alias',
                        cuenta = '$this->cuenta',
                        cuit = '$this->cuit',
                        razonsocial = '$this->razonsocial'
                WHERE idtransferencia = ?";
        $affected = DB::update($sql, 1);
    }
    
}

?>