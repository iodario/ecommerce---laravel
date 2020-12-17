@extends('web.plantilla')
@section('titulo', "$titulo")
@section('breadcrumb')
<!-- BREADCRUMB -->
		<div id="breadcrumb" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<ul class="breadcrumb-tree">
							<li><a href="/">Inicio</a></li>
							<li><a>Resultados</a></li>
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
					<!-- ASIDE -->
					<div id="aside" class="col-md-3">
						<!-- aside Widget -->
						<div class="aside">
							<h3 class="aside-title">Categorias</h3>
							<div class="checkbox-filter">
                            @foreach($array_categoria as $categoria)
								<div class="input-checkbox">
									<input type="checkbox" id="{{$categoria->idcategoria}}">
									<label for="{{ $categoria->idcategoria }}">
										<span></span>
										<a>{{$categoria->nombre}}</a>									
										<small>120</small>
									</label>
								</div>
                             @endforeach
								
							</div>
						</div>
						<!-- /aside Widget -->

						<!-- aside Widget -->
						<div class="aside">
							<h3 class="aside-title">Precio</h3>
							<div class="price-filter">
								<div id="price-slider"></div>
								<div class="input-number price-min">
									<input id="price-min" name="precio-min" type="number">
									<span class="qty-up">+</span>
									<span class="qty-down">-</span>
								</div>
								<span>-</span>
								<div class="input-number price-max">
									<input id="price-max" name="precio-max" type="number">
									<span class="qty-up">+</span>
									<span class="qty-down">-</span>
								</div>
							</div>
						</div>
						<!-- /aside Widget -->

						<!-- aside Widget -->
						<div class="aside">
							<h3 class="aside-title">Marca</h3>
							<div class="checkbox-filter">
							@foreach($array_marcas as $marca)
								<div class="input-checkbox">
									<input type="checkbox" id="{{ $marca->idmarca }}">
									<label for="{{ $marca->idmarca }}">
										<span></span>
										<a href="{{ $marca->idmarca }}">{{ $marca->nombre }}</a>
										<small>(578)</small>
									</label>
								</div>
						    @endforeach								
							</div>
						</div>
						<!-- /aside Widget -->
					</div>
					<!-- /ASIDE -->

					<!-- STORE -->
					<div id="store" class="col-md-9">
						<!-- store top filter -->
						<div class="store-filter clearfix">
							<div class="store-sort">
								<label>
									Ordenar por:
									<select class="input-select">
										<option value="0">Más populares</option>
									</select>
								</label>

								<label>
									Mostrar:
									<select class="input-select" id="sort_by_cantidad">
										<option value="20">20</option>
										<option value="50">50</option>
									</select>
								</label>
							</div>
							<ul class="store-grid">
								<li class="active"><i class="fa fa-th"></i></li>
								<li><a href="#"><i class="fa fa-th-list"></i></a></li>
							</ul>
						</div>
						<!-- /store top filter -->

						<!-- store products -->
						<div class="row">
							<!-- product -->
							@foreach($array_resultados as $producto)
							<div class="col-md-4 col-xs-6">
								<div class="product">
									<div class="product-img">
										<img src="{{$producto->foto}}" alt="" height="300px;">										
										<div class="product-label">
											<span class="sale">-{{ $producto->porcentaje }}%</span>
											<span class="new">NEW</span>
										</div>
									</div>
									<div class="product-body">
										<p class="product-category">{{$producto->categoria}}</p>
										 <h3 class="product-name"><a href="/producto/{{ $producto->idproducto }}">'{{ $producto->nombre }}'</a></h3>
										<h4 class="product-price">{{number_format($producto->precio_con_descuento, 2, ",", ".")}} <del class="product-old-price">{{number_format($producto->precio, 2, ",", ".")}}</del></h4>
										<div class="product-rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
										</div>
										<div class="product-btns">
											<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span  class="tooltipp"> Agregar a favoritos</span></button>
											<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp"> Agregar para comparar</span></button>
											<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp"> Vista rápida</span></button>
										</div>
									</div>
									<div class="add-to-cart">
										<button class="add-to-cart-btn"><a href="/agregarCarrito/{{ $producto->idproducto }}"><i class="fa fa-shopping-cart"></i> Agregar al carrito</a></button>
									</div>
								</div>
							</div>
							<!-- /product -->
                           @endforeach
							
						</div>
						<!-- /store products -->

						<!-- store bottom filter -->
						<div class="store-filter clearfix">
							<span class="store-qty">Mostrando {{ $cantidad_resultados }}-<span id="cantidad_mostrar"></span> productos</span>
							<ul class="store-pagination">
								<li class="active">1</li>
								<li><a href="#"><i class="fa fa-angle-right"></i></a></li>
							</ul>
						</div>
						<!-- /store bottom filter -->
					</div>
					<!-- /STORE -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

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
@section('scripts')
<script>
	$(document).ready(()=>{
		$("#cantidad_mostrar").html($("#sort_by_cantidad").val());
	});
	$("#sort_by_cantidad").change(()=>{
		let cantidad = $(this).val();
		$("#cantidad_mostrar").html(cantidad);
	});
</script>
@endsection