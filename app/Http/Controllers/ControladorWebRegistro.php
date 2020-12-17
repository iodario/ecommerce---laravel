<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Incidente;
use App\Entidades\Estados_incidente;
use App\Entidades\respuesta_incidente;
use App\Entidades\Cliente;
use PHPMailer\PHPMailer\PHPMailer;
use App\Entidades\Moneda;
use Session;

class ControladorWebRegistro extends Controller
{
    public function index(Request $request){

        $titulo = "Registro";
        $moneda = new Moneda;
        $array_moneda = $moneda->obtenerTodos();
        return view('web.registro', compact('titulo','array_moneda'));
    }

    public function guardar(Request $request){
        
        $titulo = "Registro";

        
        $usuario = new Usuario();
        $usuario->usuario = $_REQUEST['txtUsuario'];
        $usuario->nombre = $_REQUEST['txtNombre'];
        $usuario->apellido = $_REQUEST['txtApellido'];
        $usuario->mail = $_REQUEST['txtMail'];
        $usuario->clave = $usuario->encriptarClave($_REQUEST['txtClave']);
        $usuario->root = 1;
        $usuario->cread_at = date('Y-m-d H:i:s');
        $usuario->cantidad_bloqueo = 0;
        $usuario->activo = 1;
        $idUsuario = $usuario->insertar();

        $cliente = new Cliente;
        $cliente->telefono = $_REQUEST['txtTelefono'];
        $cliente->fecha_nac = $_REQUEST['txtFechaNac'];
        $cliente->fk_idusuario = $idUsuario;

        $cliente->insertar();

       // $this->enviarCorreo($_REQUEST['txtMail'], $_REQUEST['txtClave'], $_REQUEST['txtUsuario'] );
        $msg = "Registro exitoso";
        return view('web.home', compact('titulo', 'msg', 'usuario', 'cliente')) ;

    }

    public function enviarCorreo($email, $clave, $usuario){
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
           
            //Server settings
            $mail->SMTPDebug = 0;                                           // Set mailer to use SMTP
            $mail->Host = env('MAIL_HOST');                         // Specify main and backup SMTP servers
            $mail->isSMTP();                                        
            $mail->SMTPAuth = false;  
           // $mail->Username = "info@dominio.com.ar";
           // $mail->password = "";                       // Enable TLS encryption, `ssl` also accepted
            $mail->Port = env('MAIL_PORT');                                    // TCP port to connect to

            //Recipients
            $mail->FromName = "";
            $mail->setFrom('roisbertalmenara@gmail.com', 'prueba');
            $mail->addAddress($email);
            $mail->addBCC('roisbertalmenara@gmail.com');
           // $mail->addReplyTo('admin@depcsuite.com');

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Alta de usuario.';
            $html    = "Hola, como estas?" . "<br>" . "Bienvenido a nuestro sistema. " . "<br>" . "<br> ";
            $html .= "Tus credenciales de acceso son: "."<br>" . "<br>";
            $html .= "Usuario:". $usuario ."<br>";
            $html .= "Clave:". $clave ."<br>" . "<br>";
            $html .= "Saludos";



            $mail->Body = utf8_decode($html);
            $mail->send();
            $msg["ESTADO"] = MSG_SUCCESS;
            $msg["MSG"] = "Operación realizada correctamente.";
            echo json_encode($msg);
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "Error al enviar el correo.";
        }

    }
}

?>