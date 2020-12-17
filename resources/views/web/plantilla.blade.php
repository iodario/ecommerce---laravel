<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>@yield('titulo')</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

	<!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="/web/css/bootstrap.min.css" />

	<!-- Slick -->
	<link type="text/css" rel="stylesheet" href="/web/css/slick.css" />
	<link type="text/css" rel="stylesheet" href="/web/css/slick-theme.css" />

	<!-- nouislider -->
	<link type="text/css" rel="stylesheet" href="/web/css/nouislider.min.css" />

	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="/web/css/font-awesome.min.css">

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="/web/css/style.css" />

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
 		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
 		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
 		<![endif]-->

</head>

<body>
	<!-- HEADER -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
	<header>

		<!-- TOP HEADER -->
		<div id="top-header">
			<div class="container">
				<ul class="header-links pull-left">
					<li><a href="#"><i class="fa fa-phone"></i> +54 011 2345-5676</a></li>
					<li><a href="#"><i class="fa fa-envelope-o"></i> ecommerce@gmail.com</a></li>
					<li><a href="#"><i class="fa fa-map-marker"></i> Avenida Siempreviva 742</a></li>
				</ul>
				<ul class="header-links pull-right">
					<li><select name="lstMoneda" id="lstMoneda">
							@foreach($array_moneda as $moneda)
							<option>{{ $moneda->abreviatura }}</option>
							@endforeach
						</select></li>
					@if(Session::get('usuario_id') != "")
					<li><a href="#"><i class="fa fa-user-o"></i> {{ Session::get('usuario_nombre') }}</a></li>
					<li><a href="/logout"><i class="fa fa-exit-o"></i>Salir</a></li>
					@else
					<li><a href="/login"><i class="fa fa-user-o"></i>Ingresar</a></li>
					@endif

				</ul>
			</div>
		</div>
		<!-- /TOP HEADER -->

		<!-- MAIN HEADER -->
		<div id="header">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- LOGO -->
					<div class="col-md-3">
						<div class="header-logo">
							<a href="/" class="logo">
								<img src="/web/img/logo.png" alt="">
							</a>
						</div>
					</div>
					<!-- /LOGO -->

					<!-- SEARCH BAR -->
					<div class="col-md-6 ">
						<div class="header-search ">
							<form action="/buscador" method="get">
								<div class="row">
									<div class="col-12 ">
										<select name="lstCategoria" id="lstCategoria" class="input-select text-center">
											<option selected disabled>Categorias</option>
											@foreach($array_categoria as $categoria)
												<option value="{{ $categoria->idcategoria }}">{{ $categoria->nombre }}</option>
											@endforeach
										</select>
										<input name="txtProducto" id="txtProducto" class="input" placeholder="Buscar...">	
										<button class="search-btn" type="submit">Buscar</button>									
									</div>
								</div>
							</form>							
						</div>															
					</div>
					<!-- /SEARCH BAR -->

					<!-- ACCOUNT -->
					<div class="col-md-3 clearfix">
						<div class="header-ctn">
							<!-- Wishlist -->
							<div>
								<a href="#">
									<i class="fa fa-heart-o"></i>
									<span>Favoritos</span>
									<div class="qty">2</div>
								</a>
							</div>
							<!-- /Wishlist -->

							<!-- Cart -->
							<div class="dropdown">

								<a href="/checkout" >
									<i class="fa fa-shopping-cart"></i>
									<span>Carrito</span>
									<div class="qty">
										<!--Cantidad de productos en carrito</div> -->
								</a>
								<div class="cart-dropdown">
									<div class="cart-list">
										<div class="product-widget">
											<!-- Info producto -->
											<button class="delete"><i class="fa fa-close"></i></button>
										</div>
										<div class="product-widget">
											<!-- Info producto -->
											<button class="delete"><i class="fa fa-close"></i></button>
										</div>
									</div>
									<div class="cart-summary">
										<small>X items seleccionados</small>
										<h5>SUBTOTAL: $2940.00</h5>
									</div>
									<div class="cart-btns">
										<a href="#">Ver carrito</a>
										<a href="#">Checkout <i class="fa fa-arrow-circle-right"></i></a>
									</div>
								</div>
							</div>
							<!-- /Cart -->

							<!-- Menu Toogle -->
							<div class="menu-toggle">
								<a href="#">
									<i class="fa fa-bars"></i>
									<span>Menu</span>
								</a>
							</div>
							<!-- /Menu Toogle -->
						</div>
					</div>
					<!-- /ACCOUNT -->
				</div>
				<!-- row -->
			</div>
			<!-- container -->
		</div>
		<!-- /MAIN HEADER -->
	</header>
	<!-- /HEADER -->

	<!-- NAVIGATION -->
	<nav id="navigation">
		<!-- container -->
		<div class="container">
			<!-- responsive-nav -->
			<div id="responsive-nav">
				<!-- NAV -->
				<ul class="main-nav nav navbar-nav">
					<li class="active"><a href="#">Inicio</a></li>
					<li><a href="#">Ofertas</a></li>
					<li><a href="#">Categorias</a></li>
					<li><a href="#">Laptos</a></li>
					<li><a href="#">Smartphones</a></li>
					<li><a href="#">Camaras</a></li>
					<li><a href="#">Accesorias</a></li>
				</ul>
				<!-- /NAV -->
			</div>
			<!-- /responsive-nav -->
		</div>
		<!-- /container -->
	</nav>
	<!-- /NAVIGATION -->

	<!-- BREADCRUMB -->
	@yield('breadcrumb')
	<!-- /BREADCRUMB -->

	<!-- SECTION -->
	@yield('contenido')
	<!-- /SECTION -->

	<!-- FOOTER -->
	<footer id="footer">
		<!-- top footer -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-3 col-xs-6">
						<div class="footer">
							<h3 class="footer-title">Sobre nosotros</h3>
							<p>Somos unas personas apasionadas por la venta de productos.</p>
							<ul class="footer-links">
								<li><a href="#"><i class="fa fa-map-marker"></i>Avenida Siempreviva 742</a></li>
								<li><a href="#"><i class="fa fa-phone"></i>+54 011 2345-5676</a></li>
								<li><a href="#"><i class="fa fa-envelope-o"></i>ecommerce@gmail.com</a></li>
							</ul>
						</div>
					</div>

					<div class="col-md-3 col-xs-6">
						<div class="footer">
							<h3 class="footer-title">Categorias</h3>
							<ul class="footer-links">
								<li><a href="#">Ofertas</a></li>
								<li><a href="#">Laptops</a></li>
								<li><a href="#">Smartphones</a></li>
								<li><a href="#">Camaras</a></li>
								<li><a href="#">Accesorios</a></li>
							</ul>
						</div>
					</div>

					<div class="clearfix visible-xs"></div>

					<div class="col-md-3 col-xs-6">
						<div class="footer">
							<h3 class="footer-title">Información</h3>
							<ul class="footer-links">
								<li><a href="#">Sobre nosotros</a></li>
								<li><a href="/contacto">Contactanos</a></li>
								<li><a href="#">Políticas de privacidad</a></li>
								<li><a href="#">Pedidos y reembolsos</a></li>
								<li><a href="#">Terminos y condiciones</a></li>
							</ul>
						</div>
					</div>

					<div class="col-md-3 col-xs-6">
						<div class="footer">
							<h3 class="footer-title">Servicio</h3>
							<ul class="footer-links">
								<li><a href="/micuenta">Mi cuenta</a></li>
								<li><a href="#">Ver carrito</a></li>
								<li><a href="#">Lista de deseados</a></li>
								<li><a href="/respuestaincidente">Seguimiento de mi pedido</a></li>
								<li><a href="#">Ayuda</a></li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /top footer -->

		<!-- bottom footer -->
		<div id="bottom-footer" class="section">
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12 text-center">
						<ul class="footer-payments">
							<li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
							<li><a href="#"><i class="fa fa-credit-card"></i></a></li>
							<li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
							<li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
							<li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
							<li><a href="#"><i class="fa fa-cc-amex"></i></a></li>
						</ul>
						<span class="copyright">
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							Copyright &copy;<script>
								document.write(new Date().getFullYear());
							</script> Todos los derechos reservados</a>
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						</span>


					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /bottom footer -->
	</footer>
	<!-- /FOOTER -->

	<!-- jQuery Plugins -->
	<script src="/web/js/jquery.min.js"></script>
	<script src="/web/js/bootstrap.min.js"></script>
	<script src="/web/js/slick.min.js"></script>
	<script src="/web/js/nouislider.min.js"></script>
	<script src="/web/js/jquery.zoom.min.js"></script>
	<script src="/web/js/main.js"></script>
@yield('scripts')
</body>

</html>