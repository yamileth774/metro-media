<?php
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
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title></title>
    <style>
        .categoria {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.1); /* Sombra más pronunciada al pasar el mouse */
            transform: translateY(-5px); /* Efecto de flotación */
        }
        body {
            background-color: #f8f9fa; /* Fondo claro */
            font-family: 'Poppins', sans-serif; /* Fuente moderna */
        }

        .navbar {
            background-color: #343a40; /* Fondo oscuro para la navbar */
        }

        .navbar a {
            color: #ffffff; /* Color de texto blanco */
        }

        .navbar a:hover {
            color: #ffc107; /* Color dorado al pasar el mouse */
        }

        .container {
            margin-top: 50px;
            text-align: center;
        }

        h1 {
            margin-bottom: 30px;
            font-size: 2.5rem; /* Tamaño del título */
            color: #343a40; /* Color del título */
        }

        .nav-link {
            font-size: 1.2rem; /* Tamaño del texto de los enlaces */
        }

        /* Estilos para el menú */
        ul.nav {
            background: linear-gradient(90deg, #007bff, #0056b3); /* Gradiente de azul claro a oscuro */
            padding: 10px 0;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Sombra suave */
            list-style: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        ul.nav li {
            display: inline-block;
            margin-right: 20px;
        }

        ul.nav li a {
            color: #fff; /* Texto blanco */
            text-decoration: none;
            font-size: 1.2rem;
            padding: 8px 16px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        ul.nav li a:hover {
            background-color: #ffc107; /* Cambia el fondo a dorado */
            color: #fff;
            border-radius: 4px;
        }

        /* Estilos para el logo */
        .logo {
            text-align: center;
            margin: 20px 0;
        }

        .logo img {
            max-width: 400px; /* Ajusta el tamaño del logo */
            transition: transform 0.3s ease;
        }

        .logo img:hover {
            transform: scale(1.1); /* Efecto al pasar el ratón por encima */
        }

        /* Estilo para el botón fijo */
        .boton-fijo {
            position: fixed;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .boton-fijo:hover {
            background-color: #0056b3; /* Cambia el color al pasar el mouse */
        }
    </style>
</head>
<body>
     <!-- Logo central -->
     <div class="logo">
        <img src="IMG/metromedia.jpeg" alt="Descripción de la imagen" class="img-fluid rounded mb-4">
    </div>

    <!-- Menú de navegación -->
    <ul class="nav justify-content-center">
        <li class="nav-item">
            <a class="nav-link text-white" href="inicio.php">Inicio</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="producto.php">Producto</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="#">Acerca de</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="Factura.php">Factura</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="cerrar.php">Salir</a>
        </li>
    </ul>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Bienvenido a Nuestra Librería</h1>
        <p class="text-center">Explora un mundo de conocimiento y aventuras. Aquí encontrarás una amplia variedad de libros, desde clásicos atemporales hasta las últimas novedades en literatura. ¡Sumérgete en nuestras recomendaciones y descubre tu próxima lectura!</p>

        <h2 class="mt-5">Categorías de Libros</h2>
        <div class="row">
            <?php
            // Paso 3: Mostrar las categorías de libros
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
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

        <h2 class="mt-5">Agregar Nuevo Libro</h2>
        <form action="agregar_libro.php" method="post">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="mb-3">
                <label for="id_autor" class="form-label">ID Autor</label>
                <input type="number" class="form-control" id="id_autor" name="id_autor" required>
            </div>
            <div class="mb-3">
                <label for="id_genero" class="form-label">ID Género</label>
                <input type="number" class="form-control" id="id_genero" name="id_genero" required>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="text" class="form-control" id="precio" name="precio" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Libro</button>
        </form>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
