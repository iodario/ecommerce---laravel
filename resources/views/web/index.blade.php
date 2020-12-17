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
            <!-- shop -->
            <div class="col-md-4 col-xs-6">
                <div class="shop">
                    <div class="shop-img">
                        <img src="/images/nootbook.png" alt="" style="height: 240px">
                    </div>
                    <div class="shop-body">
                        <h3>Computadoras y<br>Celulares</h3>
                        <a href="#" class="cta-btn">Comprar ahora <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- /shop -->

            <!-- shop -->
            <div class="col-md-4 col-xs-6">
                <div class="shop">
                    <div class="shop-img" >
                        <img src="/images/multiprocesadora.jpg" alt="" style="height: 240px">
                    </div>
                    <div class="shop-body">
                        <h3>Accesorios de<br>Cocina</h3>
                        <a href="#" class="cta-btn">Comprar ahora <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- /shop -->

            <!-- shop -->
            <div class="col-md-4 col-xs-6">
                <div class="shop">
                    <div class="shop-img">
                        <img src="/images/mancuernas.jpg" alt="" style="height: 240px">
                    </div>
                    <div class="shop-body">
                        <h3>Equipos de <br>Entrenamiento</h3>
                        <a href="#" class="cta-btn">Comprar ahora <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- /shop -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->

<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">

            <!-- section title -->
            <div class="col-md-12">
                <div class="section-title">
                    <h3 class="title">Nuevos Productos</h3>
                    <div class="section-nav">
                        <ul class="section-tab-nav tab-nav">
                            <li class="active"><a data-toggle="tab" href="#tab1">Computadoras</a></li>
                            <li><a data-toggle="tab" href="#tab1">Celulares</a></li>
                            <li><a data-toggle="tab" href="#tab1">Cámaras</a></li>
                            <li><a data-toggle="tab" href="#tab1">Accesorios</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /section title -->

            <!-- Products tab & slick -->
            <div class="col-md-12">
                <div class="row">
                    <div class="products-tabs" >
                        <!-- tab -->
                        <div id="tab1" class="tab-pane active">
                            <div class="products-slick" data-nav="#slick-nav-1">
                                <!-- product -->
                                @for ($i = 0; $i < count($array_producto); $i++)
                                    
                                <div class="product">
                                    <div class="product-img">
                                    <a href="/producto/{{ $array_producto[$i]->idproducto }}"><img src="{{ $array_producto[$i]->foto }}"  alt=""></a>
                                        <div class="product-label">
                                            <span class="sale">-{{ $array_producto[$i]->porcentaje }}%</span>
                                            <span class="new">NUEVO</span>
                                        </div>
                                    </div>
                                    <div class="product-body">
                                        <p class="product-category"> {{ $array_producto[$i]->categoria }}</p>
                                        <h3 class="product-name"><a href="/producto/{{ $array_producto[$i]->idproducto }}">'{{ $array_producto[$i]->nombre }}'</a></h3>
                                        <h4 class="product-price">{{ $array_producto[$i]->precio_con_descuento }} <del class="product-old-price">{{ $array_producto[$i]->precio }}</del></h4>
                                        
                                        <div class="product-btns">
                                            
                                        <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">Agregar a favoritos</span></button>
                                            
                                        </div>
                                    </div>
                                    <div class="add-to-cart">
                                       
                                        <a class="add-to-cart-btn" href="/agregarCarrito/{{ $array_producto[$i]->idproducto }}"><i class="fa fa-shopping-cart"></i> carrito </a>
                                    </div>
                                </div>
                                @endfor 
                                <!-- /product -->
                            </div>
                            <div id="slick-nav-1" class="products-slick-nav"></div>
                        </div>
                        <!-- /tab -->
                    </div>
                </div>
            </div>
            <!-- Products tab & slick -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->

<!-- HOT DEAL SECTION -->
<div id="hot-deal" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="hot-deal">
                    <ul class="hot-deal-countdown">
                        <li>
                            <div>
                                <h3>02</h3>
                                <span>Días</span>
                            </div>
                        </li>
                        <li>
                            <div>
                                <h3>10</h3>
                                <span>Horas</span>
                            </div>
                        </li>
                        <li>
                            <div>
                                <h3>34</h3>
                                <span>Minutos</span>
                            </div>
                        </li>
                        <li>
                            <div>
                                <h3>60</h3>
                                <span>Segundos</span>
                            </div>
                        </li>
                    </ul>
                    <h2 class="text-uppercase">oferta especial esta semana</h2>
                    <p>NUEVOS PRODUCTOS CON MÁS DEL 50% OFF</p>
                    <!-- completar el enlace -->
                    <a class="primary-btn cta-btn" href="#">Comprar ahora</a>
                </div>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /HOT DEAL SECTION -->

<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">

            <!-- section title -->
            <div class="col-md-12">
                <div class="section-title">
                    <h3 class="title">Lo más vendido</h3>
                    <div class="section-nav">
                        <ul class="section-tab-nav tab-nav">
                            <li class="active"><a data-toggle="tab" href="#tab2">Computadoras</a></li>
                            <li><a data-toggle="tab" href="#tab2">Celulares</a></li>
                            <li><a data-toggle="tab" href="#tab2">Cámaras</a></li>
                            <li><a data-toggle="tab" href="#tab2">Accesorios</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /section title -->

            <!-- Products tab & slick -->
            <div class="col-md-12">
                <div class="row">
                    <div class="products-tabs">
                        <!-- tab -->
                        <div id="tab2" class="tab-pane fade in active">
                            <div class="products-slick" data-nav="#slick-nav-2">
                                <!-- product -->

                                @for ($i = 0; $i < count($array_producto); $i++)
                                <div class="product">
                                    <div class="product-img">
                                    <a href="/producto/{{ $array_producto[$i]->idproducto }}"><img src="{{ $array_producto[$i]->foto }}" alt="" ></a>
                                        <div class="product-label">
                                            <span class="sale">-{{ $array_producto[$i]->porcentaje }}%</span>
                                            <span class="new">MÁS VENDIDO</span>
                                        </div>
                                    </div>
                                    <div class="product-body">
                                        <p class="product-category">{{ $array_producto[$i]->categoria }}</p>
                                        <h3 class="product-name"><a href="/producto/{{ $array_producto[$i]->idproducto }}">{{ $array_producto[$i]->nombre }}</a></h3>
                                        <h4 class="product-price">{{ $array_producto[$i]->precio_con_descuento }} <del class="product-old-price">{{ $array_producto[$i]->precio_con_descuento }}</del></h4>
                                        
                                        <div class="product-btns">
                                            
                                        <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">agregar a favoritos</span></button>
                                            
                                        </div>
                                    </div>
                                    <div class="add-to-cart">
                                        <button class="add-to-cart-btn" href="/agregarCarrito/{{ $array_producto[$i]->idproducto }}"><i class="fa fa-shopping-cart"></i> Agregar al carrito</button>
                                    </div>
                                </div>
                                @endfor 
                                <!-- /product -->
                            </div>
                            <div id="slick-nav-2" class="products-slick-nav"></div>
                        </div>
                        <!-- /tab -->
                    </div>
                </div>
            </div>
            <!-- /Products tab & slick -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->

<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-4 col-xs-6">
                <div class="section-title">
                    <h4 class="title">Lo más vendido</h4>
                    <div class="section-nav">
                        <div id="slick-nav-3" class="products-slick-nav"></div>
                    </div>
                </div>

                <div class="products-widget-slick" data-nav="#slick-nav-3">
                    <div>
                        <!-- product widget -->
                        @for ($i = 0; $i < 3; $i++)
                        <div class="product-widget">
                            <div class="product-img">
                                <img src="{{ $array_producto[$i]->foto }}" alt="">
                            </div>
                            <div class="product-body">
                                <p class="product-category">"{{ $array_producto[$i]->categoria }}"</p>
                                <h3 class="product-name"><a href="/agregarCarrito/{{ $array_producto[$i]->idproducto }}">"{{ $array_producto[$i]->nombre }}"</a></h3>
                                <h4 class="product-price">{{ $array_producto[$i]->precio_con_descuento }}  <del class="product-old-price">{{ $array_producto[$i]->precio }} </del></h4>
                            </div>
                        </div>
                        @endfor
                        <!-- /product widget -->

                        
                    </div>

                    <div>
                        <!-- product widget -->
                        @for ($i = 3; $i < 6; $i++)
                        <div class="product-widget">
                            <div class="product-img">
                                <img src="{{ $array_producto[$i]->foto }}" alt="">
                            </div>
                            <div class="product-body">
                                <p class="product-category">"{{ $array_producto[$i]->categoria }}"</p>
                                <h3 class="product-name"><a href="/agregarCarrito/{{ $array_producto[$i]->idproducto }}">"{{ $array_producto[$i]->nombre }}"</a></h3>
                                <h4 class="product-price">{{ $array_producto[$i]->precio_con_descuento }}  <del class="product-old-price">{{ $array_producto[$i]->precio }} </del></h4>
                            </div>
                        </div>
                        @endfor
                        <!-- /product widget -->
                    
                    </div>

                    
                </div>
            </div>

            <div class="col-md-4 col-xs-6">
                <div class="section-title">
                    <h4 class="title">Lo más vendido</h4>
                    <div class="section-nav">
                        <div id="slick-nav-4" class="products-slick-nav"></div>
                    </div>
                </div>

                <div class="products-widget-slick" data-nav="#slick-nav-4">
                <div>
                        <!-- product widget -->
                        @for ($i = 4; $i < 7; $i++)
                        <div class="product-widget">
                            <div class="product-img">
                                <img src="{{ $array_producto[$i]->foto }}" alt="">
                            </div>
                            <div class="product-body">
                                <p class="product-category">"{{ $array_producto[$i]->categoria }}"</p>
                                <h3 class="product-name"><a href="/agregarCarrito/{{ $array_producto[$i]->idproducto }}">"{{ $array_producto[$i]->nombre }}"</a></h3>
                                <h4 class="product-price">{{ $array_producto[$i]->precio_con_descuento }}  <del class="product-old-price">{{ $array_producto[$i]->precio }} </del></h4>
                            </div>
                        </div>
                        @endfor
                        <!-- /product widget -->

                        
                    </div>

                    <div>
                        <!-- product widget -->
                        @for ($i = 6; $i < 9; $i++)
                        <div class="product-widget">
                            <div class="product-img">
                                <img src="{{ $array_producto[$i]->foto }}" alt="">
                            </div>
                            <div class="product-body">
                                <p class="product-category">"{{ $array_producto[$i]->categoria }}"</p>
                                <h3 class="product-name"><a href="/agregarCarrito/{{ $array_producto[$i]->idproducto }}">"{{ $array_producto[$i]->nombre }}"</a></h3>
                                <h4 class="product-price">{{ $array_producto[$i]->precio_con_descuento }}  <del class="product-old-price">{{ $array_producto[$i]->precio }} </del></h4>
                            </div>
                        </div>
                        @endfor
                        <!-- /product widget -->
                    
                    </div>


                </div>
            </div>

            <div class="clearfix visible-sm visible-xs"></div>

            <div class="col-md-4 col-xs-6">
                <div class="section-title">
                    <h4 class="title">Lo más vendido</h4>
                    <div class="section-nav">
                        <div id="slick-nav-5" class="products-slick-nav"></div>
                    </div>
                </div>

                <div class="products-widget-slick" data-nav="#slick-nav-5">
                    
                <div>
                        <!-- product widget -->
                        @for ($i = 5; $i < 8; $i++)
                        <div class="product-widget">
                            <div class="product-img">
                                <img src="{{ $array_producto[$i]->foto }}" alt="">
                            </div>
                            <div class="product-body">
                                <p class="product-category">"{{ $array_producto[$i]->categoria }}"</p>
                                <h3 class="product-name"><a href="/agregarCarrito/{{ $array_producto[$i]->idproducto }}">"{{ $array_producto[$i]->nombre }}"</a></h3>
                                <h4 class="product-price">{{ $array_producto[$i]->precio_con_descuento }}  <del class="product-old-price">{{ $array_producto[$i]->precio }} </del></h4>
                            </div>
                        </div>
                        @endfor
                        <!-- /product widget -->

                        
                    </div>

                    <div>
                        <!-- product widget -->
                        @for ($i = 2; $i < 5; $i++)
                        <div class="product-widget">
                            <div class="product-img">
                                <img src="{{ $array_producto[$i]->foto }}" alt="">
                            </div>
                            <div class="product-body">
                                <p class="product-category">"{{ $array_producto[$i]->categoria }}"</p>
                                <h3 class="product-name"><a href="/agregarCarrito/{{ $array_producto[$i]->idproducto }}">"{{ $array_producto[$i]->nombre }}"</a></h3>
                                <h4 class="product-price">{{ $array_producto[$i]->precio_con_descuento }}  <del class="product-old-price">{{ $array_producto[$i]->precio }} </del></h4>
                            </div>
                        </div>
                        @endfor
                        <!-- /product widget -->
                    
                    </div>
                    
                </div>
            </div>

        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->


<!-- jQuery Plugins -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/nouislider.min.js"></script>
<script src="js/jquery.zoom.min.js"></script>
<script src="js/main.js"></script>
@endsection