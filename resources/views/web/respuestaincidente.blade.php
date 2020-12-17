@extends('web.plantilla')
@section('titulo', "$titulo")

@section('breadcrumb')
<!-- /BREADCRUMB -->
<div id="breadcrumb" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <h3 class="breadcrumb-header">Seguimiento de Incidentes</h3>
                <ul class="breadcrumb-tree">
                    <li><a href="/">Volver a Home</a></li>
                    <li><a href="/contacto">Ir a contacto</a></li>
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
            <form>
                <div class="col-md-5">
                   
                    <div class="form-group">
                        <label for="txtConsulta">Respuesta: </label>
                        <textarea cols="60" rows="10" name="txtConsulta" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="txtConsulta">Respuesta: </label>
                        <textarea cols="60" rows="10" name="txtConsulta" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="
    width: 160px;
    height: 40px;
    font-weight: 700;
    background: #D10024;
    color: #FFF;
    border: none;
    border-radius: 0px 40px 40px 0px;">Responder</button>
                </div>
            </form>

        </div>
    </div>
</div>

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