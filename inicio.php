<?php
// Iniciar sesión y verificar si el usuario ha iniciado sesión
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: FormularioIngreso.php"); // Si no está autenticado, redirige al formulario de inicio de sesión
    exit();
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

// Paso 2: Consulta SQL para obtener las categorías de libros
$sql = "SELECT * FROM generos"; // Suponiendo que tienes una tabla de géneros
$result_generos = $conn->query($sql);

// Paso 3: Consulta SQL para obtener los autores
$sql = "SELECT * FROM autores"; // Suponiendo que tienes una tabla de autores
$result_autores = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Página de Inicio</title>
    <style>
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
    <!-- Logo central -->
    <div class="logo text-center">
        <img src="IMG/metromedia.jpeg" alt="Descripción de la imagen" class="img-fluid rounded mb-4">
    </div>

    <!-- Menú de navegación -->
    <ul class="nav justify-content-center">
        <li class="nav-item">
            <a class="nav-link text-white" href="#">Inicio</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="producto.php">Producto</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="VendidosEmpleado.php">Libros Vendidos por Empleado</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="MasVenidos.php">Libros por genero</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="Cerrar.php">Salir</a>
        </li>
    </ul>

    <div class="container mt-5 fondo-borroso">
        <h1 class="text-center">Bienvenido a Nuestra Librería</h1>
        <p class="text-center">Explora un mundo de conocimiento y aventuras. Aquí encontrarás una amplia variedad de libros, desde clásicos atemporales hasta las últimas novedades en literatura. ¡Sumérgete en nuestras recomendaciones y descubre tu próxima lectura!</p>

        <h2 class="mt-5 text-center">Categorías de Libros</h2>
        <div class="row">
            <?php
            // Paso 3: Mostrar las categorías de libros
            if ($result_generos->num_rows > 0) {
                while($row = $result_generos->fetch_assoc()) {
                    echo '
                    <div class="col-md-3">
                        <div class="categoria">
                            <h4>' . htmlspecialchars($row['nombre_genero']) . '</h4>
                            <p>Descubre nuestros libros de ' . htmlspecialchars($row['nombre_genero']) . '.</p>
                        </div>
                    </div>';
                }
            } else {
                echo '<p>No se encontraron categorías disponibles.</p>';
            }
            ?>
        </div>

        <h2 class="mt-5 text-center">Agregar Nuevo Libro</h2>

        <!-- Formulario de agregar libro -->
        <div class="formulario-cuadro">
            <form action="agregar_liro.php" method="post">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>
                <div class="mb-3">
                    <label for="nombre_autor" class="form-label">Nombre del Autor</label>
                    <input type="text" class="form-control" id="nombre_autor" name="nombre_autor" required>
                </div>
                <div class="mb-3">
                    <label for="apellido_autor" class="form-label">Apellido del Autor</label>
                    <input type="text" class="form-control" id="apellido_autor" name="apellido_autor" required>
                </div>
                <div class="mb-3">
                    <label for="nombre_genero" class="form-label">Nombre del Género</label>
                    <input type="text" class="form-control" id="nombre_genero" name="nombre_genero" required>
                </div>
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="text" class="form-control" id="precio" name="precio" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Agregar Libro</button>
            </form>
        </div>

    </div>
</body>
</html>






