@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')

@endsection
@section('contenido')
<br>
<div class="col-lg-12">
    <div id = "msg-error" class="alert alert-danger">
        <p><strong>&#161;Error&#33;</strong></p>{{ $mensaje }} </p><p>Err: {{ $codigo }}</p>
    </div>
</div>
@endsection