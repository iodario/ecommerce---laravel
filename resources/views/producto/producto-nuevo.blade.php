@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')

<script>
   globalId = '<?php echo isset($producto->idproducto) && $producto->idproducto > 0 ? $producto->idproducto : 0; ?>';
    <?php $globalId = isset($producto->idproducto) ? $producto->idproducto : "0"; ?>*/

</script>

@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/sistema/menu">Men&uacute;</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/sistema/menu/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fas fa-save" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Guardar" href="#"  class="fas fa-trash" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fas fa-sign-out-alt" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
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
    <form id="form1" method="POST" enctype="multipart/form-data">
        <div class="row">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
            <input type="hidden" id="id" name="id" class="form-control" value="{{ $producto->idproducto}}" required>
            <div class="form-group col-lg-6">
                <label>Nombre:</label>
                <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{ $producto->nombre or '' }} " required>
            </div>

            <div class="form-group col-lg-6">
                <label>Descripción:</label>
                <input class="form-control" type="text" name="txtDescripcion" id="txtDescripcion" cols="30" rows="10" value="{{ $producto->descripcion or '' }}">
            </div>

            <div class="form-group col-lg-6">
                <label>Foto</label>
                <input type="file" id="archivo" name="archivo" class="form-control" value="{{$producto->foto or ''}}" multiple>
            </div>
            <div class="form-group col-lg-6">
                <label>Vídeo</label>
                <input type="text" id="archivoVideo" name="txtVideo" class="form-control" value="{{$producto->video or ''}}" placeholder="Ingresar url de YouTube">
            </div>
            <div class="form-group col-lg-6">
                <label>Stock</label>
                <input type="number" id="txtStock" name="txtStock" class="form-control" value="{{$producto->stock or ''}}">
            </div>
            <div class="form-group col-lg-6">
                <label>Precio AR$</label>
                <input type="number" id="txtPrecio" name="txtPrecio" class="form-control" value="{{$producto->precio or ''}}">
            </div>
            <div class="form-group col-lg-6">
                <label>Precio AR$ con descuento</label>
                <input type="number" id="txtPrecioDesc" name="txtPrecioDesc" class="form-control" value="{{$producto->precio_con_descuento or ''}}">
            </div>
            <div class="form-group col-lg-6">
                <label>Precio U$D</label>
                <input type="number" id="txtPrecioUsd" name="txtPrecioUsd" class="form-control" value="{{$producto->precio or ''}}">
            </div>
            <div class="form-group col-lg-6">
                <label>Precio U$D con descuento</label>
                <input type="number" id="txtPrecioDescUsd" name="txtPrecioDescUsd" class="form-control" value="{{$producto->precio_con_descuento or ''}}">
            </div>
            <div class="form-group col-lg-6">
                <label>Etiqueta</label>
                <input type="text" id="txtEtiqueta" name="txtEtiqueta" class="form-control" value="{{$producto->etiqueta or ''}}">
            </div>
            <div class="form-group col-lg-6">
                <label>Sucursal</label>
                <select name="lstSucursal" id="lstSucursal" class="form-control">
                    <option selected disabled value="">Seleccionar</option>
                    @for ($i = 0; $i < count($array_sucursal); $i++)
                     @if(isset($producto) and $array_sucursal[$i]->idsucursal == $producto->fk_idsucursal)
                        <option selected value="{{ $array_sucursal[$i]->idsucursal}}">{{ $array_sucursal[$i]->direccion}}</option>
                        @else
                        <option value="{{ $array_sucursal[$i]->idsucursal }}">{{ $array_sucursal[$i]->direccion}}</option>
                     @endif
                   @endfor
                </select>            
            </div>
            <div class="form-group col-lg-6">
                <label>Categoria:</label>
                <select name="lstCategoria" id="lstCategoria" class="form-control">
                    <option selected disabled value="">Seleccionar</option>
                    @for ($i = 0; $i < count($aCategoria); $i++)
                     @if(isset($producto) and $aCategoria[$i]->idcategoria == $producto->fk_idcategoria)
                        <option selected value="{{ $aCategoria[$i]->idcategoria}}">{{ $aCategoria[$i]->nombre}}</option>
                        @else
                        <option value="{{ $aCategoria[$i]->idcategoria }}">{{ $aCategoria[$i]->nombre}}</option>
                     @endif
                   @endfor
                </select>            
            </div>
             <div class="form-group col-lg-6">
                <label>Marca</label>
                <select name="txtMarca" id="txtMarca" class="form-control">
                    <option selected disabled value="">Seleccionar</option>
                    @for ($i = 0; $i < count($array_marca); $i++)
                     @if(isset($producto) and $array_marca[$i]->idmarca == $producto->fk_idmarca)
                        <option selected value="{{ $array_marca[$i]->idmarca}}">{{ $array_marca[$i]->nombre}}</option>
                        @else
                        <option value="{{ $array_marca[$i]->idmarca }}">{{ $array_marca[$i]->nombre}}</option>
                     @endif
                   @endfor
                </select>            
            </div>
        </div>

</div>
</div>
</form>
</div>
<div class="modal fade" id="mdlEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            url: "{{ asset('/admin/producto/eliminar') }}",
            data: { id:globalId },
            async: true,
            dataType: "json",
            success: function (data) {
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