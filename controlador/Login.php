<?php
class Login{
    function index(){
        require_once "vista/login/index.php";
    }

    function verificar(){
        $usuarioEntrada = $_POST['usuarioEntrada'];
        $contrasenaEntrada = $_POST['contrasenaEntrada'];

        echo $usuarioEntrada ;
        echo $contrasenaEntrada ;

        //Llamar al modelo usuario
        require_once "modelo/UsuarioModelo.php";
        $usuarioModelo = new UsuarioModelo();
        $condiciones = "estado = 1 and usuario = '$usuarioEntrada' and contrasenia = '$contrasenaEntrada'";
        $usuarios = $usuarioModelo->seleccionar("*", $condiciones);

        // echo "Cantidad de usuarios: " . count($usuarios);
        // echo "<br>";
        // echo "Condiciones: " . $condiciones;
        // exit();

        if(count($usuarios) > 0){
            $_SESSION['usuario'] = $usuarios[0];
            header('Location: ./?c=Principal&m=inicio');
            exit();
        } else {
            header('Location: ./?c=Login&m=index');
            exit();
        }
    }

    function salir(){
        session_start();
        unset($_SESSION['usuario']);
        session_destroy();
        header('Location: ./?c=Login&m=index');
    }
}
?>
