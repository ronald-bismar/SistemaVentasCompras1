<?php
    // URL de ejemplo: http://localhost/SistemaVentasCompras/?c=producto&m=salir
    // URL para controlar errores: http://localhost/SistemaVentasCompras/?c=producto&m=error

    // Asignamos el controlador y método desde los parámetros GET, con valores predeterminados

 date_default_timezone_set('America/La_Paz');

    $controlador = $_GET['c'] ?? 'Principal'; // 'Pricipal' corregido a 'Principal'
    $metodo = $_GET['m'] ?? 'inicio'; 

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