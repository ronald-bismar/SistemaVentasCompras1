<?php
class ReporteUsuario{
    function usuario(){
        require_once 'modelo/UsuarioModelo.php';
        //Realizamos la consulta a la BD
        $usuarioModelo = new UsuarioModelo();

        $usuarios = $usuarioModelo->seleccionar('*', 'estado = 1');


        // echo "Soy el metodo prueba";
        require_once('librerias/fpdf/fpdf.php');

        //Paso 1, Crear el objeto
        $pdf = new PDF('L', 'mm','Letter');

        $pdf->AliasNbPages(); //Metodo para obtener la cantidad de paginas

        //Agregar una pagina
        $pdf->AddPage();

        //Le damos la fuente o tipo de letra
        $pdf->SetFont('Courier','',14);

        //Tabla de usuarios
        $i = 1; //Para la columna que es el numero

        foreach($usuarios as $usuario){
            $pdf->Cell(15, 10, $i, 1, 0, 'R');
            $pdf->Cell(80, 10, $usuario['nombres']." ".$usuario['apellido_paterno']." ".$usuario['apellido_materno'], 1, 0, 'L');
            $pdf->Cell(50, 10, $usuario['usuario'], 1, 0, 'L');
            $pdf->Cell(85, 10, $usuario['fecha'], 1, 0, 'L');
            $pdf->Cell(30, 10, $usuario['estado'] == '1'? 'activo': 'inactivo', 1, 0, 'R');
            $i++;
            $pdf->Ln();
        }
        $pdf->Output(); //Salida del archivo pdf
    }
}
require_once('librerias/fpdf/fpdf.php');
class PDF extends FPDF{
    function Header(){
        $this->SetFont('Arial', 'B', 16);
        $this->cell(200,10,'REPORTE USUARIOS', '', 0 ,'C');
        $this->Ln();
        $this->Ln();

        //Tabla de usuarios
        $this->Cell(15, 10, 'Nro', 1, 0, 'C');
        $this->Cell(80, 10, 'Nombre', 1, 0, 'C');
        $this->Cell(50, 10, 'Usuario', 1, 0, 'C');
        $this->Cell(85, 10, 'Fecha', 1, 0, 'C');
        $this->Cell(30, 10, 'Estado', 1, 0, 'C');
        $this->Ln();
    }
    function Footer(){
        $this->setY(-15);
        $this->Cell(180, 10, 'Sistema desarrollado por Ronald Bismar', 'T', 0, 'C');
        $this->Cell(20, 10, 'Pag'.$this->PageNo().'/{nb}', 'T', 0, 'C');
    }
}
?>