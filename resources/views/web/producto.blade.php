@extends('web.plantilla')
@section('titulo', "$titulo")

@section('breadcrumb')




@endsection

@section('contenido')



<!-- SECTION -->
<div class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<!-- Product main img -->
			<div class="col-md-5 col-md-push-2">
				<div id="product-main-img">
					<div class="product-preview">
						<img src="{{$productoObtenido->foto}}" alt="">
					</div>

					<div class="product-preview">
						<img src="{{$productoObtenido->foto}}" alt="">
					</div>

					<div class="product-preview">
						<img src="{{$productoObtenido->foto}}" alt="">
					</div>

					<div class="product-preview">
						<img src="{{$productoObtenido->foto}}" alt="">
					</div>
				</div>
			</div>
			<!-- /Product main img -->

			<!-- Product thumb imgs -->
			<div class="col-md-2  col-md-pull-5">
				<div id="product-imgs">
					<div class="product-preview">
						<img src="{{$productoObtenido->foto}}" alt="">
					</div>

					<div class="product-preview">
						<img src="{{$productoObtenido->foto}}" alt="">
					</div>

					<div class="product-preview">
						<img src="{{$productoObtenido->foto}}" alt="">
					</div>

					<div class="product-preview">
						<img src="{{$productoObtenido->foto}}" alt="">
					</div>


				</div>
			</div>
			<!-- /Product thumb imgs -->

			<!-- Product details -->
			<div class="col-md-5">
				<div class="product-details">
					<h2 class="product-name">{{$productoObtenido->nombre}}</h2>

					<div>
						<h3 class="product-price">{{$productoObtenido->precio_con_descuento}}<del class="product-old-price">{{$productoObtenido->precio}}</del></h3>
						<span class="product-available">Con Stock</span>
					</div>
					<p>{{$productoObtenido->descripcion}}</p>

					<div class="product-options">

						<label>
							Color
							<select class="input-select">
								<option value="0">Rojo</option>
								<option value="1">Azul</option>
								<option value="2">plateado</option>
							</select>
						</label>
					</div>

					<div class="add-to-cart">
						<div class="qty-label">
							Qty
							<div class="input-number">
								<input type="number" value="1">
								<span class="qty-up">+</span>
								<span class="qty-down">-</span>
							</div>
						</div>
						<a class="add-to-cart-btn" href="/agregarCarrito/{{ $productoObtenido->idproducto }}"><i class="fa fa-shopping-cart"></i> carrito </a>
						
					</div>


					<ul class="product-links">
						<li>Category:</li>
						@foreach($array_categoria as $categoria)
						@if($categoria->idcategoria==$productoObtenido->fk_idcategoria)

						<li>{{$categoria->nombre}}</li>
						@endif
						@endforeach
					</ul>



				</div>
			</div>
			<!-- /Product details -->

			<!-- Product tab -->
			<div class="col-md-12">
				<div id="product-tab">
					<!-- product tab nav -->
					<ul class="tab-nav">
						<li class="active"><a data-toggle="tab" href="#tab1">Descripción</a></li>

					</ul>
					<!-- /product tab nav -->

					<!-- product tab content -->
					<div class="tab-content">
						<!-- tab1  -->
						<div id="tab1" class="tab-pane fade in active">
							<div class="row">
								<div class="col-md-12">
									<p>{{$productoObtenido->descripcion}}</p>
								</div>
							</div>
						</div>
						<!-- /tab1  -->

						<!-- tab2  -->

						<!-- /tab2  -->


					</div>
					<!-- /product tab content  -->
				</div>
			</div>
			<!-- /product tab -->
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->

<!-- Section -->




@endsection