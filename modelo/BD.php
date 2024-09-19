<?php

class BD
{
    private $conexion;
    protected $nombreTabla;
    function __construct()
    {
        //Conectamos a la base de datos
        $this->conexion = new mysqli('localhost', 'root', '', 'sistemaventascompras');
    }
    function insertar($valoresEntrada)
    {
        $valoresEntrada['fecha'] = date("Y-m-d H:i:s");

        $valoresEntrada['estado'] = 1;
        //sacamos los keys del array
        $campos = \array_keys($valoresEntrada);
        //unimos los campos con una coma
        $campos = \implode(',', $campos);
        //sacamos los valores del array
        $valores = \array_values($valoresEntrada);
        //unimos los valores con una coma
        $valores = "'" . \implode("','", $valores) . "'";

        $consulta = "INSERT INTO $this->nombreTabla
            ($campos) VALUES($valores)";
            // echo $consulta;
            $respuesta = $this->conexion->query($consulta);
            return $respuesta;
    }
    function seleccionar($campos = '', $condiciones = '', $camposGroupBy = '', $whereHaving = '', $ordenamiento = '', $limite = '')
    {
        if ($condiciones != "") { //esto pregunta si hay condiciones
            $condiciones = "WHERE $condiciones";
        }
        if ($camposGroupBy != "") { //esto pregunta si hay campos para agrupar
            $camposGroupBy = "GROUP BY $camposGroupBy";
        }
        if ($whereHaving != "") { //esto pregunta si hay condiciones para having
            $whereHaving = "HAVING $whereHaving";
        }
        if ($ordenamiento != "") { //esto pregunta si hay ordenamiento
            $ordenamiento = "ORDER BY $ordenamiento";
        }
        if ($limite != "") { //esto pregunta si hay limiteP
            $limite = "LIMIT $limite";
        }
        if ($campos == "") { //esto pregunta si no hay campos
            $campos = "*";
        }
        $consulta = "SELECT $campos FROM $this->nombreTabla $condiciones $camposGroupBy $whereHaving $ordenamiento $limite";
        $respuesta = $this->conexion->query($consulta);
        //devolvemos la respuesta
        $datos = [];
        while ($fila = $respuesta->fetch_assoc()) { //mientras haya filas indice literal
            $datos[] = $fila; //añadimos la fila al array
        }
        return $datos; //retornamos lo datos
    }

    function modificar($valoresEntrada,$condicion) {
        foreach($valoresEntrada as $campo => $valor){
            $campos[] = "$campo = '$valor'";
        }
        $campos = \implode(", ", $campos);
        $consulta = "UPDATE ".$this->nombreTabla ." SET $campos WHERE $condicion";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta; //retornamos la respuesta
    }

    function eliminar($condicion)
    {
        // no se deve eliminar solo lo actualizamos con el update
        // Preparamos la consulta para eliminar el registro
        $consulta = "UPDATE ".$this->nombreTabla." SET estado = 0 WHERE ".$condicion;
        $respuesta = $this->conexion->query($consulta);
        return $respuesta; //retornamos la respuesta
    }
}