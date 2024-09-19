<?php
// Inicia o reanuda la sesión si no está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    die("Error: Usuario no autenticado."); // Si no hay sesión iniciada, se muestra un error
}

// Obtener el ID del usuario logueado
$id_persona = $_SESSION['id_usuario'];

// Cargar la librería FPDF para generar PDFs
require('./fpdf.php');

// Conexión a la base de datos
require_once('../conexionbd.php');

// Clase PDF que extiende FPDF, usada para definir encabezados y pie de página
class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Añade un logo a la cabecera del PDF
        $this->Image('logoboliviamar.png', 20, 15, 20); // Logo del instituto
        $this->SetFont('Arial', 'B', 19); // Establece la fuente
        $this->Cell(10); // Añade un espacio a la izquierda
        $this->SetTextColor(0, 0, 0); // Establece el color del texto
        // Títulos del encabezado
        $this->Cell(0, 10, utf8_decode('INSTITUTO TECNOLÓGICO'), 0, 1, 'C');
        $this->Cell(0, 10, utf8_decode('BOLIVIA MAR'), 0, 1, 'C');
        $this->Cell(0, 10, utf8_decode('BOLETA DE INSCRIPCIÓN'), 0, 1, 'C');
        $this->Ln(1); // Añade un salto de línea

    }

    // Pie de página
    function Footer()
    {
        // Posición a 15 mm del final de la página
        $this->SetY(-15);
        // Establece la fuente del pie de página
        $this->SetFont('Arial', 'I', 8);
        // Número de página centrado
        $this->Cell(0, 10, utf8_decode('Pág.') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

try {
    // Verificar si el ID de inscripción fue pasado en la URL
    if (isset($_GET['id_inscripcion'])) {
        $id_inscripcion = $_GET['id_inscripcion'];

        // Obtener detalles de la inscripción usando el id_inscripcion
        $stmt = $conexion->prepare("SELECT nro_deposito, pago, saldo, fechaCreacion, id_inscripcion 
                                 FROM inscripcion 
                                 WHERE id_inscripcion = ?");
        $stmt->bind_param('i', $id_inscripcion); // Vincula el parámetro id_inscripcion
        $stmt->execute();
        $result = $stmt->get_result();
        $inscripcion = $result->fetch_assoc(); // Obtiene los detalles de la inscripción

        // Si no se encuentran detalles de la inscripción, lanza una excepción
        if (!$inscripcion) {
            throw new Exception('No se encontraron datos de la inscripción.');
        }
    } else {
        // Si no se proporciona el ID de inscripción en la URL, lanza una excepción
        throw new Exception('No se proporcionó el ID de la inscripción.');
    }

    // Obtener detalles del curso
    if (isset($_GET['id_curso'])) {
        $id_curso = $_GET['id_curso'];

        // Consulta para obtener los detalles del curso con el id_curso proporcionado
        $stmt = $conexion->prepare("SELECT nombre_curso, precio, horario, fechaInicio, descripcion, lugar 
                                FROM curso 
                                WHERE id_curso = ?");
        $stmt->bind_param('i', $id_curso); // Vincula el parámetro id_curso
        $stmt->execute();
        $result = $stmt->get_result();
        $course = $result->fetch_assoc(); // Obtiene los detalles del curso

        // Si no se encuentran detalles del curso, lanza una excepción
        if (!$course) {
            throw new Exception('No se encontraron datos del curso seleccionado.');
        }
    } else {
        // Si no se proporciona el ID del curso en la URL, lanza una excepción
        throw new Exception('No se proporcionó el ID del curso.');
    }

    // Obtener detalles del estudiante
    $stmt = $conexion->prepare("SELECT ci, nombre, apellido, correo, celular, tipo_usuario 
                                FROM usuario 
                                WHERE id_usuario = ?");
    $stmt->bind_param('i', $id_persona); // Vincula el parámetro id_usuario
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc(); // Obtiene los detalles del estudiante

    // Si no se encuentran detalles del estudiante, lanza una excepción
    if (!$student) {
        throw new Exception('No se encontraron datos del estudiante.');
    }
} catch (Exception $e) {
    // Si ocurre alguna excepción, muestra un mensaje de error
    echo 'Error: ' . $e->getMessage();
    exit;
}

// Creación de la tabla en el PDF
$pdf = new PDF();
$pdf->AddPage(); // Añade una nueva página al PDF
$pdf->AliasNbPages(); // Usa alias para el número total de páginas

// Sección: Datos del Estudiante
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, utf8_decode('DATOS DEL ESTUDIANTE'), 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);

// Imagen del estudiante o un marcador (en este caso, el logo se reutiliza)
$pdf->Cell(30, 32, $pdf->Image('usuario.png', $pdf->GetX() + 2, $pdf->GetY() + 2, 25), 1, 0, 'C');

// Detalles del estudiante
$pdf->Cell(25, 8, utf8_decode('CARNET:'), 1);
$pdf->Cell(55, 8, utf8_decode($student['ci']), 1);
$pdf->Cell(25, 8, utf8_decode('CELULAR:'), 1);
$pdf->Cell(55, 8, utf8_decode($student['celular']), 1);
$pdf->Ln(); // Salto de línea
$pdf->Cell(30, 8, utf8_decode(''), 0); // Celda vacía para el formato
$pdf->Cell(25, 8, utf8_decode('APELLIDOS:'), 1);
$pdf->Cell(135, 8, utf8_decode($student['apellido']), 1);
$pdf->Ln();
$pdf->Cell(30, 8, utf8_decode(''), 0);
$pdf->Cell(25, 8, utf8_decode('NOMBRE:'), 1);
$pdf->Cell(135, 8, utf8_decode($student['nombre']), 1);
$pdf->Ln();
$pdf->Cell(30, 8, utf8_decode(''), 0);
$pdf->Cell(25, 8, utf8_decode('EMAIL:'), 1);
$pdf->Cell(135, 8, utf8_decode($student['correo']), 1);
$pdf->Ln();

// Sección: Datos del Curso
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, utf8_decode('DATOS DEL CURSO'), 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);

// Detalles del curso
$pdf->Cell(40, 8, utf8_decode('NOMBRE DEL CURSO:'), 1);
$pdf->Cell(150, 8, utf8_decode($course['nombre_curso']), 1);
$pdf->Ln();
$pdf->Cell(30, 8, utf8_decode('DESCRIPCIÓN:'), 1);
$pdf->Cell(160, 8, utf8_decode($course['descripcion']), 1);
$pdf->Ln();
$pdf->Cell(40, 8, utf8_decode('PRECIO DEL CURSO:'), 1);
$pdf->Cell(150, 8, utf8_decode($course['precio'] . ' Bs'), 1);
$pdf->Ln();
$pdf->Cell(30, 8, utf8_decode('HORARIO:'), 1);
$pdf->Cell(70, 8, utf8_decode($course['horario']), 1);
$pdf->Cell(35, 8, utf8_decode('FECHA DE INICIO:'), 1);
$pdf->Cell(55, 8, utf8_decode($course['fechaInicio']), 1);
$pdf->Ln();
$pdf->Cell(30, 8, utf8_decode('LUGAR:'), 1);
$pdf->Cell(160, 8, utf8_decode($course['lugar']), 1);
$pdf->Ln();

// Sección: Datos de la Inscripción
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, utf8_decode('DATOS DE LA INSCRIPCIÓN'), 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);

// Detalles de la inscripción
$pdf->Cell(30, 8, utf8_decode('ID INSCRIPCIÓN:'), 1);
$pdf->Cell(20, 8, utf8_decode($inscripcion['id_inscripcion']), 1);
$pdf->Cell(30, 8, utf8_decode('NRO DEPOSITO:'), 1);
$pdf->Cell(20, 8, utf8_decode($inscripcion['nro_deposito']), 1);
$pdf->Cell(50, 8, utf8_decode('FECHA DE INSCRIPCIÓN:'), 1);
$pdf->Cell(40, 8, utf8_decode($inscripcion['fechaCreacion']), 1);
$pdf->Ln();
$pdf->Cell(35, 8, utf8_decode('MONTO PAGADO:'), 1);
$pdf->Cell(30, 8, utf8_decode($inscripcion['pago'] . ' Bs'), 1);
$pdf->Cell(40, 8, utf8_decode('SALDO PENDIENTE:'), 1);
$pdf->Cell(30, 8, utf8_decode($inscripcion['saldo'] . ' Bs'), 1);
$pdf->Cell(55, 8, utf8_decode(''), 1);
$pdf->Ln(12);
// Genera el PDF y envía al navegador
$pdf->Output();
// Cierra la conexión a la base de datos
$conexion->close(); 