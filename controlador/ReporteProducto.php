<?php
class ReporteProducto{
    function producto(){
        require_once 'modelo/ProductoModelo.php';
        //Realizamos la consulta a la BD
        $productoModelo = new ProductoModelo();

        $compras = $productoModelo->seleccionar('codigo, nombre, precio, descripcion, fecha', 'estado = 1');


        // echo "Soy el metodo prueba";
        require_once('librerias/fpdf/fpdf.php');

        //Paso 1, Crear el objeto
        $pdf = new PDF('L', 'mm','Letter');

        $pdf->AliasNbPages(); //Metodo para obtener la cantidad de paginas

        //Agregar una pagina
        $pdf->AddPage();

        //Le damos la fuente o tipo de letra
        $pdf->SetFont('Courier','',14);

        //Tabla de compras
        $i = 1; //Para la columna que es el numero

        foreach($compras as $producto){
            $pdf->Cell(15, 10, $i, 1, 0, 'R');
            $pdf->Cell(25, 10, $producto['codigo'], 1, 0, 'L');
            $pdf->Cell(50, 10, $producto['nombre'], 1, 0, 'L');
            $pdf->Cell(20, 10, $producto['precio'], 1, 0, 'L');
            $pdf->Cell(85, 10, $producto['descripcion'], 1, 0, 'R');
            $pdf->Cell(60, 10, $producto['fecha'], 1, 0, 'C');
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
        $this->cell(200,10,'REPORTE PRODUCTOS', '', 0 ,'C');
        $this->Ln();
        $this->Ln();

        //Tabla de compras
        $this->Cell(15, 10, 'Nro', 1, 0, 'C');
        $this->Cell(25, 10, 'Codigo', 1, 0, 'C');
        $this->Cell(50, 10, 'Nombre', 1, 0, 'C');
        $this->Cell(20, 10, 'Precio', 1, 0, 'C');
        $this->Cell(85, 10, 'Descripcion', 1, 0, 'C');
        $this->Cell(60, 10, 'Fecha', 1, 0, 'C');
        $this->Ln();
    }
    function Footer(){
        $this->setY(-15);
        $this->Cell(180, 10, 'Sistema desarrollado por Ronald Bismar', 'T', 0, 'C');
        $this->Cell(20, 10, 'Pag'.$this->PageNo().'/{nb}', 'T', 0, 'C');
    }
}
?>