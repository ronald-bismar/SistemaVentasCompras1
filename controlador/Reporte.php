<?php
class Reporte{
    function prueba(){
        // echo "Soy el metodo prueba";
        require_once('librerias/fpdf/fpdf.php');

        //Paso 1, Crear el objeto
        $pdf = new FPDF('P', 'mm',array(200,100));

        //Agregar una pagina
        $pdf->AddPage();

        //Le damos la fuente o tipo de letra
        $pdf->SetFont('Courier','BIU',16);

        //Agregar una celda
        $pdf->Cell(40, 20, 'Sistemas', 'LTR', 1, 'L');
        $pdf->Ln(); //Salto de linea
        $pdf->Cell(50, 20, 'Informaticos', 'LTR', 1, 'R');
        //Para finalizar el documento pdf
        $pdf->Output();
    }
}
?>