<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Producto extends Model
{
    protected $table = 'productos';
    public $timestamps = false;

    protected $fillable = [
        'idproducto', 'nombre', 'descripcion', 'foto', 'video', 'stock', 'precio', 'precio_con_descuento', 'etiqueta', 'fk_idsucursal', 'fk_idcategoria', 'fk_idmarca', 'precio_usd', 'precio_con_descuento_usd', 'fecha'];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idproducto = $request->input('id')!="0" ? $request->input('id') : $this->idproducto;
        $this->nombre = $request->input('txtNombre');
        $this->descripcion = $request->input('txtDescripcion');
        $this->foto = $request->input('archivo');
        $this->video = $request->input('txtVideo');
        $this->stock = $request->input('txtStock');
        $this->precio = $request->input('txtPrecio');
        $this->precio_con_descuento = $request->input('txtPrecioDesc');
        $this->etiqueta = $request->input('txtEtiqueta');
        $this->fk_idsucursal = $request->input('lstSucursal');
        $this->fk_idcategoria = $request->input('lstCategoria');
        $this->fk_idmarca = $request->input('txtMarca');
        $this->precio_usd = $request->input('txtPrecioUsd');
        $this->precio_con_descuento_usd = $request->input('txtPrecioDescUsd');
        $this->fecha = date("Y-m-d H:i:s");
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idproducto,
                  A.nombre,
                  A.descripcion,
                  A.foto,
                  A.video,
                  A.stock,
                  A.precio,
                  A.precio_con_descuento,
                  A.etiqueta,
                  A.fk_idsucursal,
                  A.fk_idcategoria,
                  A.fk_idmarca,
                  A.precio_usd,
                  A.precio_con_descuento_usd
                FROM productos A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }   

    public function obtenerPorId($idproducto) {
        $sql = "SELECT
                idproducto,
                nombre,
                descripcion,
                foto,
                video,
                stock,
                precio,
                precio_con_descuento,
                etiqueta,
                fk_idcategoria,
                fk_idsucursal,
                fk_idmarca,
                precio_usd,
                precio_con_descuento_usd
                FROM productos WHERE idproducto = $idproducto";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idproducto = $lstRetorno[0]->idproducto;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->descripcion = $lstRetorno[0]->descripcion;
            $this->foto = $lstRetorno[0]->foto;
            $this->video = $lstRetorno[0]->video;
            $this->stock = $lstRetorno[0]->stock;
            $this->precio = $lstRetorno[0]->precio;
            $this->precio_con_descuento = $lstRetorno[0]->precio_con_descuento;
            $this->etiqueta = $lstRetorno[0]->etiqueta;
            $this->fk_idsucursal = $lstRetorno[0]->fk_idsucursal;
            $this->fk_idcategoria = $lstRetorno[0]->fk_idcategoria;
            $this->fk_idmarca = $lstRetorno[0]->fk_idmarca;
            $this->precio_usd = $lstRetorno[0]->precio_usd;
            $this->precio_con_descuento_usd = $lstRetorno[0]->precio_con_descuento_usd;
            return $this;
        }
        return null;
    }   

    public  function eliminar() {
        $sql = "DELETE FROM productos WHERE 
            idproducto=?";
        $affected = DB::delete($sql, [$this->idproducto]);
    }

    public function insertar() {
        $sql = "INSERT INTO productos (
                nombre,
                descripcion,
                foto,
                video,
                stock,
                precio,
                precio_con_descuento,
                etiqueta,
                fk_idsucursal,
                fk_idcategoria,
                fk_idmarca,
                precio_usd,
                precio_con_descuento_usd,
                fecha
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
           
       $result = DB::insert($sql, [
            $this->nombre, 
            $this->descripcion, 
            $this->foto, 
            $this->video, 
            $this->stock, 
            $this->precio,
            $this->precio_con_descuento,
            $this->etiqueta,
            $this->fk_idsucursal,
            $this->fk_idcategoria,
            $this->fk_idmarca,
            $this->precio_usd,
            $this->precio_con_descuento_usd,
            $this->fecha
        ]);

      //  $sql="INSERT INTO categoria_productos (fk_idproducto, fk_idcategoria) VALUES (?,?)";

      // $result = DB::insert($sql, [
       //$this->idproducto, 
         //   $this->fk_idcategoria 
           
       // ]);
       
       return $this->idproducto = DB::getPdo()->lastInsertId();
    }

    public function guardar() {
        $sql = "UPDATE productos SET
            nombre='$this->nombre',
            descripcion='$this->descripcion',
            foto='$this->foto',
            video='$this->video',
            precio='$this->precio',
            precio_con_descuento='$this->precio_con_descuento',
            etiqueta='$this->etiqueta',
            fk_idcategoria='$this->fk_idcategoria',
            fk_idsucursal='$this->fk_idsucursal',
            fk_idmarca='$this->fk_idmarca',
            precio_usd='$this->precio_usd',
            precio_con_descuento_usd='$this->precio_con_descuento_usd'
            WHERE idproducto=?";
        $affected = DB::update($sql, [$this->idproducto]);
    }

     public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.idproducto',  
           1 => 'A.nombre',
           2 => 'A.descripcion',
           3 => 'A.foto',
           4 => 'A.video',
           5 => 'A.stock',
           6 => 'A.precio',
           7 => 'A.precio_con_descuento',
           8 => 'A.etiqueta',
           9 => 'A.fk_idcategoria',
           10 => 'B.nombre',
           11 => 'D.nombre'
            );
        $sql = "SELECT DISTINCT
                A.idproducto,
                A.nombre,
                A.descripcion,
                A.foto,
                A.video,
                A.stock,
                A.precio,
                A.precio_con_descuento,
                A.etiqueta,
                A.fk_idcategoria ,
                B.nombre as sucursal,
                C.nombre as categoria,
                D.nombre as marca
                FROM productos A 
                LEFT JOIN sucursales B ON A.fk_idsucursal = B.idsucursal
                INNER JOIN categorias C ON A.fk_idcategoria = C.idcategoria
                INNER JOIN marcas D ON A.fk_idmarca = D.idmarca
                WHERE 1=1";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.descripcion LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR B.nombre LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerNuevos() {
   
            $sql = "SELECT 
                      A.idproducto,
                      A.nombre,
                      A.descripcion,
                      A.foto,
                      A.video,
                      A.stock,
                      A.precio,
                      A.precio_con_descuento,
                      A.etiqueta,
                      A.fk_idsucursal,
                      A.fk_idcategoria,
                      A.fk_idmarca,
                      CAST((1-(A.precio_con_descuento/A.precio))*100 as INTEGER) as porcentaje,
                      B.nombre as categoria
                    FROM productos A 
                    INNER JOIN categorias B on A.fk_idcategoria = B.idcategoria
                    ORDER BY A.idproducto DESC LIMIT 10";
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
    }

    public function obtenerNuevos20() {   
            $sql = "SELECT 
                      A.idproducto,
                      A.nombre,
                      A.descripcion,
                      A.foto,
                      A.video,
                      A.stock,
                      A.precio,
                      A.precio_con_descuento,
                      A.etiqueta,
                      A.fk_idsucursal,
                      A.fk_idcategoria,
                      B.nombre as categoria,
                      A.fk_idmarca
                    FROM productos A 
                    INNER JOIN categorias B on A.fk_idcategoria = B.idcategoria LIMIT 0, 20";
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
    }

    public function obtenerPrimeros4() {
   
            $sql = "SELECT 
                      A.idproducto,
                      A.nombre,
                      A.descripcion,
                      A.foto,
                      A.video,
                      A.stock,
                      A.precio,
                      A.precio_con_descuento,
                      A.etiqueta,
                      A.fk_idsucursal,
                      A.fk_idcategoria,
                      A.fk_idmarca,
                      B.nombre as categoria
                    FROM productos A 
                    INNER JOIN categorias B on A.fk_idcategoria = B.idcategoria LIMIT 0, 4";
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
    }
    public function obtenerCategoria($id) {
   
        $sql = "SELECT 
                nombre
                FROM categorias 
                WHERE nombre = $id";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
}

    public function obtenerPorCategoria($idproducto, $idcategoria){
        $sql = "SELECT 
                 A.idproducto,
                 A.nombre,
                 A.descripcion,
                 A.foto,
                 A.video,
                 A.stock,
                 A.precio,
                 A.precio_con_descuento,
                 A.etiqueta,
                 A.fk_idcategoria,
                 A.fk_idmarca
                FROM productos A WHERE A.fk_idcategoria = $idcategoria AND A.idproducto != $idproducto ";

        $sql .= " ORDER BY A.idproducto";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function masVendidos(){
        $sql= "SELECT COUNT(A.idventa) AS cantidad, A.fk_idproducto, B.foto, B.nombre, B.precio, B.fk_idcategoria, B.fk_idmarca, B.precio_con_descuento 
        FROM ventas A INNER JOIN productos B ON A.fk_idproducto=B.idproducto 
        GROUP BY A.fk_idproducto, B.nombre, B.precio, B.fk_idcategoria, B.fk_idmarca, B.precio_con_descuento, B.foto ORDER BY cantidad DESC LIMIT 0,10";
        $lstRetorno= DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerResultados($producto, $categoria = ""){
        $sql = "SELECT
                A.idproducto,
                A.nombre,
                A.descripcion,
                A.foto,
                A.video,
                A.stock,
                A.precio,
                A.precio_con_descuento,
                A.etiqueta,
                A.fk_idsucursal,
                B.nombre AS categoria,
                A.fk_idmarca,
                A.precio_usd,
                A.precio_con_descuento_usd,
                CAST((1-(A.precio_con_descuento/A.precio))*100 as INTEGER) as porcentaje,
                A.fecha
            FROM productos A
            INNER JOIN categorias B ON A.fk_idcategoria = B.idcategoria
            WHERE A.nombre LIKE '%$producto%'";
            if($categoria != "")
                $sql.=" AND A.fk_idcategoria = $categoria";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function limitarPrecios($producto = "", $categoria = "", $min, $max){
        $sql = "SELECT
                A.idproducto,
                A.nombre,
                A.descripcion,
                A.fotom
                A.videom
                A.stock,
                A.precio,
                A.precio_con_descuento,
                A.etiqueta,
                A.fk_idsucursalm
                B.nombre AS categoria,
                A.fk_idmarca,
                A.precio_usd,
                A.precio_con_descuento_usd,
                A.fecha
            FROM productos A
            INNER JOIN categorias B ON A.fk_idcategoria = B.idcategoria
            WHERE A.nombre LIKE '%$producto%'";
            if($categoria != "")
                $sql.=" AND A.fk_idcategoria = $categoria";
            $sql.="AND A.precio >= $min AND A.precio <= $max";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }


}