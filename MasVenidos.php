<?php
// Incluye la librería FPDF
require('fpdf186/fpdf.php');

// Conexión a la base de datos
$host = 'localhost'; // Cambia según tu servidor
$dbname = 'libreria'; // Nombre de la base de datos
$user = 'root'; // Cambia según tu configuración
$password = ''; // Cambia según tu configuración

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}

// Si se ha seleccionado un género
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['genero'])) {
    $genero = $_POST['genero'];

    // Consulta para obtener los libros disponibles según el género
    $sql = "
        SELECT libros.titulo, libros.precio
        FROM libros
        JOIN generos ON libros.id_genero = generos.id_genero
        WHERE generos.nombre_genero = :genero
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':genero', $genero);
    $stmt->execute();
    $libros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Crear el PDF estilizado
    $pdf = new FPDF();
    $pdf->AddPage();

    // Título del PDF
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->SetTextColor(50, 60, 100); // Color del texto del título
    $pdf->Cell(0, 10, utf8_decode('Reporte de Libros Disponibles en el Género: ') . $genero, 0, 1, 'C');
    $pdf->Ln(10);

    // Establecer encabezados de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(230, 230, 230); // Fondo gris claro
    $pdf->Cell(120, 10, 'Titulo del Libro', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Precio (L.)', 1, 1, 'C', true);

    // Agregar los datos de los libros
    $pdf->SetFont('Arial', '', 12);
    foreach ($libros as $libro) {
        $pdf->Cell(120, 10, utf8_decode($libro['titulo']), 1);
        $pdf->Cell(40, 10, number_format($libro['precio'], 2), 1, 1, 'R');
    }

    // Si no se encontraron libros
    if (count($libros) == 0) {
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'I', 12);
        $pdf->SetTextColor(255, 0, 0); // Color rojo
        $pdf->Cell(0, 10, 'No se encontraron libros en este género.', 0, 1, 'C');
    }

    // Mostrar PDF
    $pdf->Output();
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros Disponibles por Género</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }
        select, input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: #fff;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .fondo-borroso {
            background-color: rgba(255, 255, 255, 0.9); /* Fondo semitransparente */
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            color: #343a40;
        }
        body {
                background-color: #f8f9fa;
            }
            h1 {
                color: #343a40;
                margin-bottom: 20px;
            }
            form {
                margin-bottom: 20px;
            }
            .btn-custom {
                background-color: #007bff;
                color: white;
            }
            .btn-custom:hover {
                background-color: #0056b3;
                color: white;
            }
            
        .nav {
            background-color: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center; /* Centra las opciones */
            padding: 15px;
            list-style: none;
        }

        .nav-item {
            margin: 0 20px; /* Espaciado entre los elementos */
        }

        .nav a {
            color: #ffffff;
            text-decoration: none;
            padding: 8px 16px;
            display: block;
        }

        .nav a:hover {
            background-color: #ffc107;
            border-radius: 5px;
        }

        h1, h2 {
            color: #343a40;
        }

        .nav-link {
            font-size: 1.2rem;
        }
        .logo {
            display: flex;
            justify-content: center; /* Centra horizontalmente */
            align-items: center; /* Centra verticalmente si el contenedor tiene altura definida */
            margin: 20px 0; /* Espaciado opcional alrededor de la imagen */
        }

        .logo img {
            max-width: 100%; /* Ajusta el tamaño de la imagen si es necesario */
            height: auto;
        }
        body {
            background-size: cover;
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7;
        }

        .fondo-borroso {
            background-color: rgba(255, 255, 255, 0.9); /* Fondo semitransparente */
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            color: #343a40;
        }
        .container {
            margin-top: 50px;
        }

        h1, h2 {
            color: #343a40;
        }

        .categoria {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Fondo más visible */
            text-align: center;
            color: #000;
        }

        .categoria h4 {
            font-size: 1.5rem;
            color: #007bff;
        }

        .categoria p {
            font-size: 1rem;
            color: #000;
        }

        .formulario-cuadro {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9); /* Fondo más visible */
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.7);
            border: 1px solid #ccc;
        }

        .form-label {
            font-weight: bold;
            color: #343a40; /* Texto oscuro para el formulario */
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
        .nav {
            background-color: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center; /* Centra las opciones */
            padding: 15px;
            list-style: none;
        }

        .nav-item {
            margin: 0 20px; /* Espaciado entre los elementos */
        }

        .nav a {
            color: #ffffff;
            text-decoration: none;
            padding: 8px 16px;
            display: block;
        }

        .nav a:hover {
            background-color: #ffc107;
            border-radius: 5px;
        }

        h1, h2 {
            color: #343a40;
        }

        .nav-link {
            font-size: 1.2rem;
        }
        .logo {
            display: flex;
            justify-content: center; /* Centra horizontalmente */
            align-items: center; /* Centra verticalmente si el contenedor tiene altura definida */
            margin: 20px 0; /* Espaciado opcional alrededor de la imagen */
        }

        .logo img {
            max-width: 100%; /* Ajusta el tamaño de la imagen si es necesario */
            height: auto;
        }
    </style>
</head>
<body>
    <div class="logo text-center">
        <img src="IMG/metromedia.jpeg" alt="Descripción de la imagen" class="img-fluid rounded mb-4">
    </div>

    <!-- Menú de navegación -->
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link text-white" href="inicio.php">Inicio</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="producto.php">Producto</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="VendidosEmpleado.php">Libros Vendidos Por Empleado</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="MasVenidos.php">Libros por genero</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="Cerrar.php">Salir</a>
        </li>
    </ul>

    <h2>Consulta los Libros Disponibles por Género</h2>
    <form method="POST" action="MasVenidos.php">
        <label for="genero">Selecciona un Género:</label>
        <select name="genero" id="genero" required>
            <option value="">-- Selecciona un Género --</option>
            <?php
            // Consulta para obtener los géneros disponibles en la base de datos
            $sql_generos = "SELECT nombre_genero FROM generos";
            $stmt_generos = $conn->prepare($sql_generos);
            $stmt_generos->execute();
            $generos = $stmt_generos->fetchAll(PDO::FETCH_ASSOC);

            // Crear opciones dinámicas para los géneros
            foreach ($generos as $genero) {
                echo '<option value="' . $genero['nombre_genero'] . '">' . $genero['nombre_genero'] . '</option>';
            }
            ?>
        </select>
        <input type="submit" value="Generar Reporte">
    </form>
</body>
</html>

