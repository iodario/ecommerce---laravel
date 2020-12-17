<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('images/favicon.png') }}">

    <title>Recupero de clave - {{ env('APP_NAME') }}</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin.min.css') }}" rel="stylesheet" type="text/css">
  </head>
<body class="bg-dark">
      <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Recuperar clave</div>
        <div class="card-body">
          <div class="text-center mb-4">
            <h4>¿Olvidaste la clave?</h4>
            <p>Ingresa la dirección de correo con la que te registraste y te enviaremos las instrucciones para cambiar la clave.</p>
          </div>
          <form name="fr" class="form-signin" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
            @if(isset($mensaje))
              <div class="alert alert-secondary text-center" role="alert">
                {{ $mensaje }}
              </div>
            @else
            <div class="form-group">
              <div class="form-label-group">
                  <input type="email" id="txtMail" name="txtMail" class="form-control" placeholder="Dirección de correo" required="required" autofocus="autofocus">
              </div>
            </div>
            <button class="btn btn-primary btn-block" type="submit">Recuperar</button>
            @endif
          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href="register.html">Nuevo registro</a>
            <a class="d-block small" href="/admin/login">Página Login</a>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>