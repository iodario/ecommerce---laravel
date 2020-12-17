@extends('plantilla')
@section('titulo', "Datos del permiso")
@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script>
    globalId = '<?php echo isset($permiso->idfamilia) && $permiso->idfamilia > 0 ? $permiso->idfamilia : 0; ?>';
    <?php $globalId = isset($permiso->idfamilia) ? $permiso->idfamilia : "0"; ?>

</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/permisos">Permisos</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/permiso/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/admin/permisos";
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

<div class="row">
    <div id = "msg"></div>
    <?php
    if (isset($msg)) {
        echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
    }
    ?>
</div>
<form id="form1" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
    <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
    <div class="row">
        <div class="form-group col-lg-12">
            <label>Nombre: *</label>
            <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{$permiso->nombre or ''}}" required>
        </div>
        <div class="form-group col-lg-12">
            <label>Descripci&oacute;n:</label>
            <textarea id="txtDescripcion" name="txtDescripcion" class="form-control"><?php echo isset($permiso) ? $permiso->descripcion : ""; ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-table"></i> Patentes asignadas
                    <div class="pull-right">
                        <button type="button" class="btn btn-secondary fa fa-minus-circle" onclick="abrirDialogoEliminarPatenteFamilia()"></button>
                        <button type="button" class="btn btn-secondary fa fa-plus-circle" onclick="abrirAgregarPatentes()"></button>
                    </div>
                </div>
                <div class="panel-body">
                        <table id="grilla" class="display">
                            <thead>
                                <tr>
                                    <th>patente_id</th>
                                    <th></th>
                                    <th>Descripci&oacute;n</th>
                                    <th>Tipo</th>
                                    <th>M&oacute;dulo</th>
                                    <th>Subm&oacute;dulo</th>
                                    <th>Identificador</th>
                                </tr>
                            </thead>
                        </table> 
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal -->
<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="display: inline-table">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBuscarLabel">Patentes del sistema</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                    <table id="grillaPatentes" class="display">
                        <thead>
                            <tr>
                                <th>patente_id</th>
                                <th></th>
                                <th>Descripci&oacute;n</th>
                                <th>Tipo</th>
                                <th>M&oacute;dulo</th>
                                <th>Subm&oacute;dulo</th>
                                <th>Identificador</th>
                            </tr>
                        </thead>
                    </table> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="agregarPatentesGrilla();">Agregar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalmsg" tabindex="-1" role="dialog" aria-labelledby="modalmsg">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBuscarLabel">Eliminar</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-lg-6">
                    &#191;Desea confirmar la operacion?
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="eliminarPatenteFamilia();">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script>

    //Define constantes
    globalId = '<?php echo (isset($_REQUEST["id"]) ? $_REQUEST["id"] : "0"); ?>';

    $("#form1").validate();
    cargarGrillaPatentes();
    cargarGrilla();
    $('#modalBuscar').modal({
        show: 'false'
    });

    function guardar() {
        if ($("#form1").valid()) {
            $('#form1').append($($('#grilla input[type=checkbox]').prop('checked', true)));
            modificado = false;
            form1.submit(); 
        } else {
            $("#modalGuardar").modal('toggle');
            msgShow("Corrija los errores e intente nuevamente.", "danger");
            return false;
        }
    }

    function fasignar_descuento() {
        $('#lstServicio_noasig option:selected').remove().appendTo('#lstServicio_asig');
    }
    function fdesasignar_descuento() {
        $('#lstServicio_asig option:selected').remove().appendTo('#lstServicio_noasig');
    }

    function cargarGrilla() {
          var grilla = $('#grilla').DataTable({
            "processing": true,
            "serverSide": false,
            "bFilter": false,
            "bInfo": true,
            "bSearchable": false,
            "paging": false,
            "ajax": "{{ asset('/admin/permiso/cargarGrillaPatentesPorFamilia?fam='.$globalId) }}",
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
               ]
        });
       /* .done(function (data) {
            obj = $.parseJSON(data);
            grilla = $('#grilla').DataTable();
            $.each(obj, function (key, value) {
                grilla.row.add(value).draw().node();
                $("#chk_PatenteAdd_" + value[0]).prop("checked", true);

            });
        });*/
    }

    function cargarGrillaPatentes() {
         var grilla = $('#grillaPatentes').DataTable({
            "processing": true,
            "serverSide": true,
            "bFilter": true,
            "bInfo": true,
            "bSearchable": true,
            "pageLength": 10,
            "ajax": "{{ asset('/admin/permiso/cargarGrillaPatentesDisponibles?fam='.$globalId) }}",
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
               ]
        });
    }

    function abrirAgregarPatentes() {
        $('#modalAgregar').modal('toggle');
    }

    function agregarPatentesGrilla() {
        var grilla = $('#grilla').DataTable();
        var grillaPatentes = $('#grillaPatentes').DataTable();
        var pos = 0;

        $('#grillaPatentes input[type=checkbox]').each(function () {
            if (this.checked) {
                id = grillaPatentes.row(pos).data()[0];

                if ($("#chk_PatenteFamilia_" + id).prop("checked") == undefined) {
                    //Si no esta lo agrega
                    grilla.row.add([
                        grillaPatentes.row(pos).data()[0],
                        '<input id="chk_PatenteFamilia_' + grillaPatentes.row(pos).data()[0] + '" name="chk_PatenteFamilia_' + grillaPatentes.row(pos).data()[0] + '" value="' + grillaPatentes.row(pos).data()[0] + '" type="checkbox" />',
                        grillaPatentes.row(pos).data()[2],
                        grillaPatentes.row(pos).data()[3],
                        grillaPatentes.row(pos).data()[4],
                        grillaPatentes.row(pos).data()[5],
                        grillaPatentes.row(pos).data()[6]
                    ]).draw();
                }
            }
            pos++;
        });
        $('#modalAgregar').modal('toggle');
    }


    function abrirDialogeEliminarPatenteFamilia() {
        $('#modalmsg').modal('toggle');
    }
    function eliminarPatenteFamilia() {
        var grilla = $('#grilla').DataTable();
        $('#grilla input[type=checkbox]').each(function () {
            if (this.checked) {
                $(this.parentElement.parentNode).addClass('borrar');
            }
        });
        grilla.rows('.borrar').remove().draw(false);
        $('#modalmsg').modal('toggle');
    }

</script>
@endsection