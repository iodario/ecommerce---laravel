@extends('web.plantilla')

@section('breadcrumb')
@section('titulo', $titulo)

<?php
if($_POST){ /* es postback */
    $nombre = $_POST["txtNombre"];
    $correo = $_POST["txtCorreo"];
    $asunto = $_POST["txtAsunto"];
    $mensaje = $_POST["txtMensaje"];

    if($nombre != "" && $correo != ""){
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = false;
        $mail->Host = "mail.dominio.com"; // SMTP a utilizar
        $mail->Username = "info@dominio.com.ar"; // Correo completo a utilizar
        $mail->Password = "aqui va la clave de tu correo";
        $mail->Port = 25;
        $mail->From = "info@dominio.com.ar"; //Desde la cuenta donde enviamos
        $mail->FromName = "Tu nombre a mostrar";
        $mail->IsHTML(true);
        

        //Destinatarios
        $mail->addAddress($correo);
        $mail->addBCC("otrocorreo@gmail.com"); //Copia oculta
        $mail->Subject = utf8_decode("Contacto página Web");
        $mail->Body = "Recibimos tu consulta, te responderemos a la brevedad.";
        if(!$mail->Send()){
            $msg = "Error al enviar el correo, intente nuevamente mas tarde.";
        }
        $mail->ClearAllRecipients(); //Borra los destinatarios

        //Envía ahora un correo a nosotros con los datos de la persona
        $mail->addAddress("info@dominio.com.ar");
        $mail->Subject = utf8_decode("Recibiste un mensaje desde tu página Web");
        $mail->Body = "Te escribio $nombre cuyo correo es $correo, con el asunto $asunto y el siguiente mensaje:<br><br>$mensaje";
       
        if($mail->Send()){ /* Si fue enviado correctamente redirecciona */
            header('Location: confirmacion-envio.php');
        } else {
            $msg = "Error al enviar el correo, intente nuevamente mas tarde.";
        }    
    } else {
        $msg = "Complete todos los campos";
    }

}

?>



<!-- /BREADCRUMB -->
<div id="breadcrumb" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <h3 class="breadcrumb-header">Contacto</h3>
                <br>
                <h4>Describa aquí su consulta y nuestro equipo se contactará a la brevedad</h4>
                <ul class="breadcrumb-tree">
                    <li><a href="/">Volver a Home</a></li>
                    <li><a href="/respuestaincidente">Ir a seguimiento de Incidentes</a></li>
                </ul>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
@endsection


@section('contenido')
<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">

            <form>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="txtNombre">Nombre *</label>
                        <input type="text" class="form-control" name="txtNombre" placeholder="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="txtNombre">Apellido *</label>
                        <input type="text" class="form-control" name="txtApellido" placeholder="apellido" required>
                    </div>
                    <div class="form-group">
                        <label for="txtDni">Dni *</label>
                        <input type="text" class="form-control" name="txtDni" placeholder="dni" required>
                    </div>

                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="txtNumeroFactura">Nro de Factura *</label>
                        <input type="text" class="form-control" name="txtNumeroFactura" placeholder="nro de factura" required>
                    </div>
                    <div class="form-group">
                        <label for="txtEmail">Email *</label>
                        <input type="email" class="form-control" name="txtEmail" placeholder="email" required>
                    </div>
                    <div class="form-group">
                        <label for="txtTelefono">Telefono *</label>
                        <input type="email" class="form-control" name="txtTelefono" placeholder="telefono" required>
                    </div>
                </div>
                <div class="col-md-5">

                    <div class="form-group">
                        <label for="txtConsulta">Consulta *</label>
                        <textarea cols="130" rows="10" name="txtConsulta" required></textarea>
                    </div>

                    <button type="submit" class="newsletter-btn" style="
    width: 160px;
    height: 40px;
    font-weight: 700;
    background: #D10024;
    color: #FFF;
    border: none;
    border-radius: 0px 40px 40px 0px;"><i class="fa fa-envelope"></i>Enviar</button>                    
                </div>
            </form>
        </div>
    </div>
</div>
<!-- SECTION -->

<!-- NEWSLETTER -->
<div id="newsletter" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="newsletter">
                    <p>Sign Up for the <strong>NEWSLETTER</strong></p>
                    <form>
                        <input class="input" type="email" placeholder="Enter Your Email">
                        <button class="newsletter-btn"><i class="fa fa-envelope"></i> Subscribe</button>
                    </form>
                    <ul class="newsletter-follow">
                        <li>
                            <a href="#"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /NEWSLETTER -->

@endsection
