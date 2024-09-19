<?php
    class Principal{
        function inicio(){
            // echo "Pagina de inicio";
            $vista = "principal/inicio.php";
            require_once "vista/cargador.php";
        }
    }
    
?>