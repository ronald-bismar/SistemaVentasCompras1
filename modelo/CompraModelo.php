<?php
require_once "BD.php";
    class CompraModelo extends BD
    {
        protected $nombreTabla = 'compras';
        public function nuevaTabla($nombreTablaNueva){
            $this->nombreTabla = $nombreTablaNueva;
        }
    }
?>