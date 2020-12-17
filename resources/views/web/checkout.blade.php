@extends('web.plantilla')
@section('titulo', "$titulo")
@section('breadcrumb')

<div id="breadcrumb" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb-tree">
                    <li><a href="#">Incio</a></li>
                    <li><a href="#">Checkout</a></li>
                </ul>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /BREADCRUMB -->
@endsection
@section('contenido')


<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <form action="" method="POST" id="formCheckout">
            <!-- row -->
            <div class="row">

                <div class="col-md-6">
                    <!-- Billing Details -->
                    <div class="billing-details">
                        <div class="section-title">
                            <h3 class="title">DIRECCIÓN DE ENVIO</h3>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="txtToken"></input>
                        <div class="form-group">
                            <input class="input  " type="text" name="txtNombre" id="txtNombre" placeholder="Nombre" value="" required>
                        </div>
                        <div class="form-group">
                            <input class="input  " type="text" name="txtApellido" id="txtApellido" placeholder="Apellido" value="" required>
                        </div>
                        <div class="form-group">
                            <input class="input is-valid" type="email " name="txtEmail" id="txtEmail" placeholder="example@email.com" value="" required pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}">
                        </div>
                        <div class="form-group">
                            <input class="input  " type="text" name="txtDomicilio" id="txtDomicilio" placeholder="Domicilio" required>
                        </div>
                        <div class="form-group">
                            <select name="lstPais" id="lstPais" class="input selectpicker required" onchange="fBuscarProvincia();" required>
                                <option value="" selected>Pais</option>
                                @foreach ($array_paises as $pais)
                                <option value="{{$pais->idpais}}">{{$pais->descpais}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <select name="lstProvincia" id="lstProvincia" class="input selectpicker required" onchange="fBuscarLocalidad();" required>
                                <option value="" selected>Provincia</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <select name="lstCiudad" id="lstLocalidad" class="input selectpicker " required>
                                <option value="" selected>Localidades</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <input class="input  required" type="text" name="txtCp" id="txtCp" placeholder="Código Postal" required>
                        </div>
                        <div class="form-group">
                            <input class="input  required" type="telephone" name="txtTelefono" id="txtTelefono" placeholder="Teléfono" required>
                        </div>

                    </div>
                    <!-- /Billing Details -->

                    <!-- Shiping Details -->
                    <div class="shiping-details">
                        <div class="section-title">
                            <h3 class="title"></h3>
                        </div>
                        <div class="input-checkbox">
                            <input type="checkbox" id="shiping-txtDomicilio" name="checkout" class="chk_otroDomicilio" onchange="desabilitarInput();">
                            <label for="shiping-txtDomicilio">
                                <span></span>
                                ¿Enviar a otro Domicilio?
                            </label>
                            <div class="caption">
                                <div class="form-group">
                                    <input class="input " type="text" name="txtNombreAdd" placeholder="Nombre">
                                </div>
                                <div class="form-group">
                                    <input class="input " type="text" name="txtApellidoAdd" placeholder="Apellido">
                                </div>
                                <div class="form-group">
                                    <input class="input " type="email" name="txtEmailAdd" placeholder="example@email.com" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}">
                                </div>
                                <div class="form-group">
                                    <input class="input " type="text" name="txtDomicilioAdd" placeholder="Domicilio">
                                </div>

                                <div class="form-group">
                                    <select name="lstPaisAdd" id="lstPaisAdd" class="input selectpicker" onchange="fBuscarProvincia();">
                                        <option value="" selected>Pais</option>
                                        @foreach ($array_paises as $pais)
                                        <option value="{{$pais->idpais}}">{{$pais->descpais}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select name="lstProvinciaAdd" id="lstProvinciaAdd" class="input selectpicker" onchange="fBuscarLocalidad();">
                                        <option value="" selected>Provincia</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="lstCiudadAdd" id="lstLocalidadAdd" class="input selectpicker">
                                        <option value="" selected>Localidad</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <input class="input " type="text" name="txtCpAdd" placeholder="Código Postal">
                                </div>
                                <div class="form-group">
                                    <input class="input " type="tel" name="txtTelefonoAdd" placeholder="Teléfono">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Shiping Details -->

                    <!-- Order notes -->
                    <div class="order-notes">
                        <textarea class="input " name="txtComentario" placeholder="Adicionar Nota"></textarea>
                    </div>
                    <!-- /Order notes -->
                </div>

                <!-- Order Details -->
                <div class="col-md-6 order-details">
                    <div class="section-title text-center">
                        <h3 class="title">TU PEDIDO</h3>
                    </div>
                    <div class="order-summary">
                        <div class="order-col">
                            <div></div>
                            <div><strong>PRODUCTOS</strong></div>
                            <div><strong>CANTIDAD</strong></div>
                            <div><strong>PRECIO UNITARIO</strong></div>
                            <div><strong>TOTAL</strong></div>

                        </div>
                        @if(isset($aCarrito))
                        @foreach ($aCarrito as $carrito)
                        <div class="order-products">
                            <div class="order-col">
                                <div><a href="/checkout/{{$carrito['idcarrito']}}" class="ml-2 btn-sm btn-danger">X</a></div>
                                <div class="text-center" style="width:20%;">{{$carrito['producto']}}</div>
                                <div class="text-center" style="width:25%;">{{$carrito['cantidad']}}</div>
                                <div class="text-center" style="width: 35%;">{{$carrito['precioUni']}}</div>
                                <div class="" style="width:25%;">{{$carrito['precio']}}</div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <div class="order-col">
                            <div><strong>ENVÍO</strong></div>
                            <div><strong>GRATIS</strong></div>
                        </div>
                        <div class="order-col ">
                            <div><strong>TOTAL</strong></div>
                            <div class="text-right"><strong class="order-total ">${{$sumaTotal or ''}}</strong></div>
                            <input type="text" hidden name="txtVentaTotal" value="{{$sumaTotal or ''}}">
                        </div>
                    </div>
                    <div class="payment-method">
                        <div class="input-radio">
                            <input type="radio" class="control-input" name="chk_venta" value="1" id="payment-1" required>
                            <label for="payment-1">
                                <span></span>
                                Transferencia Bancaria
                            </label>
                            <div class="caption">
                                @foreach ($array_transf as $transf)
                                <table class="table table-borderless mx-auto">
                                    <tbody>
                                        <tr>
                                            <th scope="row"><strong>BANCO:</strong></th>
                                            <td>{{$transf->banco}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><strong>SUCURSAL:</strong></th>
                                            <td>{{$transf->sucursal}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><strong>CBU:</strong></th>
                                            <td>{{$transf->cbu}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><strong>CUENTA:</strong></th>
                                            <td>{{$transf->cuenta}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><strong>CUIT:</strong></th>
                                            <td>{{$transf->cuit}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                @endforeach
                            </div>
                        </div>
                        <div class="input-radio ">
                            <input type="radio" name="chk_venta" value="2" id="payment-2" class="control-input" >
                            <label for="payment-2">
                                <span></span>
                                Mercado Pago
                            </label>
                        </div>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="checkbox" id="terms" class="form-check-input" required>
                        <label for="terms">
                            <span></span>
                            He leído y acepto los <a href="#" onclick="terminos();">términos y condiciones</a>
                        </label>
                    </div>

                    <button type="submit" class="primary-btn btn-block order-submit" id="btnComprar" >COMPRAR</button>

                </div>
                
                <!-- /Order Details -->
            </div>
            <!-- /row -->
        </form>
    </div>

    <!-- /container -->
</div>
<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Terminos y Condiciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p> Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolores explicabo quaerat quo ratione optio. Voluptates quos reiciendis corrupti perspiciatis officia itaque ab a, sint cumque repellat! Optio beatae facere praesentium.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="aceptarTerminos" onclick="aceptarTerminos();">Aceptar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:$('.modal').hide();">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<script>
    
    function aceptarTerminos(){
      $('#terms').prop('checked',true);
      $('.modal').hide();
    }
    
    function terminos(){
        $('.modal').toggle();
    }
    function desabilitarInput() {
        if ($('.chk_otroDomicilio').is(':checked') == true) {
            $('#txtNombre').prop('value', '').prop('disabled', true).prop('required', false);
            $('#txtApellido').prop('value', '').prop('disabled', true).prop('required', false);
            $('#txtEmail').prop('value', '').prop('disabled', true).prop('required', false);
            $('#lstPais').prop('disabled', true).prop('required', false);
            $('#lstProvincia').prop('value', '').prop('disabled', true).prop('required', false);
            $('#lstLocalidad').prop('value', '').prop('disabled', true).prop('required', false);
            $('#txtDomicilio').prop('value', '').prop('disabled', true).prop('required', false);
            $('#txtCp').prop('value', '').prop('disabled', true).prop('required', false);
            $('#txtTelefono').prop('value', '').prop('disabled', true).prop('required', false);
        } else {
            $("input").prop('disabled', false);
            $("select").prop('disabled', false);
            $('#txtNombre').prop('required', true);
            $('#txtApellido').prop('required', true);
            $('#txtEmail').prop('required', true);
            $('#lstPais').prop('required', true);
            $('#lstProvincia').prop('required', true);
            $('#lstLocalidad').prop('required', true);
            $('#txtDomicilio').prop('required', true);
            $('#txtCp').prop('required', true);
            $('#txtTelefono').prop('required', true);
        }

    }

    function fBuscarProvincia() {
        if ($('.chk_otroDomicilio').is(':checked') == true) {
            var prov = $('#lstPaisAdd').val();
        } else {
            var prov = $('#lstPais').val();
        }


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('#txtToken').val(),
            },
            url: "{{route('cargarVenta')}}",
            type: "post",
            data: {
                provincia: prov
            },
            dataType: "json",
            success: function(respuesta) {

                let opciones = '<option value="0" selected disable>Provincia</option>';
                const resultado = respuesta.reduce(function(acumulador, valor) {
                    const {
                        idprovincia,
                        descprov
                    } = valor;
                    return acumulador + `<option value="${idprovincia}">${descprov}</option>`
                }, opciones);
                if ($('.chk_otroDomicilio').is(':checked') == true) {
                    $('#lstProvinciaAdd').empty().append(resultado);
                } else {
                    $('#lstProvincia').empty().append(resultado);
                }


            }

        });
    }

    function fBuscarLocalidad() {
        if ($('.chk_otroDomicilio').is(':checked') == true) {
            var localidad = $('#lstProvinciaAdd').val();
        } else {
            var localidad = $('#lstProvincia').val();
        }


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('#txtToken').val(),
            },
            url: "{{route('cargarVenta')}}",
            type: "post",
            data: {
                localidad: localidad
            },
            dataType: "json",
            success: function(respuesta) {

                let opciones = '<option value="0" selected disable>Localidad</option>';
                const resultado = respuesta.reduce(function(acumulador, valor) {
                    const {
                        idlocalidad,
                        nombre
                    } = valor;
                    return acumulador + `<option value="${idlocalidad}">${nombre}</option>`
                }, opciones);

                if ($('.chk_otroDomicilio').is(':checked') == true) {
                    $('#lstLocalidadAdd').empty().append(resultado);
                } else {
                    $('#lstLocalidad').empty().append(resultado);
                }

            }

        });
    }
</script>

<!-- /SECTION -->
@endsection