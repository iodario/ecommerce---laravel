<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::group(array('domain' => '127.0.0.1'), function () {

    Route::get('/', 'ControladorWebHome@index');
    Route::get('/producto/{idProducto}', 'ControladorWebProducto@index');
    Route::get('/checkout', 'ControladorWebCheckout@index');
    Route::get('/buscador', 'ControladorWebBuscador@buscarProductos');
    Route::get('/login', 'ControladorWebLogin@index');
    Route::post('/login', 'ControladorWebLogin@entrar');
    Route::get('/logout', 'ControladorWebLogin@logout');
    Route::post('/logout', 'ControladorWebLogin@entrar');
    Route::get('/agregarCarrito/{id}', 'ControladorWebHome@guardarCarrito');
   // Route::get('/agregarCarrito/{id}', 'ControladorWebBuscador@guardarCarrito');
   // Route::get('/producto', 'ControladorWebProducto@index');
    Route::post('/producto', 'ControladorWebProducto@guardarCarrito');
    Route::get('/producto/{idProducto}', 'ControladorWebProducto@index');
    Route::get('/checkout', 'ControladorWebCheckout@index');
    Route::get('/checkout/comprafinalizada', 'ControladorWebCheckout@compraFinalizada');
    Route::post('/checkout','ControladorWebCheckout@cargarVenta')->name('cargarVenta');
    Route::get('/checkout/{id}','ControladorWebCheckout@eliminarProductoCarrito');
    Route::get('/contacto', 'ControladorWebContacto@index');
    Route::get('/respuestaincidente', 'ControladorWebRespuestaIncidente@index');
    Route::get('/registro', 'ControladorWebRegistro@index');
    Route::post('/registro', 'ControladorWebRegistro@guardar');
    Route::get('/micuenta', 'ControladorWebMicuenta@index');
    Route::post('/micuenta', 'ControladorWebMicuenta@guardar');
   
  
    Route::get('/plantilla', 'ControladorWebPlantilla@seleccionar');

    Route::get('/admin', 'ControladorHome@index');
    Route::get('/admin/legajo', 'ControladorLegajo@index');

    Route::get('/admin/home', 'ControladorHome@index');

/* --------------------------------------------- */
/* CONTROLADOR LOGIN                           */
/* --------------------------------------------- */
    Route::get('/admin/login', 'ControladorLogin@index');
    Route::get('/admin/logout', 'ControladorLogin@logout');
    Route::post('/admin/logout', 'ControladorLogin@entrar');
    Route::post('/admin/login', 'ControladorLogin@entrar');

/* --------------------------------------------- */
/* CONTROLADOR RECUPERO CLAVE                    */
/* --------------------------------------------- */
    Route::get('/admin/recupero-clave', 'ControladorRecuperoClave@index');
    Route::post('/admin/recupero-clave', 'ControladorRecuperoClave@recuperar');

/* --------------------------------------------- */
/* CONTROLADOR PERMISO                           */
/* --------------------------------------------- */
    Route::get('/admin/usuarios/cargarGrillaFamiliaDisponibles', 'ControladorPermiso@cargarGrillaFamiliaDisponibles')->name('usuarios.cargarGrillaFamiliaDisponibles');
    Route::get('/admin/usuarios/cargarGrillaFamiliasDelUsuario', 'ControladorPermiso@cargarGrillaFamiliasDelUsuario')->name('usuarios.cargarGrillaFamiliasDelUsuario');
    Route::get('/admin/permisos', 'ControladorPermiso@index');
    Route::get('/admin/permisos/cargarGrilla', 'ControladorPermiso@cargarGrilla')->name('permiso.cargarGrilla');
    Route::get('/admin/permiso/nuevo', 'ControladorPermiso@nuevo');
    Route::get('/admin/permiso/cargarGrillaPatentesPorFamilia', 'ControladorPermiso@cargarGrillaPatentesPorFamilia')->name('permiso.cargarGrillaPatentesPorFamilia');
    Route::get('/admin/permiso/cargarGrillaPatentesDisponibles', 'ControladorPermiso@cargarGrillaPatentesDisponibles')->name('permiso.cargarGrillaPatentesDisponibles');
    Route::get('/admin/permiso/{idpermiso}', 'ControladorPermiso@editar');
    Route::post('/admin/permiso/{idpermiso}', 'ControladorPermiso@guardar');

/* --------------------------------------------- */
/* CONTROLADOR GRUPO                             */
/* --------------------------------------------- */
    Route::get('/admin/grupos', 'ControladorGrupo@index');
    Route::get('/admin/usuarios/cargarGrillaGruposDelUsuario', 'ControladorGrupo@cargarGrillaGruposDelUsuario')->name('usuarios.cargarGrillaGruposDelUsuario'); //otra cosa
    Route::get('/admin/usuarios/cargarGrillaGruposDisponibles', 'ControladorGrupo@cargarGrillaGruposDisponibles')->name('usuarios.cargarGrillaGruposDisponibles'); //otra cosa
    Route::get('/admin/grupos/cargarGrilla', 'ControladorGrupo@cargarGrilla')->name('grupo.cargarGrilla');
    Route::get('/admin/grupo/nuevo', 'ControladorGrupo@nuevo');
    Route::get('/admin/grupo/setearGrupo', 'ControladorGrupo@setearGrupo');
    Route::post('/admin/grupo/nuevo', 'ControladorGrupo@guardar');
    Route::get('/admin/grupo/{idgrupo}', 'ControladorGrupo@editar');
    Route::post('/admin/grupo/{idgrupo}', 'ControladorGrupo@guardar');

/* --------------------------------------------- */
/* CONTROLADOR USUARIO                           */
/* --------------------------------------------- */
    Route::get('/admin/usuarios', 'ControladorUsuario@index');
    Route::get('/admin/usuarios/nuevo', 'ControladorUsuario@nuevo');
    Route::post('/admin/usuarios/nuevo', 'ControladorUsuario@guardar');
    Route::post('/admin/usuarios/{usuario}', 'ControladorUsuario@guardar');
    Route::get('/admin/usuarios/cargarGrilla', 'ControladorUsuario@cargarGrilla')->name('usuarios.cargarGrilla');
    Route::get('/admin/usuarios/buscarUsuario', 'ControladorUsuario@buscarUsuario');
    Route::get('/admin/usuarios/{usuario}', 'ControladorUsuario@editar');

/* --------------------------------------------- */
/* CONTROLADOR MENU                             */
/* --------------------------------------------- */
    Route::get('/admin/sistema/menu', 'ControladorMenu@index');
    Route::get('/admin/sistema/menu/nuevo', 'ControladorMenu@nuevo');
    Route::post('/admin/sistema/menu/nuevo', 'ControladorMenu@guardar');
    Route::get('/admin/sistema/menu/cargarGrilla', 'ControladorMenu@cargarGrilla')->name('menu.cargarGrilla');
    Route::get('/admin/sistema/menu/eliminar', 'ControladorMenu@eliminar');
    Route::get('/admin/sistema/menu/{id}', 'ControladorMenu@editar');
    Route::post('/admin/sistema/menu/{id}', 'ControladorMenu@guardar');

/* --------------------------------------------- */
/* CONTROLADOR TRANSFERENCIA BANCARIA            */
/* --------------------------------------------- */
    Route::get('/admin/mediodepago/transferenciabancaria', 'ControladorTransferenciabancaria@nuevo');
    Route::post('/admin/mediodepago/transferenciabancaria', 'ControladorTransferenciabancaria@guardar');

/* --------------------------------------------- */
/* CONTROLADOR MERCADO PAGO           */
/* --------------------------------------------- */
    Route::get('/admin/mediodepago/mercadopago', 'ControladorMercadopago@index');
    Route::post('/admin/mediodepago/mercadopago', 'ControladorMercadopago@guardar');

/* --------------------------------------------- */
/* CONTROLADOR CATEGORÍAS                        */
/* --------------------------------------------- */
    Route::get('/admin/categorias','ControladorCategoria@index');
    Route::get('/admin/categoria/nuevo','ControladorCategoria@nuevo');
    Route::post('/admin/categoria/nuevo','ControladorCategoria@guardar');
    Route::get('/admin/categoria/eliminar','ControladorCategoria@eliminar');
    Route::get('/admin/categoria/{id}', 'ControladorCategoria@editar');
    Route::post('/admin/categoria/{id}', 'ControladorCategoria@guardar');
    Route:: get('/admin/categorias/cargarGrilla','ControladorCategoria@CargarGrilla')->name('categoria.cargarGrilla');
    
/* ----------------------- */
/*  CONTROLADOR PRODUCTOS */
/* -----------------------*/
    Route::get('/admin/producto/nuevo' , 'ControladorProducto@nuevo');
    Route::get('/admin/productos', 'ControladorProducto@index');
    Route::post('/admin/producto/nuevo', 'ControladorProducto@guardar');
    Route::get('/admin/producto/eliminar', 'ControladorProducto@eliminar');
    Route::get('/admin/productos/cargarGrilla', 'ControladorProducto@cargarGrilla')->name('producto.cargarGrilla');
    Route::get('/admin/producto/{id}', 'ControladorProducto@editar');
    Route::post('/admin/producto/{id}', 'ControladorProducto@guardar');

    /* --------------------------------------------- */
/* CONTROLADOR INCIDENTE                         */
/* --------------------------------------------- */
    Route::get('/admin/incidentes', 'ControladorIncidente@index');
    Route::get('/admin/incidente/nuevo', 'ControladorIncidente@nuevo');
    Route::post('/admin/incidente/nuevo', 'ControladorIncidente@guardar');
    Route::get('/admin/incidente/eliminar', 'ControladorIncidente@eliminar');
    Route::get('/admin/incidente/{id}', 'ControladorIncidente@editar');
    Route::get('/admin/incidente/{id}', 'ControladorIncidente@guardar');
    Route::get('/admin/incidentes/cargarGrilla', 'ControladorIncidente@cargarGrilla')->name('incidente.cargarGrilla');

/* --------------------------------------------- */
/* CONTROLADOR SUCURSAL                          */
/* --------------------------------------------- */
    Route::get('/admin/sucursales', 'ControladorSucursal@index');
    Route::get('/admin/sucursal/nuevo', 'ControladorSucursal@nuevo');
    Route::post('/admin/sucursal/nuevo', 'ControladorSucursal@guardar');
    Route::get('/admin/sucursal/eliminar', 'ControladorSucursal@eliminar');
    Route::get('/admin/sucursal/{id}', 'ControladorSucursal@editar');
    Route::post('/admin/sucursal/{id}', 'ControladorSucursal@guardar');
    Route::get('/admin/sucursales/cargarGrilla', 'ControladorSucursal@cargarGrilla')->name('sucursal.cargarGrilla');

/* --------------------------------------------- */
/* CONTROLADOR VENDEDORES                        */
/* --------------------------------------------- */
    Route::get('/admin/vendedor/nuevo', 'ControladorVendedor@nuevo');
    Route::get('/admin/vendedores', 'ControladorVendedor@index');
    Route::get('/admin/vendedor/cargarGrilla', 'ControladorVendedor@cargarGrilla')->name('vendedor.cargarGrilla');
    Route::post('/admin/vendedor/nuevo','ControladorVendedor@guardar');
    Route::get('/admin/vendedor/{id}', 'ControladorVendedor@editar');
    Route::post('/admin/vendedor/{id}', 'ControladorVendedor@guardar');
\
/* --------------------------------------------- */
/* CONTROLADOR CLIENTE                           */
/* --------------------------------------------- */
    Route::get('/admin/cliente/nuevo', 'ControladorCliente@nuevo');
    Route::post('/admin/cliente/nuevo', 'ControladorCliente@guardar');
    Route::get('/admin/clientes','ControladorCliente@index');
    Route::get('/admin/cliente/cargarGrilla', 'ControladorCliente@cargarGrilla')->name('cliente.cargarGrilla');
    Route::post('/admin/cliente/eliminar', 'ControladorCliente@eliminar');
    Route::get('/admin/cliente/{id}', 'ControladorCliente@editar');
    Route::post('/admin/cliente/{id}', 'ControladorCliente@guardar');


/* --------------------------------------------- */
/* CONTROLADOR VENTA                             */
/* --------------------------------------------- */
    Route::get('/admin/ventas','ControladorVenta@index');
    Route::get('/admin/venta/cargarGrilla', 'ControladorVenta@cargarGrilla')->name('venta.cargarGrilla');

/* --------------------------------------------- */
/* CONTROLADOR MARCA                             */
/* --------------------------------------------- */
    Route::get('/admin/marcas','ControladorMarca@index');
    Route::get('/admin/marca/nuevo','ControladorMarca@nuevo');
    Route::get('/admin/marcas/cargarGrilla', 'ControladorMarca@cargarGrilla')->name('marca.cargarGrilla');
    Route::post('/admin/marca/nuevo', 'ControladorMarca@guardar');
    Route::get('/admin/marca/eliminar', 'ControladorMarca@eliminar');
    Route::get('/admin/marca/{id}', 'ControladorMarca@editar');
    Route::post('/admin/marca/{id}', 'ControladorMarca@guardar');

});
