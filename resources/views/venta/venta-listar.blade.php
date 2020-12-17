@extends('plantilla')

@section('titulo', "Listado de ventas")

@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item active">Ventas</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a  title="Recargar" href="/admin/ventas" class="fa fa-refresh" area-hidden="true" onclick='window.location.replace("/admin/ventas")'><span>Recargar</span></a></li>
</ol>
@endsection
@section('contenido')
<?php

if(isset($msg)){
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<table id="grilla" class="display">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio unitario</th>
            <th>Total</th>
            <th>Cliente</th>
            <th>Medio de pago</th>
        </tr>
    </thead>
</table>
<script>
    var dataTable = $('#grilla').DataTable({
        "processing": true,
        "serverSide": true,
        "bFilter": true,
        "bInfo": true,
        "bSearchable": true,
        "pageLength": 25,
        "order": [[ 0, "asc" ]],
        "ajax": "{{ route('venta.cargarGrilla') }}"
    });
</script>
@endsection