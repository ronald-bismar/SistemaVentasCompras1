<?php
class Compra
{
    // Métodos
    function nuevo()
    {
        require_once "modelo/ProductoModelo.php";
        $productoModelo = new ProductoModelo();
        $productos = $productoModelo->seleccionar('*', 'estado = 1');

        $vista = "vista/compra/nuevo.php";
        require_once "vista/cargador.php";
    }

    function guardar()
    {
        $datosEnviar = [
            'cantidad' => $_POST['cantidad'],
            'id_producto' => $_POST['id_producto']
        ];

        require_once "modelo/CompraModelo.php";
        $compraModelo = new CompraModelo();
        $respuesta = $compraModelo->insertar($datosEnviar);

        if ($respuesta) {
            header("Location: ../?c=Compra&m=listar");
        } else {
            $mensaje = "Error al insertar el registro.";
            $vista = "vista/compra/mensaje.php";
            require_once "vista/cargador.php";
        }
    }

    function listar()
    {
        require_once "modelo/CompraModelo.php";
        require_once "modelo/ProductoModelo.php";
        $productoModelo = new ProductoModelo();
        $productos = $productoModelo->seleccionar('*', 'estado = 1');
        // var_dump($productos);
        //paginacion
        $total = count($productos);
        $cantidadElementosPagina = 5;
        $numeroVueltas = ceil($total / $cantidadElementosPagina);
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $cantidadElementosPagina;
        $productos = array_slice($productos, $inicio, $cantidadElementosPagina);
        // var_dump($total);
        // var_dump($numeroVueltas);
        // var_dump($compra);
        // exit();
        $vista = "vista/compra/listado.php";
        require_once "vista/cargador.php";
    }
    

    function modificar()
    {
        $id = $_GET['id'];
        require_once "modelo/CompraModelo.php";
        require_once "modelo/ProductoModelo.php";
        
        $compraModelo = new CompraModelo();
        $productoModelo = new ProductoModelo();
        $compras = $compraModelo->seleccionar('*', "id_compra=$id");
        $compra = $compras[0];
        $id_producto = $compra['id_producto'];
        $producto = $productoModelo->seleccionar('*', "estado = 1 AND id_producto = $id_producto");

        $compra['foto'] = $producto[0]['foto'];

        $vista = "vista/compra/modificar.php";
        require_once "vista/cargador.php";
    }

    function actualizar()
    {
        $id = $_POST['id'];
        $datosEnviar = ['cantidad' => $_POST['cantidad']];
        $condicion = "id_compra=$id";

        require_once "modelo/CompraModelo.php";
        $compraModelo = new CompraModelo();
        $respuesta = $compraModelo->modificar($datosEnviar, $condicion);

        if ($respuesta) {
            header("Location: ../?c=Compra&m=listar");
        } else {
            $mensaje = "Error al modificar.";
            $vista = "vista/compra/mensaje.php";
            require_once "vista/cargador.php";
        }
    }

    function eliminar()
    {
        $id = $_GET['id'];
        require_once "modelo/CompraModelo.php";
        
        $compraModelo = new CompraModelo();
        $respuesta = $compraModelo->eliminar("id_compra = $id");

        if ($respuesta) {
            $mensaje = "La compra se eliminó correctamente.";
            $vista = "vista/compra/mensaje.php";
            require_once "vista/cargador.php";
        } else {
            $mensaje = "La compra no existe o no se pudo eliminar.";
            $vista = "vista/compra/mensaje.php";
            require_once "vista/cargador.php";
        }
    }
    function mostrarFormularioCompra()
{
    $id_producto = $_GET['id_producto'];
    require_once "modelo/ProductoModelo.php";
    
    $productoModelo = new ProductoModelo();
    $producto = $productoModelo->seleccionar('*', "id_producto = $id_producto AND estado = 1");
    
    if (!empty($producto)) {
        $producto = $producto[0];
        $vista = "vista/compra/formulario.php";
        require_once "vista/cargador.php";
    }
}

}
