<?php
class Estadistica{
    function compra(){

        require_once 'modelo/CompraModelo.php';
        $compraModelo = new CompraModelo();
        $compraModelo->nuevaTabla('compras c, productos p');
        $compras = $compraModelo->seleccionar(campos: 'c.id_producto, p.nombre, SUM(cantidad) AS cantidad',condiciones: 'c.estado = 1 and c.id_producto = p.id_producto',camposGroupBy: 'id_producto');

        $vista = "vista/estadistica/graficacompra.php";
        require_once "vista/cargador.php";
    }
    function producto(){

        require_once 'modelo/ProductoModelo.php';
        $compraModelo = new ProductoModelo();
        $productos = $compraModelo->seleccionar(campos: 'nombre, precio',condiciones: 'estado = 1');

        $vista = "vista/estadistica/graficaproducto.php";
        require_once "vista/cargador.php";
        
    }
}
?>