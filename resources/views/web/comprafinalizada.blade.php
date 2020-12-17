@extends('web.plantilla')
@section('titulo', $titulo)

@section('breadcrumb')
<div id="breadcrumb" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb-tree">
                    <li><a href="/">Inicio</a></li>
                    <li><a href="/checkout">checkout</a></li>
                    <li><a href="/">Compra Finalizada</a></li>
                </ul>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>

@endsection

@section('contenido')
<h2 class="title text-center text-uppercase mb-2">¡FELICITACIONES {{$usuario}} SU COMPRA FUE REALIZADA EXITOSAMENTE!</h2>
<div class="alert alert-success text-center mt-3" role="alert">
    GRACIAS POR SU COMPRA UN EMAIL FUE ENVIADO A SU CORREO
</div>

<div class="container div-fin ">
    <div class="row ">
        <div class="col-md-3"></div>
        <div class="col-md-6  order-details">
            <div class="section-title text-center">
                <h3 class="title">DETALLE DE SU COMPRA</h3>
            </div>
            <div class=" mt-3">
                <div class="mb-3">
                    <div class="compra text-center mt-2"><strong>COMPRAS</strong></div>
                </div>
                @foreach ( $array_venta as $venta)
                <div class="order-products ">
                    <div class="order-col">
                        <div class="text-center ">
                            <strong>{{$venta->producto}}</strong>
                            
                            <div class="product-img">
                                <img src="{{$venta->foto}}" alt="{{$venta->descripcion}}">
                            </div>
                        </div>
                    </div>
                    <div class="order-col">
                        <div><strong>DETALLES:</strong>
                            {{$venta->descripcion}}
                        </div>
                    </div>
                    <div class="order-col">
                        <div><strong>CANTIDAD:</strong>
                            {{$venta->cantidad}} Unidades
                        </div>
                    </div>
                    <div class="order-col">
                        <div><strong>DESTINATARIO:</strong>
                            @if($venta->fk_iddireccion_envio !="")
                                @foreach($array_direccionEnvio as $direccionEnvio)
                                @if($venta->fk_iddireccion_envio = $direccionEnvio->iddireccion_envio)
                                <span>{{$direccionEnvio->nombre}} , {{$direccionEnvio->apellido}}</span>
                                @endif
                                @endforeach
                                @endif
                                @if($venta->fk_iddireccion_otra !="")
                                @foreach($array_direccionOtra as $direccionOtra)
                                @if($venta->fk_iddireccion_otra = $direccionOtra->iddireccion_otra)
                                <span>{{$direccionOtra->nombre}}  {{$direccionOtra->apellido}} </span>
                                @endif
                                @endforeach
                                @endif
                        </div>
                    </div>
                    <div class="order-col">
                        <div><strong>DOMICILIO DE ENTREGA:</strong>
                            @if($venta->fk_iddireccion_envio !="")
                            @foreach($array_direccionEnvio as $direccionEnvio)
                            @if($venta->fk_iddireccion_envio = $direccionEnvio->iddireccion_envio)
                            <span>{{$direccionEnvio->domicilio}} , {{$direccionEnvio->ciudad}} , {{$direccionEnvio->provincia}} , {{$direccionEnvio->pais}}</span>
                            @endif
                            @endforeach
                            @endif
                            @if($venta->fk_iddireccion_otra !="")
                            @foreach($array_direccionOtra as $direccionOtra)
                            @if($venta->fk_iddireccion_otra = $direccionOtra->iddireccion_otra)
                            <span>{{$direccionOtra->domicilio}} , {{$direccionOtra->ciudad}} , {{$direccionOtra->provincia}} , {{$direccionOtra->pais}}</span>
                            @endif
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <hr>
                    
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- /Order Details -->
@endsection