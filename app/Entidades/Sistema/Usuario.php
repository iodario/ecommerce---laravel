<?php

namespace App\Entidades\Sistema;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
require app_path().'/start/constants.php';

class Usuario extends Model
{
    protected $table = 'sistema_usuarios';
    public $timestamps = false;

    protected $fillable = [
        'usuario', 'cantidad_bloqueo','activo','created_at','ultimo_ingreso','root', 'apellido','nombre','mail', 'clave'
    ];
    
    function cargarDesdeRequest($request) {
        $this->idusuario = $request->input('id')!= "0" ? $request->input('id') : $this->idusuario;
        $this->usuario =$request->input('txtUsuario');
        $this->nombre = $request->input('txtNombre');
        $this->apellido = $request->input('txtApellido');
        $this->mail =  $request->input('txtEmail');
        $this->cantidad_bloqueo = $request->input('txtBloqueo');
        $this->activo = $request->input('lstEstado');
        $this->areapredeterminada = $request->input('lstArea');
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.usuario',
            1 => 'A.nombre',
            2 => 'A.apellido',
            3 => 'A.created_at',
            4 => 'A.ultimo_ingreso',
            5 => 'A.root',
            6 => 'A.activo'
        );
        $sql = "SELECT 
                A.idusuario,
                A.usuario,
                A.nombre,
                A.apellido,
                A.created_at,
                A.ultimo_ingreso,
                A.root,
                A.activo
                FROM sistema_usuarios A
                WHERE 1=1";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.usuario LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.apellido LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function validarUsuario($usuario) {
            $sql = "SELECT DISTINCT 
                A.idusuario,
                A.usuario,
                A.clave,
                A.root,
                A.activo,
                A.nombre,
                A.apellido,
                A.areapredeterminada,
                B.idcliente
                FROM sistema_usuarios A
                LEFT JOIN clientes B ON A.idusuario = B.fk_idusuario
                WHERE usuario = '$usuario' AND activo= 1"; 
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function verificarExistenciaMail($mail){
        $sql = "SELECT 
            count (A.idusuario) as cantidad
            FROM sistema_usuarios A 
            WHERE A.mail = '$mail'"; 

        $lstRetorno = DB::select($sql);
        return $lstRetorno[0]->cantidad > 0;
    }

    public function encriptarClave($clave){
        $claveEncriptada = password_hash($clave, PASSWORD_DEFAULT);
        return $claveEncriptada;
    }

    public function validarClave($claveIngresada, $claveBBDD){
        return password_verify($claveIngresada, $claveBBDD);
    }

     public function insertar() {
        $now = new \DateTime();

            $sql = "INSERT INTO sistema_usuarios (
                    usuario,
                    cantidad_bloqueo,
                    activo,
                    created_at,
                    root,
                    apellido,
                    nombre,
                    mail,
                    areapredeterminada,
                    clave
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
            $result = DB::insert($sql, [
            		$this->usuario,
                    $this->cantidad_bloqueo,
                    ACTIVO, 
                    $now->format('Y-m-d H:i:s'),
                    0,
                    $this->apellido,
                    $this->nombre,
                    $this->mail,
                    $this->areapredeterminada,
                    $this->clave
                    ]);

            return $this->idusuario = DB::getPdo()->lastInsertId();
    }

    public function guardar() {
       $sql = "UPDATE sistema_usuarios SET
            usuario='$this->usuario',
            cantidad_bloqueo='$this->cantidad_bloqueo',
            apellido='$this->apellido',
            nombre='$this->nombre',
            mail='$this->mail',
            activo='$this->activo',
            areapredeterminada='$this->areapredeterminada'
            WHERE idusuario= ?"; 
        $affected = DB::update($sql, [$this->idusuario]);
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                A.idusuario,
                A.usuario,
                A.clave,
                A.mail,
                A.nombre,
                A.apellido,
                A.cantidad_bloqueo,
                A.activo,
                A.created_at,
                A.ultimo_ingreso,
                A.root,
                A.areapredeterminada
                FROM sistema_usuarios A
                WHERE A.activo = '1' ";

        $sql .= " ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerTodosDeTodosLosGrupos() {
        $sql = "SELECT 
                A.idusuario,
                A.usuario,
                A.mail,
                A.nombre,
                A.apellido,
                A.cantidad_bloqueo,
                A.activo,
                A.created_at,
                A.ultimo_ingreso,
                A.root,
                A.areapredeterminada
                FROM sistema_usuarios A
                WHERE A.activo = '1' ";

        $sql .= " ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorUsuario($usuario) {
        $sql = "SELECT
                    A.idusuario,
                    usuario,
                    A.mail,
                    A.nombre,
                    A.apellido,
                    cantidad_bloqueo,
                    activo,
                    created_at,
                    ultimo_ingreso,
                    root,
                    clave,
                    A.areapredeterminada
                    FROM sistema_usuarios A 
                    WHERE usuario = '$usuario'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idusuario =$lstRetorno[0]->idusuario;
            $this->usuario =$lstRetorno[0]->usuario;
            $this->mail =$lstRetorno[0]->mail;
            $this->nombre =$lstRetorno[0]->nombre;
            $this->apellido =$lstRetorno[0]->apellido;
            $this->cantidad_bloqueo =$lstRetorno[0]->cantidad_bloqueo;
            $this->activo =$lstRetorno[0]->activo;
            $this->clave =$lstRetorno[0]->clave;
            $this->areapredeterminada =$lstRetorno[0]->areapredeterminada;
            return $lstRetorno[0];
        }
        return null;
    }

    public function obtenerPorMail($mail) {
        $sql = "SELECT
                    A.idusuario,
                    usuario,
                    A.mail,
                    A.nombre,
                    A.apellido,
                    cantidad_bloqueo,
                    activo,
                    created_at,
                    ultimo_ingreso,
                    root,
                    clave,
                    A.areapredeterminada
                    FROM sistema_usuarios A 
                    WHERE mail = '$mail'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idusuario =$lstRetorno[0]->idusuario;
            $this->usuario =$lstRetorno[0]->usuario;
            $this->mail =$lstRetorno[0]->mail;
            $this->nombre =$lstRetorno[0]->nombre;
            $this->apellido =$lstRetorno[0]->apellido;
            $this->cantidad_bloqueo =$lstRetorno[0]->cantidad_bloqueo;
            $this->activo =$lstRetorno[0]->activo;
            $this->clave =$lstRetorno[0]->clave;
            $this->areapredeterminada =$lstRetorno[0]->areapredeterminada;
            return $lstRetorno[0];
        }
        return null;
    }

    public function actualizarFechaIngreso() {
        $fec = new \DateTime();
        $sql = "UPDATE sistema_usuarios SET
            ultimo_ingreso=?
            WHERE idusuario= ?";
        $affected = DB::update($sql, [$fec->format('Y-m-d H:i:s'), $this->idusuario]);
    }

    static function autenticado(){
        return Session::get('usuario_id') != null;
    }

       static function autogestionAutenticado(){
        return Session::get('usuarioalu') != null;
    }

    public function guardarToken($email, $token){
        $sql = "UPDATE sistema_usuarios SET
        token=?
        WHERE mail=?";
        $affected = DB::update($sql, [$token, $email]);
    }

    public function validarToken($mail, $token){
        $sql = "SELECT 
            count (A.idusuario) as cantidad
            FROM sistema_usuarios A 
            WHERE A.mail = '$mail' AND token = '$token'"; 
        $lstRetorno = DB::select($sql);
        return $lstRetorno[0]->cantidad > 0;
    }

    public function guardarClave($idUsuario, $clave){
        $sql = "UPDATE sistema_usuarios SET
        clave=?
        WHERE idusuario=?";
        $affected = DB::update($sql, [$clave, $idUsuario]);
    }
    public function obtenerPorIdusuario($idUsuario){
        $sql = "SELECT
        A.idusuario,
        A.mail,
        A.nombre,
        A.apellido
        FROM sistema_usuarios A 
        WHERE A.idusuario = '$idUsuario'";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

}

?>