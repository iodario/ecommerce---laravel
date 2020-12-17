@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')
<script>
    globalId = '<?php echo isset($vendedor->idvendedor) && $vendedor->idvendedor > 0 ? $vendedor->idvendedor : 0; ?>';
    <?php $globalId = isset($vendedor->idvendedor) ? $vendedor->idvendedor : "0"; ?>

</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/vendedores">Vendedores</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/vendedor/nuevo" class="fas fa-plus"
            aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fas fa-save" aria-hidden="true"
            onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Guardar" href="#" class="fas fa-trash" aria-hidden="true"
            onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fas fa-sign-out-alt" aria-hidden="true"
            onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir() {
    location.href = "/sistema/menu";
}
</script>
@endsection
@section('contenido')
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div class="panel-body">
    <div id="msg"></div>
    <?php
        if (isset($msg)) {
            echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
        }
        ?>
    <form id="form1" method="POST">
        <div class="row">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
            <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
            <div class="form-group col-lg-6">
                <label>Usuario: *</label>
                <select id="lstUsuario" name="lstUsuario" class="form-control">
                <option value="" disabled selected>Seleccionar</option>
                    @for ($i = 0; $i < count($array_usuario); $i++)
                            @if (isset($vendedor) and $array_usuario[$i]->idusuario == $vendedor->fk_idusuario)
                                <option selected value="{{ $array_usuario[$i]->idusuario }}">{{ $array_usuario[$i]->nombre }} {{ $array_usuario[$i]->apellido }}</option>
                            @else
                                <option value="{{ $array_usuario[$i]->idusuario }}">{{ $array_usuario[$i]->nombre }} {{ $array_usuario[$i]->apellido }}</option>
                            @endif
                        @endfor      
                </select>
            </div>
            
            <div class="form-group col-lg-6">
                <label>Sucursal: *</label>
                <select id="lstSucursal" name="lstSucursal" class="form-control" required>
                <option value="" disabled selected>Seleccionar</option>
                    @for ($i = 0; $i < count($array_sucursal); $i++)
                            @if (isset($vendedor) and $array_sucursal[$i]->idsucursal == $vendedor->fk_idsucursal)
                                <option selected value="{{ $array_sucursal[$i]->idsucursal }}">{{ $array_sucursal[$i]->direccion }}</option>
                            @else
                                <option value="{{ $array_sucursal[$i]->idsucursal }}">{{ $array_sucursal[$i]->direccion }}</option>
                            @endif
                        @endfor              
                </select>
            </div>
            <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
            <div class="form-group col-lg-6">
                <label>CUIL:</label>
                <input type="text" id="txtCuil" name="txtCuil" class="form-control" value="{{ $vendedor->cuil or '' }}">        
            </div>
        </div>

</div>
</form>
</div>
<div class="modal fade" id="mdlEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar registro?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">¿Deseas eliminar el registro actual?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" onclick="eliminar();">Sí</button>
            </div>
        </div>
    </div>
</div>
<script>
$("#form1").validate();

function guardar() {
    if ($("#form1").valid()) {
        modificado = false;
        form1.submit();
    } else {
        $("#modalGuardar").modal('toggle');
        msgShow("Corrija los errores e intente nuevamente.", "danger");
        return false;
    }
}

function eliminar() {
    $.ajax({
        type: "GET",
        url: "{{ asset('admin/sistema/menu/eliminar') }}",
        data: {
            id: globalId
        },
        async: true,
        dataType: "json",
        success: function(data) {
            if (data.err = "0") {
                msgShow("Registro eliminado exitosamente.", "success");
                $("#btnEnviar").hide();
                $("#btnEliminar").hide();
                $('#mdlEliminar').modal('toggle');
            } else {
                msgShow("Error al eliminar", "success");
            }
        }
    });
}
</script>
@endsection