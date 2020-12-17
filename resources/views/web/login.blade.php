@extends('web.plantilla')
@section('contenido')

<div class="container">
  <div class="card card-login mx-auto mt-3">
    <div class="card-body">
      <?php
      if (isset($msg)) {
        echo '<div id = "msg"></div>';
        echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
      }
      ?>
      <div class="row">
        <div class="col-md-4 my-3">
          <form action="/login" method="POST">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" id="txtToken"></input>
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="txtUsuario" name="txtUsuario" class="form-control" placeholder="Usuario" required autofocus>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" id="txtClave" name="txtClave" class="form-control" placeholder="Clave" required>
              </div>
            </div>
            <div class="form-group">
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="remember-me">
                  Recordar clave
                </label>
              </div>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit" style="
              width: 160px;
              height: 40px;
              font-weight: 700;
              background: #D10024;
              color: #FFF;
              border: none;
              border-radius: 0px 40px 40px 0px;">Entrar
              </button>
            </div>
            <br>
            <div class="text-center">
              <a class="d-block small" href="/recupero-clave">Recuperar clave</a>
            </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection