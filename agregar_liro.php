<?php
require('fpdf186/fpdf.php'); // Asegúrate de incluir la ruta correcta
session_start(); // Iniciar sesión para acceder a la información

// Verificar si el nombre del empleado está en la sesión (opcional)
if (isset($_SESSION['empleados'])) {
    $empleados = $_SESSION['empleados'];
} else {
    $empleados = "Nombre del Empleado"; // Nombre por defecto si no se encuentra
}

// Paso 1: Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "libreria"; // Nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Paso 2: Obtener datos del formulario
$titulo = $_POST['titulo'];
$nombre_autor = $_POST['nombre_autor'];
$apellido_autor = $_POST['apellido_autor'];
$nombre_genero = $_POST['nombre_genero'];
$precio = $_POST['precio'];

// Paso 3: Insertar nuevo autor y género si no existen
// Insertar nuevo autor
$sql_autor = "INSERT INTO autores (nombre, apellido) VALUES (?, ?)";
$stmt_autor = $conn->prepare($sql_autor);
$stmt_autor->bind_param("ss", $nombre_autor, $apellido_autor);
$stmt_autor->execute();
$id_autor = $conn->insert_id; // Obtener el ID del autor recién agregado

// Insertar nuevo género
$sql_genero = "INSERT INTO generos (nombre_genero) VALUES (?)";
$stmt_genero = $conn->prepare($sql_genero);
$stmt_genero->bind_param("s", $nombre_genero);
$stmt_genero->execute();
$id_genero = $conn->insert_id; // Obtener el ID del género recién agregado

// Insertar el nuevo libro en la base de datos
$sql_libro = "INSERT INTO libros (titulo, id_autor, id_genero, precio) VALUES (?, ?, ?, ?)";
$stmt_libro = $conn->prepare($sql_libro);
$stmt_libro->bind_param("siid", $titulo, $id_autor, $id_genero, $precio);
$stmt_libro->execute();

// Paso 4: Generar el PDF
class PDF extends FPDF {
    function Header() {
        $this->Image('IMG/metromedia.jpeg', 10, 8, 33);
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(80);
        $this->Cell(30, 10, 'Reporte de Libro', 0, 0, 'C');
        $this->Ln(20);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function ImprovedTable($header, $data) {
        // Ancho de las columnas
        $w = array(80, 40, 40, 30);
        
        // Cabecera
        $this->SetFont('Arial', 'B', 12);
        for($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 10, $header[$i], 1, 0, 'C');
        }
        $this->Ln();

        // Datos
        $this->SetFont('Arial', '', 12);
        foreach ($data as $row) {
            foreach ($row as $col) {
                $this->Cell($w[0], 10, $col[0], 1);
                $this->Cell($w[1], 10, $col[1], 1);
                $this->Cell($w[2], 10, $col[2], 1);
                $this->Cell($w[3], 10, 'L.' . number_format($col[3], 2), 1);
                $this->Ln();
            }
        }
    }
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 12);

// Mensaje de libro agregado exitosamente
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Libro agregado exitosamente!', 0, 1, 'C');
$pdf->Ln(10);

// Mostrar detalles del libro recién agregado
$pdf->SetFont('Arial', 'I', 12);
$pdf->Cell(40, 10, 'Titulo: ', 0, 0);
$pdf->Cell(0, 10, $titulo, 0, 1);
$pdf->Cell(40, 10, 'Autor: ', 0, 0);
$pdf->Cell(0, 10, $nombre_autor . ' ' . $apellido_autor, 0, 1);
$pdf->Cell(40, 10, 'Genero: ', 0, 0);
$pdf->Cell(0, 10, $nombre_genero, 0, 1);
$pdf->Cell(40, 10, 'Precio: ', 0, 0);
$pdf->Cell(0, 10, 'L.' . number_format($precio, 2), 0, 1);
$pdf->Ln(10);

// Encabezados de la tabla de todos los libros
$pdf->SetFont('Arial', 'B', 12);
$header = ['Titulo', 'Autor', 'Genero', 'Precio'];

// Obtener todos los libros para la tabla
$sql_todos_libros = "SELECT l.titulo, a.nombre AS autor_nombre, a.apellido AS autor_apellido, g.nombre_genero, l.precio 
                     FROM libros l 
                     JOIN autores a ON l.id_autor = a.id_autor 
                     JOIN generos g ON l.id_genero = g.id_genero";
$result_todos_libros = $conn->query($sql_todos_libros);
$data = [];

// Almacenar todos los libros en el array
while ($row = $result_todos_libros->fetch_assoc()) {
    $data[] = [
        [$row['titulo'], $row['autor_nombre'] . ' ' . $row['autor_apellido'], $row['nombre_genero'], $row['precio']]
    ];
}

// Mostrar la tabla de todos los libros
$pdf->ImprovedTable($header, $data);

// Mostrar el nombre del empleado
$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 12);
$pdf->Cell(0, 10, 'Empleado: ' . $empleados, 0, 1);

// Generar el PDF
$pdf->Output();

// Cerrar conexiones
$stmt_autor->close();
$stmt_genero->close();
$stmt_libro->close();
$conn->close();
?>



