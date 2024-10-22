<?php
    // URL de ejemplo: http://localhost/SistemaVentasCompras/?c=producto&m=salir
    // URL para controlar errores: http://localhost/SistemaVentasCompras/?c=producto&m=error

    // Asignamos el controlador y método desde los parámetros GET, con valores predeterminados

    // Start the session at the very beginning
    session_start();

    date_default_timezone_set('America/La_Paz');

    $controlador = $_GET['c'] ?? 'Principal'; // 'Pricipal' corregido a 'Principal'
    $metodo = $_GET['m'] ?? 'inicio'; 

    // Check if the user is not logged in and trying to access a page other than Login
    if(!isset($_SESSION['usuario']) && $controlador != 'Login'){ // Cuando no existe sesion
        $controlador = 'Login';
        $metodo = 'index';
    }

    // Manejo de fallos: Verificamos si el archivo del controlador existe
    if (!file_exists("controlador/$controlador.php")) {
        $controlador = "Noexiste";
        $metodo = "error";
    }

    // Manejo de excepciones y errores
    try {
        require_once "controlador/$controlador.php";
        $objeto = new $controlador(); // Instancia de la clase
        $objeto->$metodo(); // Llamada al método
    } catch (Error | Exception $e) {
        $controlador = "Noexiste";
        $metodo = "error";
        require_once "controlador/$controlador.php";
        $objeto = new $controlador(); // Instancia de la clase
        $objeto->$metodo(); // Llamada al método
        echo $e;
    }
?>
