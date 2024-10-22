<?php
class ReporteCompra{
    function compra(){
        //Para generar una imagen QR
        require_once 'librerias/phpqrcode/qrlib.php';
        $codeContents = base64_encode('Sistema Ventas'.date("Y-m-d H:i:s")."Password");
        $FilePath = "imagenes/qr/qr.png";
        QRcode::png($codeContents,$FilePath);


        require_once 'modelo/CompraModelo.php';
        //Realizamos la consulta a la BD
        $compraModelo = new CompraModelo();
        $compraModelo->nuevaTabla('compras c, productos p');

        $compras = $compraModelo->seleccionar('p.nombre, c.cantidad, c.fecha', 'c.estado = 1 and c.id_producto = p.id_producto');


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

        foreach($compras as $compra){
            $pdf->Cell(20, 10, $i, 1, 0, 'R');
            $pdf->Cell(80, 10, $compra['nombre'], 1, 0, 'L');
            $pdf->Cell(80, 10, $compra['cantidad'], 1, 0, 'R');
            $pdf->Cell(80, 10, $compra['fecha'], 1, 0, 'C');
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
        $this->Image('imagenes/logo/logo.png', 15 ,10 ,20 ,20);
        $this->Image('imagenes/qr/qr.png', 250 ,10 ,20 ,20);
        $this->cell(200,10,'REPORTE COMPRAS', '', 0 ,'C');
        $this->Ln();
        $this->Ln();

        //Tabla de compras
        $this->Cell(20, 10, 'Nro', 1, 0, 'C');
        $this->Cell(80, 10, 'Producto', 1, 0, 'C');
        $this->Cell(80, 10, 'Cantidad', 1, 0, 'C');
        $this->Cell(80, 10, 'Fecha', 1, 0, 'C');
        $this->Ln();
    }
    function Footer(){
        $this->setY(-15);
        $this->Cell(180, 10, 'Sistema desarrollado por Ronald Bismar', 'T', 0, 'C');
        $this->Cell(20, 10, 'Pag'.$this->PageNo().'/{nb}', 'T', 0, 'C');
    }
}
?>