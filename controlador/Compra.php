<?php
class Compra
{
    //atributos


    //metodos|
    function nuevo()
    {
        require_once "modelo/ProductoModelo.php";
        $productoModelo = new ProductoModelo();
        $productos = $productoModelo->seleccionar('*', 'estado = 1');
        // echo "soy el metodo nuevo compra";
        $vista = "vista/compra/nuevo.php"; // tiene el formulario
        require_once "vista/cargador.php"; //contiene la plantilla
    }

    function guardar()
    {
        // echo "soy el metodo guardar compra";
        // 1er Recibir la informacion
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $foto = $_FILES['foto'];
        // 2do Revisar los valores recibidos
        // echo $codigo . "<br>";
        // echo $nombre . "<br>";
        // echo $precio . "<br>";
        // echo $descripcion . "<br>";
        //echo $foto."<br>";
        // var_dump($foto);
        //verificar el archivo (imagen)

        if ($foto['error'] != 0) {
            $mensaje = "Error al cargar la imagen";
            $vista = "vista/compra/mensaje.php";
            require_once "vista/cargador.php";
            return;
        }
        if (($foto['type'] != 'image/jpeg') || ($foto['type'] != 'image/png')) {
            // valido la imagen 

        } else {
            $mensaje = "Error en el tipo de imagen";
            $vista = "vista/compra/mensaje.php";
            require_once "vista/cargador.php";
            return;
        }
        if ($foto['size'] <= 4 * 1024 * 1024) { //verificando que el archivo en
            //byte tengaun maximo de 2mb
            //guardar en la carpeta imagenes/productos
            $nombreArchivo = $foto['name'];
            $nombreArchivo = date("Y_m_d_H_i_s") . $nombreArchivo;
            copy($foto['tmp_name'], 'imagenes/productos/' . $nombreArchivo);
            //Enviar todos los datos
            $datosEnviar = [
                'codigo' => $codigo,
                'nombre' => $nombre,
                'precio' => $precio,
                'descripcion' => $descripcion,
                'foto' => $nombreArchivo
            ];
            //Tenemos que manejar el modelo
            require_once "modelo/ProductoModelo.php";
            $productoModelo = new ProductoModelo();
            $respuesta = $productoModelo->insertar($datosEnviar); //Enviamos desde el controlador
            if ($respuesta) {
                //todo esta correcto
                // echo "Registro insertado correctamente";
                header("Location: ../?c=compra&m=listar");
                //redireccionar a la lista de productos
            } else {
                $mensaje = "Error al insertar el registro.......";
                $vista = "vista/compra/mensaje.php";
                require_once "vista/cargador.php";
                return;
            }
        } else {
            // echo "Error en el tamaño de la imagen";
            $mensaje = "exisitio un error al subir el archivo";
            $vista = "vista/compra/mensaje.php";
            require_once "vista/cargador.php";
            return;
        }
    }

    function listar()
    {
        require_once "modelo/ProductoModelo.php";
        $productoModelo = new ProductoModelo();
        $productos = $productoModelo->seleccionar('*', 'estado = 1');
        // var_dump($productos);
        //paginacion
        $total = count($productos);
        $cantidadElementosPagina = 5;
        $numeroVueltas = ceil($total / $cantidadElementosPagina); //lo redondea al el ceil .......averiguar 
        // $pagina = $_GET['pagina'];
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
        // echo "soy el metodo modificar compra";
        $id = $_GET['id']; // Recibido vía GET
        require_once "modelo/ProductoModelo.php";
        $productoModelo = new ProductoModelo();
        $productos = $productoModelo->seleccionar('*', "id_producto=$id");
        $compra = $productos[0]; // Obtener el primer compra
        // var_dump($productos);//muestra los resultados

        $vista = "vista/compra/modificar.php";
        require_once "vista/cargador.php";
    }

    function actualizar()
    {
        // echo "soy el metodo actualizar compra";
        // 1. Recibir la informacion del compra
        $id = $_POST['id']; // Recibido vía POST
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $foto = $_FILES['foto'];
        // 2. Revisar los valores recibidos
        // echo $codigo . "<br>";
        // echo $nombre . "<br>";
        // echo $precio . "<br>";
        // echo $descripcion . "<br>";
        //echo $foto."<br>";
        // var_dump($foto);

        // Verificar si no se ha subido una nueva imagen O ESTA VACIO
        $nombreArchivo = '';
        if ($foto['name'] == "") {
            $nombreArchivo = $_POST['fotoActual']; // Mantener la imagen actual si no se sube una nueva
        } else {
            if ($foto['error'] != 0) {
                $mensaje = "Error al cargar el archivo";
                $vista = "vista/compra/mensaje.php";
                require_once "vista/cargador.php"; //contiene la plantilla
            }
            if ($foto['type'] != 'image/jpeg' && $foto['type'] != 'image/png') {
                $mensaje = "Error en el tipo de imagen";
                $vista = "vista/compra/mensaje.php";
                require_once "vista/cargador.php"; //contiene la plantilla
            }
            if ($foto['size'] <= 4 * 1024 * 1024) { //verificando que el archivo en byte tengaun maximo de 2mb
                //guardar en la carpeta imagenes/productos CON NOMBRE Y FECHA
                $nombreArchivo = $foto['name'];
                $nombreArchivo = date("Y_m_d_H_i_s") . $nombreArchivo;
                copy($foto['tmp_name'], 'imagenes/productos/' . $nombreArchivo);
            } else {
                // echo "<div class='alert alert-danger'>Error en el tamaño de la imagen.</div>";
                $mensaje = "Error en el tamaño de la imagen";
                $vista = "vista/compra/mensaje.php";
                require_once "vista/cargador.php"; //contiene la plantilla
            }
        }

        //Enviar todos los datos
        $datosEnviar = [
            'codigo' => $codigo,
            'nombre' => $nombre,
            'precio' => $precio,
            'descripcion' => $descripcion,
            'foto' => $nombreArchivo
        ];
        if ($nombreArchivo != '') {
            $datosEnviar['foto'] = $nombreArchivo;
        }
        $condicion = "id_producto=$id";
        //Tenemos que manejar el modelo
        require_once "modelo/ProductoModelo.php";
        $productoModelo = new ProductoModelo();
        $respuesta = $productoModelo->modificar($datosEnviar, $condicion); //Enviamos desde el controlador
        if ($respuesta) {
            //todo esta correcto
            header("Location: ../?c=Compra&m=listar");
         
        } else {
            $mensaje = "Error al modificar.......";
            $vista = "vista/compra/mensaje.php";
            require_once "vista/cargador.php";
        }
    }

    function eliminar()
    {
        // 1. Recibir el ID del compra a eliminar (vía GET)
        $id = $_GET['id']; // Recibido vía GET

        // 2. Instanciar el modelo de Compra
        require_once "modelo/ProductoModelo.php";

        $productoModelo = new ProductoModelo();
        $condicion = "id_producto = $id";

        // 3. Ejecutar la eliminación y asignar el resultado a $respuesta
        $respuesta = $productoModelo->eliminar($condicion);

        // 4. Comprobar la respuesta y proceder
        if ($respuesta) {
            // Eliminación exitosa, redireccionar a la lista de productos
            // echo "El compra se eliminó";
            // header("Location: ./?c=compra&m=listar");
            // exit(); // Asegura que no se ejecuta más código después de la redirección

            $mensaje = "El compra se elimino corectamente.";
            $vista = "vista/compra/mensaje.php";
            require_once "vista/cargador.php";
        } else {
            $mensaje = "El compra no existe o no se pudo eliminar.";
            $vista = "vista/compra/mensaje.php";
            require_once "vista/cargador.php";
        }
    }
}