@extends('web.plantilla')
@section('titulo', "$titulo")
@section('breadcrumb')
<div id="breadcrumb" class="section">
    <!--container-->
    <div class="container">
        <!--row-->
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb-tree">
                    <li><a href="/micuenta">Mi Cuenta</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section ('contenido')
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <form method="POST">
                <div class="col-md-5">
                <div class="form-group">
                        <label for="txtUsuario">Nombre de usuario*</label>
                        <input type="text" class="form-control" name="txtUsuario" id="txtUsuario" required value="{{ $aCliente[0]->usuario or ''}}">
                    </div>
                    <div class="form-group">
                        <label for="txtNombre">Nombre *</label>
                        <input type="text" class="form-control" name="txtNombre" id="txtNombre" required value="{{ $array_usuario[0]->nombre or ''}}">
                    </div>
                    <div class="form-group">
                        <label for="txtApellido">Apellido *</label>
                        <input type="text" class="form-control" name="txtApellido" id="txtApellido" required value="{{ $array_usuario[0]->apellido or ''}}">
                    </div>
                    <div class="form-group">
                        <label for="txtEmail">Mail *</label>
                        <input type="text" class="form-control" name="txtEmail" id="txtEmail" required value="{{ $array_usuario[0]->mail or ''}}">
                    </div>
                    <div class="form-group">
                        <label for="txtTelefono">Número De teléfono*</label>
                        <input type="text" class="form-control" name="txtTelefono" id= "txtTelefono" required value="{{ $aCliente[0]->telefono or ''}}">
                    </div>

                    <div class="form-group">
                        <label for="txtFechaNac">Fecha de nacimiento*</label>
                        <input type="Date" class="form-control" name="txtFechaNac" id= "txtFechaNac" required value="{{ $aCliente[0]->fecha_nac or ''}}">
                    </div>
                  
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection