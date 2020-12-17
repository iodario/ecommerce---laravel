<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Producto;
use App\Entidades\TransferenciaBancaria;
use App\Entidades\Carrito_Compra;
use App\Entidades\Direccion_otra;
use App\Entidades\Localidad;
use App\Entidades\Venta;
use Session;
use App\Entidades\Moneda;
use App\Entidades\Provincia;
use App\Entidades\Pais;
use App\Entidades\Direccion_envio;
use App\Entidades\Categoria;
use PHPMailer\PHPMailer\PHPMailer;
use MercadoPago\Item;
use MercadoPago\MerchantOrder;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\Preference;
use MercadoPago\SDK;
use App\Entidades\MercadoPago;


class ControladorWebCheckout extends Controller
{
    public function index(Request $request)
    {

        if (Usuario::autenticado()) {

            $titulo = "Checkout";
            $entidadTransferencia = new TransferenciaBancaria();
            $array_transf = $entidadTransferencia->obtenerTodos();
            $idUsuario = Session::get('usuario_id');
            $entidadUsuario = new Usuario();
            $array_usuario = $entidadUsuario->obtenerPorIdusuario($idUsuario);
            $idCliente = Session::get('cliente_id');
            $entidadCarrito = new Carrito_Compra();
            $array_carrito = $entidadCarrito->obtenerPorCliente($idCliente);
            $categoria = new Categoria();
            $array_categoria = $categoria->obtenerTodos();

            $entidadPais = new Pais();
            $array_paises = $entidadPais->obtenerTodos();

            if (count($array_carrito) > 0) {
                $sumaTotal = 0;
                for ($i = 0; $i < count($array_carrito); $i++) {

                    $idcarrito = $array_carrito[$i]->idcarrito;
                    $cantidad = $array_carrito[$i]->cantidad;
                    $producto = $array_carrito[$i]->producto;
                    $precioUni = '$' . number_format($array_carrito[$i]->precio, '2', ',', '.');
                    $tot = $array_carrito[$i]->precio * $array_carrito[$i]->cantidad;
                    $precioTotal = '$' . number_format($tot, '2', ',', '.');
                    $sumaTotal = $sumaTotal + $tot;
                    $aCarrito[] = array(
                        'idcarrito' => $idcarrito,
                        'cantidad' => $cantidad,
                        'producto' => $producto,
                        'precioUni' => $precioUni,
                        'precio' => $precioTotal,

                    );
                }
                $sumaTotal =  number_format($sumaTotal, '2', ',', '.');
                $moneda = new Moneda;
                $array_moneda = $moneda->obtenerTodos();

                return view('web.checkout', compact('titulo', 'array_transf', 'aCarrito', 'sumaTotal', 'array_moneda', 'array_usuario', 'array_paises', 'array_categoria'));
            } else {
                return redirect('/');
            }
        } else {
            $titulo = "Login";
            $msg["MSG"] = "Inicie sesión para continuar";
            $msg["ESTADO"] = MSG_ERROR;
            return redirect('/login');
        }
    }

    public function cargarVenta(Request $request)
    {
        $idUsuario = Session::get('usuario_id');
        $entidadUsuario = new Usuario();
        $array_usuario = $entidadUsuario->obtenerPorIdusuario($idUsuario);
        
        if (isset($_POST['idEliminar']) && $_POST['idEliminar'] != "") {
            $idProducto =  $_POST['idEliminar'];
            $entidadCarrito = new Carrito_compra();
            $entidadCarrito->eliminarPorIdCarrito($idProducto);
            return redirect('/checkout');
        }
        if (isset($_POST['provincia']) && $_POST['provincia'] != "") {
            $idpais = $_POST['provincia'];
            $entidadProvincia = new Provincia();
            $array_provincia = $entidadProvincia->obtenerPorIdPais($idpais);
            return $array_provincia;
        }
        if (isset($_POST['localidad']) && $_POST['localidad'] != "") {
            $idlocalidad = $_POST['localidad'];
            $entidadlocalidad = new Localidad();
            $array_localidades = $entidadlocalidad->obtenerPorIdProvincia($idlocalidad);
            return $array_localidades;
        }

        $titulo = "Compra Realizada";
        $idCliente = Session::get('cliente_id');
        $entidadCarrito = new Carrito_Compra();
        $array_carrito = $entidadCarrito->obtenerPorCliente($idCliente);
        $usuario = Session::get('usuario_nombre');
        if (isset($_POST['txtEmail'])){
            $email = $_POST['txtEmail'];
           
        } else {
            $email = $_POST['txtEmailAdd'];
        }
    
        $entidadVenta = new Venta();
        $medioDePago = $request->chk_venta;
        if (isset($_REQUEST['checkout'])) {
            $idDireccionEnvio = "NULL";
            $entidadDomicilio = new Direccion_otra();
            $entidadDomicilio->cargarDesdeRequest($request);
            $entidadDomicilio->insertar();
            $idDomicilio = $entidadDomicilio->iddireccion;
            for ($i = 0; $i < count($array_carrito); $i++) {
                $idcarrito = $array_carrito[$i]->idcarrito;
                $cantidad = $array_carrito[$i]->cantidad;
                $idproducto = $array_carrito[$i]->fk_idproducto;
                $precioUni = $array_carrito[$i]->precio;
                $total = $array_carrito[$i]->precio * $array_carrito[$i]->cantidad;;
                $fecha = date('Y-m-d H:i');
                $lstNuevaVenta = $entidadVenta->nuevaVenta($cantidad, $precioUni, $total, $fecha, $medioDePago, $idCliente, $idproducto, $idDomicilio, $idDireccionEnvio);
            }

            $entidadCarrito->eliminarPorCliente($idCliente);
            
        } else {
            $idDomicilio = "NULL";
            $entidadDireccionEnvio = new Direccion_envio();
            $entidadDireccionEnvio->cargarDesdeRequest($request);
            $idDireccionEnvio = $entidadDireccionEnvio->insertar();
            for ($i = 0; $i < count($array_carrito); $i++) {
                $cantidad = $array_carrito[$i]->cantidad;
                $idproducto = $array_carrito[$i]->fk_idproducto;
                $precioUni = $array_carrito[$i]->precio;
                $total = $array_carrito[$i]->precio * $array_carrito[$i]->cantidad;;
                $fecha = $fecha = date('Y-m-d H:i');
                $lstNuevaVenta = $entidadVenta->nuevaVenta($cantidad, $precioUni, $total, $fecha, $medioDePago, $idCliente, $idproducto, $idDomicilio, $idDireccionEnvio);
            }
            $entidadCarrito->eliminarPorCliente($idCliente);
        }

        if ($lstNuevaVenta != "" ) {
            $fecha = date('Y-m-d H:i');
           
            $array_venta = $entidadVenta->obtenerVentaPorEmailNoEnv($fecha);
            
            if ($array_venta != "") {
                for ($i = 0; $i < count($array_venta); $i++) {

                    if (isset($_REQUEST['checkout'])) {
                        $entidadDireccionEnvio = new Direccion_envio();
                        $idDomicilioOtro = $array_venta[$i]->fk_iddireccion_otra;
                        $array_direccion = $entidadDomicilio->obtenerPorIdDireccion($idDomicilioOtro);

                    } else {
                        $entidadDomicilio = new Direccion_otra();
                        $idDireccionEnvio = $array_venta[$i]->fk_iddireccion_envio;
                        $array_direccion = $entidadDireccionEnvio->obtenerPorIdDireccion($idDireccionEnvio);
                      
                    }

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
                        $mail->Subject = "Compraste" . $array_venta[$i]->producto . "el día" . $array_venta[$i]->fecha;

                        $html    = "Hola" . $usuario . "felicitaciones su compra fue realizada sactifactoriamente" . "<br>" . "Descripcion de su compra. " . "<br>" . "<br> ";
                        $html .= $array_venta[$i]->producto . "<br>" . "<br>";
                        $html .= "Cantidad:" . $array_venta[$i]->cantidad  . "<br>";
                        $html .= "Precio:" . $array_venta[$i]->preciounitario . "<br>";
                        $html .= "Domicilio de entrega:" . $array_direccion[$i]->domicilio . "," . $array_direccion[$i]->cp . "," . $array_direccion[$i]->ciudad . ";" . $array_direccion[$i]->provincia . "," . $array_direccion[$i]->pais . "<br>";
                        $html .= "Persona que recibe :" . $array_direccion[$i]->nombre . "," . $array_direccion[$i]->apellido . "<br>";
                        $html .= "Envio: Gratis" . "<br>" . "<br>";
                        $html .= "Saludos";



                        $mail->Body = utf8_decode($html);
                        // $mail->send();
                        //$msg["ESTADO"] = MSG_SUCCESS;
                        //$msg["MSG"] = "Operación realizada correctamente.";
                        //echo json_encode($msg);
                       
                        return redirect('/checkout/comprafinalizada');
                        exit;
                    } catch (Exception $e) {
                        //$msg["ESTADO"] = MSG_ERROR;
                        //$msg["MSG"] = "Error al enviar el correo.";
                        return redirect('/checkout/comprafinalizada');
                        exit;
                    }
                }
            }
        }
        if ($_POST['chk_venta'] == 2) {
            // print_r($_POST);
            // exit;
            $entidadMercadoPago = new MercadoPago();
            $mercadoPago = $entidadMercadoPago->obtener();
            $precioTotal = ($_POST['txtVentaTotal']);
        
            SDK::setClientId(
                config("payment-methods.mercadopago.client")
            );
            SDK::setClientSecret(
                config("payment-methods.mercadopago.secret")
            );
            SDK::setAccessToken("$mercadoPago->token_acceso");

            $item = new Item();
            $item->id = "1234";
            $item->title = " Compra tienda Online";
            $item->category_id = "services";
            $item->quantity = 1;
            $item->currency_id = "ARS";
            //$item->unit_price = $precioTotal; 
            //$preference->items = array($item);
            $payer = new Payer();
            $payer->name = $array_usuario[0]->nombre;
            $payer->surname = $array_usuario[0]->apellido;
            $payer->email = $array_usuario[0]->mail;
            $payer->date_created = date('Y-m-d H:m');
            // $payer->identification = array(
            //     "type" => "CUIT",
            //     "number" => $cliente->cuit
            // );
            // $preference->payer = $payer;
            // $preference->back_urls = [
            //     "success" => "http://127.0.0.1:8000/venta_aprobada/" . $idVenta. ",
            //     "pending" => "http://127.0.0.1:8000/venta_pendiente/" . $idVenta .",
            //     "failure" => "http://127.0.0.1:8000/venta_error/" . $idVenta .",
            // ];
            // $preference->payment_methods = array(
            //     "installments" => 6
            // );
            // $preference->auto_return = "all";

            // $preference->notification_url = '';

            // $preference->save();

            //header("Location: " . $preference->init_point);
            return redirect('/checkout/comprafinalizada');
            exit;
        }
        
    }
    public function compraFinalizada()
    {
        $titulo = "Compra Realizada";
        $moneda = new Moneda;
        $array_moneda = $moneda->obtenerTodos();
        $entidadVenta = new Venta();
        $categoria = new Categoria();
        $array_categoria = $categoria->obtenerTodos();
        $idCliente = Session::get('cliente_id');
        $fecha = date('Y-m-d H:i' );
        $array_venta = $entidadVenta->obtenerVentaPorCliente($idCliente,$fecha);
        $array_direccionOtra=array();
       
        if($array_venta !=null){
           
            $usuario = Session::get('usuario_nombre');
            

            foreach ($array_venta as $venta) {
                if ($venta->fk_iddireccion_envio != null) {
                    $idDomcilioEnvio = $venta->fk_iddireccion_envio;
                    $entidadDireccionEnvio = new Direccion_envio();
                    $array_direccionEnvio = $entidadDireccionEnvio->obtenerPorIdDireccion($idDomcilioEnvio);
                } else {
                    $idDomcilioOtro = $venta->fk_iddireccion_otra;
                    $entidadDireccionEnvio = new Direccion_otra();
                    $array_direccionOtra = $entidadDireccionEnvio->obtenerPorIdDireccion($idDomcilioOtro);
                }
            }
    
            return view('web.comprafinalizada', compact('array_moneda', 'titulo', 'array_venta', 'array_direccionOtra', 'array_direccionEnvio', 'usuario','array_categoria'));
        }else{
            return redirect('/checkout');
        }
       
    }
    public function eliminarProductoCarrito(Request $request, $id)
    {
        $entidadCarrito = new Carrito_compra();
        $entidadCarrito->eliminarPorIdCarrito($id);
        return redirect('/checkout');
    }
}
