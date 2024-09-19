<?php
class Usuario
{
    // Métodos
    function nuevo()
    {
        $vista = "vista/usuario/nuevo.php"; 
        require_once "vista/cargador.php"; 
    }

    function guardar()
    {
        $datosEnviar = [
            'apellido_paterno' => $_POST['paterno'],
            'apellido_materno' => $_POST['materno'],
            'nombres' => $_POST['nombre'],
            'usuario' => $_POST['usuario'],
            'contrasenia' => $_POST['contrasenia']
        ];

        require_once "modelo/UsuarioModelo.php";
        $usuarioModelo = new UsuarioModelo();
        $respuesta = $usuarioModelo->insertar($datosEnviar);

        if ($respuesta) {
            header("Location: ../?c=Usuario&m=listar");
        } else {
            $mensaje = "Error al insertar el registro.";
            $vista = "vista/usuario/mensaje.php";
            require_once "vista/cargador.php";
        }
    }

    function listar()
    {
        require_once "modelo/UsuarioModelo.php";
        $usuarioModelo = new UsuarioModelo();
        $usuarios = $usuarioModelo->seleccionar('*', 'estado = 1');
        $total = count($usuarios);
        $cantidadElementosPagina = 5;
        $numeroVueltas = ceil($total / $cantidadElementosPagina);
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($pagina - 1) * $cantidadElementosPagina;
        $usuarios = array_slice($usuarios, $inicio, $cantidadElementosPagina);
        $vista = "vista/usuario/listado.php";
        require_once "vista/cargador.php";
    }

    function modificar()
    {
        $id = $_GET['id'];
        require_once "modelo/UsuarioModelo.php";
        $usuarioModelo = new UsuarioModelo();
        $usuario = $usuarioModelo->seleccionar('*', "id_usuario=$id")[0];

        $vista = "vista/usuario/modificar.php";
        require_once "vista/cargador.php";
    }

    function actualizar()
    {
        $datosEnviar = [
            'apellido_paterno' => $_POST['apellido_paterno'],
            'apellido_materno' => $_POST['apellido_materno'],
            'nombres' => $_POST['nombres'],
            'usuario' => $_POST['usuario']
        ];

        $condicion = "id_usuario=" . $_POST['id'];
        require_once "modelo/UsuarioModelo.php";
        $usuarioModelo = new UsuarioModelo();
        $respuesta = $usuarioModelo->modificar($datosEnviar, $condicion);

        if ($respuesta) {
            header("Location: ../?c=Usuario&m=listar");
        } else {
            $mensaje = "Error al modificar.";
            $vista = "vista/usuario/mensaje.php";
            require_once "vista/cargador.php";
        }
    }

    function eliminar()
    {
        $id = $_GET['id'];
        require_once "modelo/UsuarioModelo.php";
        $usuarioModelo = new UsuarioModelo();
        $respuesta = $usuarioModelo->eliminar("id_usuario = $id");

        if ($respuesta) {
            header("Location: ./?c=Usuario&m=listar");
        } else {
            $mensaje = "El usuario no existe o no se pudo eliminar.";
            $vista = "vista/usuario/mensaje.php";
            require_once "vista/cargador.php";
        }
    }
}
