@extends('web.plantilla')
@section('titulo', "$titulo")

@section('breadcrumb')
<!-- /BREADCRUMB -->
<div id="breadcrumb" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <h3 class="breadcrumb-header">Registro</h3>
                <ul class="breadcrumb-tree">
                    <li><a href="/">Volver a Home</a></li>
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
        <?php if(isset($msg) && $msg != ""){  ?>
                <div class="alert alert-primary" role="alert">
                  <?php echo $msg; ?>
                </div>';
        <?php } ?>
        <form method="POST" class="register">
                <div class="col-md-5">
                <div class="form-group">
                        <label for="txtUsuario">Nombre de usuario*</label>
                        <input type="text" class="form-control" name="txtUsuario" id="txtUsuario" required>
                    </div>
                    <div class="form-group">
                        <label for="txtNombre">Nombre *</label>
                        <input type="text" class="form-control" name="txtNombre" id="txtNombre" required>
                    </div>
                    <div class="form-group">
                        <label for="txtApellido">Apellido *</label>
                        <input type="text" class="form-control" name="txtApellido" id="txtApellido" required>
                    </div>
                    <div class="form-group">
                        <label for="txtEmail">Mail *</label>
                        <input type="text" class="form-control" name="txtMail" id="txtMail" required>
                    </div>
                    <div class="form-group">
                        <label for="txtTelefono">Número De teléfono*</label>
                        <input type="text" class="form-control" name="txtTelefono" id= "txtTelefono" required>
                    </div>

                    <div class="form-group">
                        <label for="txtFechaNac">Fecha de nacimiento*</label>
                        <input type="Date" class="form-control" name="txtFechaNac" id= "txtFechaNac" required>
                    </div>
                    <div class="form-group">
                        <label for="txtClave">Clave* </label>
                        <input type="password" class="form-control" name="txtClave" id= "txtClave" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Terminar registro</button>
                </div>
            </form>

        </div>
    </div>
</div>

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