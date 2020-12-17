<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Categoria;
use App\Entidades\Producto;
use App\Entidades\Carrito_Compra;
use App\Entidades\Marca;
use Session;
use App\Entidades\Moneda;

class ControladorWebBuscador extends Controller
{

    // public function index(Request $request){
    //     $titulo="Buscador";
    //     $categoria=new Categoria();
    //     $array_categoria=$categoria->obtenerTodos();
    //     $producto=new Producto();
    //     $array_producto=$producto->obtenerNuevos20();
    //     $marca=new Marca();
    //     $array_marcas=$marca->obtenerTodos();
    //     $moneda = new Moneda;
    //     $array_moneda = $moneda->obtenerTodos();
    //     $array_vendidos=$producto->masVendidos();
        
    //     return view('web.buscador', compact('titulo', 'array_categoria', 'array_producto', 'array_marcas','array_moneda', 'array_vendidos'));
    // }

    public function buscarProductos(Request $request){
        $titulo = "Resultados";

        $producto = $request->input("txtProducto");
        $categoria = $request->input("lstCategoria");
        $entidad = new Producto();
        $array_resultados = $entidad->obtenerResultados($producto, $categoria);

        $cantidad_resultados = count($array_resultados);

        $categoria = new Categoria();
        $array_categoria = $categoria->obtenerTodos();

        $entidadProducto = new Producto();
        $array_nuevos_20 = $entidadProducto->obtenerNuevos20();

        $marca=new Marca();
        $array_marcas=$marca->obtenerTodos();

        $moneda = new Moneda;
        $array_moneda = $moneda->obtenerTodos();

        $array_mas_vendidos=$entidadProducto->masVendidos();

        return view('web.buscador', compact('titulo', 'array_resultados', 'array_categoria', 'array_nuevos_20', 'array_marcas', 'array_moneda', 'array_mas_vendidos', 'cantidad_resultados'));
    }

    public function guardarCarrito(Request $request, $idProducto){
        $titulo="Buscador";
        $categoria=new Categoria();
        $array_categoria=$categoria->obtenerTodos();
        $producto=new Producto();
        $marca=new Marca();
        $array_marcas=$marca->obtenerTodos();
        $array_producto=$producto->obtenerNuevos20();
        $carrito = new Carrito_Compra();
        $carrito->cargarDesdeRequest($request);

        $carrito->fk_idproducto = $idProducto;
        $carrito->cantidad = 1;
        $carrito->fk_idcliente = Session::get('cliente_id'); 
        $carrito->fecha = date('Y-m-d H:m:i');

        $carrito->insertar();

       return view('web.buscador', compact('titulo', 'array_categoria', 'array_producto', 'carrito', 'array_marcas'));
    }

}