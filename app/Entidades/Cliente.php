<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;
use Session;

class Cliente extends Model
{
    protected $table = 'clientes';
    public $timestamp = false;

    protected $fillable = [
        'idcliente', 'telefono', 'fecha_nac', 'fk_idusuario','fk_idmoneda',
    ];

    public function cargarDesdeRequest($request)
    {
        $this->idcliente = $request->input('id') != 0 ? $request->input('id') : $this->idcliente;
        $this->telefono = $request->input('txtTelefono');
        $this->fecha_nac = $request->input('txtFechaNac');
        $this->fk_idusuario = $request->input('lstUsuario');
        $this->fk_idmoneda = $request->input('lstMoneda');
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                A.idcliente,
                A.telefono,
                A.fecha_nac,
                A.fk_idusuario,
                A.fk_idmoneda
                FROM clientes A ORDER BY A.idcliente;";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idcliente)
    {
        $sql = "SELECT
                    telefono,
                    fecha_nac,
                    fk_idusuario,
                    A.fk_idmoneda
                FROM clientes WHERE idcliente = '$idcliente';";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idcliente = $lstRetorno[0]->idcliente;
            $this->telefono = $lstRetorno[0]->telefono;
            $this->fecha_nac = $lstRetorno[0]->fecha_nac;
            $this->fk_idusuario = $lstRetorno[0]->fk_idusuario;
            $this->fk_idmoneda = $lstRetorno[0]->fk_idmoneda;
            return $this;
        }
        return null;
    }

    public function guardar()
    {
        $sql = "UPDATE clientes SET
                    telefono='$this->telefono',
                    fecha_nac='$this->fecha_nac',
                    fk_idusuario=$this->fk_idusuario,
                    fk_idmoneda=$this->fk_idmoneda
                WHERE idcliente = ?;";
        $affected = DB::update($sql, [$this->idcliente]);
    }

    public function insertar()
    {
        $sql = "INSERT INTO clientes (
                            telefono,
                            fecha_nac,
                            fk_idusuario,
                            fk_idmoneda)
                VALUES (?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->telefono,
            $this->fecha_nac,
            $this->fk_idusuario,
            $this->fk_idmoneda,
        ]);
        return $this->idcliente = DB::getPdo()->lastInsertId();
    }

    public function eliminar()
    {
        $sql = "DELETE FROM clientes WHERE idcliente = ?;";
        $affected = DB::delete($sql, [$this->idcliente]);
    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'B.nombre',
            1 => 'B.mail',
            2 => 'A.telefono',
            3 => 'A.usuario'
        );
        $sql = "SELECT DISTINCT
                     A.idcliente,
                     B.usuario,
                     B.nombre,
                     B.apellido,
                     B.mail,
                     A.fecha_nac,
                     A.telefono

                    FROM clientes A
                    LEFT JOIN sistema_usuarios B ON A.fk_idusuario = B.idusuario

                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( B.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR B.apellido LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR B.mail LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR B.usuario LIKE '%" . $request['search']['value'] . "%' )";
        }
      //  $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

}
