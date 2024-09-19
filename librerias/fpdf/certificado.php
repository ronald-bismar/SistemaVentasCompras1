<?php
//este codigo lo puedes modificar a tu gusto para generar un certificado

// Inicia o reanuda la sesión si no está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Si no hay una sesión activa, inicia una nueva sesión
}

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    die("Error: Usuario no autenticado."); // Si el usuario no ha iniciado sesión, mostrar error
}

// Obtener el ID del usuario logueado
$id_persona = $_SESSION['id_usuario']; // Almacena el ID del usuario logueado en la variable $id_persona

// Cargar la librería FPDF para generar PDFs
require('./fpdf.php'); // Incluye la librería FPDF para la generación de archivos PDF

// Conexión a la base de datos
require_once('../conexionbd.php'); // Conecta a la base de datos

// Clase PDF que extiende FPDF, usada para definir encabezados y pie de página
class PDF extends FPDF
{
    public $nombre_docente;
    public $apellido_docente;

    // Constructor modificado para aceptar los datos del docente
    function __construct($orientation = 'P', $unit = 'mm', $size = 'A4', $nombre_docente = '', $apellido_docente = '')
    {
        parent::__construct($orientation, $unit, $size); // Llama al constructor de la clase FPDF
        $this->nombre_docente = $nombre_docente; // Almacena el nombre del docente
        $this->apellido_docente = $apellido_docente; // Almacena el apellido del docente
    }

    // Cabecera de página
    function Header()
    {
        // Añade un logo a la cabecera del PDF
        $this->Image('logoboliviamar.png', 10, 5, 80); // Agrega un logo a la izquierda del PDF 
        $this->SetFont('Arial', 'B', 18); // Establece la fuente y tamaño
        $this->Cell(0, 30, '', 0, 1); // Añade un espacio en blanco debajo del logo
        $this->SetFont('Arial', 'B', 35); // Establece fuente grande para "CERTIFICADO"
        $this->Cell(0, 10, utf8_decode('CERTIFICADO'), 0, 1, 'C');
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(0, 10, utf8_decode('DE APROBACIÓN'), 0, 1, 'C');
        $this->Ln(); // Añade una línea de espacio
    }

    // Pie de página
    function Footer()
    {
        // Posición a 15 mm del final de la página
        $this->SetY(-30);
        $this->SetFont('Arial', 'I', 10); // Establece la fuente para las firmas
        // Firma del director e instructor
        $this->Cell(95, 10, utf8_decode('_________________________'), 0, 0, 'C');
        $this->Cell(95, 10, utf8_decode('_________________________'), 0, 0, 'C'); 
        $this->Ln(5);
        // Etiqueta para la firma del director
        $this->Cell(95, 10, utf8_decode('Director'), 0, 0, 'C');
        // Etiqueta Firma del docente responsable
        $this->Cell(95, 10, utf8_decode("Impartido por: " . $this->nombre_docente . ' ' . $this->apellido_docente), 0, 0, 'C');
        // Fecha actual de la certificacion 
        $this->Cell(95, 10, utf8_decode("Fecha de emisión: " . date("d/m/Y")), 0, 1, 'C');
    }
}

try {
    // Verificar si el ID del curso fue pasado en la URL
    if (isset($_GET['id_curso'])) {
        $id_curso = $_GET['id_curso']; // Almacena el ID del curso pasado en la URL

        // Obtener detalles del curso, incluyendo el docente responsable
        $stmt = $conexion->prepare("SELECT c.nombre_curso, c.cargaHoraria, u.nombre AS nombre_docente, u.apellido AS apellido_docente
                                    FROM curso c 
                                    JOIN usuario u ON c.id_persona = u.id_usuario
                                    WHERE c.id_curso = ?"); // Consulta SQL para obtener detalles del curso y el docente
        $stmt->bind_param('i', $id_curso); // Vincula el parámetro id_curso
        $stmt->execute();
        $result = $stmt->get_result();
        $course = $result->fetch_assoc(); // Almacena los resultados del curso

        // Si no se encuentran detalles del curso, lanza una excepción
        if (!$course) {
            throw new Exception('No se encontraron datos del curso seleccionado.');
        }

        // Obtener todos los estudiantes inscritos en el curso
        $stmt = $conexion->prepare("SELECT u.nombre, u.apellido, u.ci FROM inscripcion i
                                    JOIN usuario u ON i.id_persona = u.id_usuario
                                    WHERE i.id_curso = ?"); // Consulta para obtener los estudiantes inscritos
        $stmt->bind_param('i', $id_curso); // Vincula el id_curso
        $stmt->execute();
        $result = $stmt->get_result(); // Almacena los resultados

        // Si no se encuentran estudiantes inscritos, lanza una excepción
        if ($result->num_rows == 0) {
            throw new Exception('No se encontraron estudiantes inscritos en el curso.');
        }

        // Crear un PDF y agregar una nueva página para cada estudiante inscrito
        // Crea un nuevo PDF en orientación horizontal
        $pdf = new PDF('L', 'mm', 'A4', $course['nombre_docente'], $course['apellido_docente']);
        $pdf->AliasNbPages(); // Activa la numeración de páginas

        // Bucle para generar certificados para cada estudiante
        while ($student = $result->fetch_assoc()) {

            // Añade una nueva página al PDF para cada estudiante
            $pdf->AddPage(); 

            // Certificado de aprobación
            $pdf->SetFont('Arial', 'B', 18);
            $pdf->Cell(0, 30, utf8_decode("El Instituto Tecnológico Bolivia Mar"), 0, 1, 'C'); // Título del certificado
            $pdf->SetFont('Arial', 'B', 18);
            $pdf->Cell(0, 10, utf8_decode("Otorga el presente certificado a:"), 0, 1, 'C'); // Texto de introducción
            $pdf->SetFont('Arial', 'B', 24);
            $pdf->Cell(0, 10, utf8_decode($student['nombre'] . ' ' . $student['apellido']), 0, 1, 'C'); // Nombre del estudiante en grande
            $pdf->SetFont('Arial', 'I', 16);
            $pdf->Cell(0, 10, utf8_decode("Por haber completado satisfactoriamente el curso de"), 0, 1, 'C'); // Texto de motivación
            $pdf->SetFont('Arial', 'B', 20);
            $pdf->Cell(0, 10, utf8_decode($course['nombre_curso']), 0, 1, 'C'); // Nombre del curso


            // Un poco de contexto o propósito del curso

            $pdf->SetFont('Arial', '', 12);
            $pdf->MultiCell(0, 10, utf8_decode("El curso completado por el alumno/a tiene como objetivo principal fortalecer "
                . "sus conocimientos y habilidades en el área correspondiente, facilitando su aplicación en el "
                . "ámbito profesional y académico con una Carga Horaria de : " . $course['cargaHoraria'] . " horas"), 0, 'C');

            // Espacio adicional antes de la firma
            $pdf->Ln(20); 
        }

        // Descargar el PDF con todos los certificados
         // Enviar el PDF al navegador sin guardarlo en el servidor
        $pdf->Output('I', 'certificados_curso_' . $course['nombre_curso'] . '.pdf');
    } else {
        // Si no se proporciona el ID del curso en la URL, lanza una excepción
        throw new Exception('No se proporcionó el ID del curso.');
    }
} catch (Exception $e) {
    // Si ocurre alguna excepción, muestra un mensaje de error
    echo 'Error: ' . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$conexion->close();
