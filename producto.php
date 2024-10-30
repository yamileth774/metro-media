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

// Paso 2: Consulta SQL para obtener los libros, autores y géneros
$sql = "SELECT libros.id_libro, libros.titulo, CONCAT(autores.Nombre, ' ', autores.Apellido) AS autor, generos.nombre_genero AS genero, libros.precio 
        FROM libros
        JOIN autores ON libros.id_autor = autores.id_autor 
        JOIN generos ON libros.id_genero = generos.id_genero";

$result = $conn->query($sql);
// JOIN: Es unir campos de tablas
// Paso 3: Mostrar los libros en la página
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <div class="contenedor-titulo">
    <h1 class="titulo-libros">Libros Disponibles</h1>
    <a href="inicio.php">
        <button class="btn-retroceder">Regresar al Menú</button>
    </a>
</div>

    <style>
        .card {
            margin-bottom: 20px;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }
        .card-text {
            font-size: 1rem;
        }
        body {
            background-color: #f0f2f5; /* Color de fondo suave */
        }

        h1 {
            color: #343a40; /* Color de encabezado */
        }

        .card {
            margin-bottom: 20px;
            border: none; /* Eliminar borde predeterminado */
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1); /* Sombra ligera */
            transition: transform 0.2s ease; /* Efecto de zoom */
        }

        .card:hover {
            transform: scale(1.05); /* Zoom al pasar el mouse */
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #007bff; /* Color primario de Bootstrap */
        }

        .card-text {
            font-size: 1rem;
            color: #6c757d; /* Color de texto secundario */
        }

        #carrito {
            position: fixed;
            top: 50px;
            right: 20px;
            width: 300px;
            background-color: #ffffff; /* Fondo blanco para el carrito */
            border: 1px solid #ddd; /* Borde gris claro */
            padding: 20px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.05); /* Sombra ligera */
            border-radius: 10px; /* Borde redondeado suave */
            transition: box-shadow 0.3s ease, transform 0.3s ease; /* Efecto de transformación */
        }

        #carrito:hover {
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.1); /* Sombra más pronunciada al pasar el mouse */
            transform: translateY(-5px); /* Efecto de flotación */
        }

        #carrito h3 {
            margin-top: 0;
            font-size: 1.5rem;
            font-weight: bold;
            color: #333; /* Color más oscuro para el título */
        }

        #contenido_carrito {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 15px;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }

        #contenido_carrito p {
            color: #555; /* Texto en gris medio */
            font-size: 1rem;
        }

        .btn-checkout {
            background-color: #ffc107; /* Color amarillo para resaltar */
            color: white;
            border: none;
            padding: 10px 15px;
            width: 100%;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-checkout:hover {
            background-color: #e0a800; /* Color más oscuro al hacer hover */
        }

        .btn-vaciar {
            background-color: #dc3545; /* Botón de vaciar con color rojo */
            color: white;
            border: none;
            padding: 10px 15px;
            width: 100%;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .btn-vaciar:hover {
            background-color: #c82333; /* Color más oscuro al hacer hover */
        }

        a.btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            transition: background-color 0.3s ease;
            width: 100%;
            text-align: center;
        }

        a.btn-primary:hover {
            background-color: #0056b3; /* Color más oscuro en hover */
        }

        /* Actualización del estilo de los botones en el carrito */
        #carrito button {
            background-color: #dc3545; /* Color rojo para el botón de eliminar */
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 0.875rem;
            border-radius: 5px; /* Borde redondeado */
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #carrito button:hover {
            background-color: #c82333; /* Color más oscuro en hover */
        }

        /* Estilo para el botón de Mostrar Factura */
        .btn-checkout {
            background-color: #ffc107; /* Color amarillo para resaltar */
            color: white;
            border: none;
            padding: 10px 15px;
            width: 100%;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-checkout:hover {
            background-color: #e0a800; /* Color más oscuro al hacer hover */
        }
        /* Estilo para el título "Libros Disponibles" */
            .titulo-libros {
                font-size: 2rem; /* Tamaño de fuente más grande */
                color: #343a40; /* Color gris oscuro */
                text-align: center;
                margin-bottom: 20px;
                font-weight: bold;
                text-transform: uppercase; /* Convertir a mayúsculas */
                letter-spacing: 2px; /* Espaciado entre letras */
                border-bottom: 2px solid #ffc107; /* Línea decorativa debajo del título */
                padding-bottom: 10px;
            }

            /* Estilo del botón para regresar */
            .btn-retroceder {
                background-color: #007bff; /* Color azul */
                color: white;
                border: none;
                padding: 10px 15px;
                font-size: 1rem;
                border-radius: 5px; /* Bordes redondeados */
                cursor: pointer;
                transition: background-color 0.3s ease;
                position: fixed; /* Fijar el botón en la pantalla */
                top: 20px; /* Distancia desde la parte superior */
                left: 20px; /* Distancia desde la parte derecha */
                z-index: 1000; /* Asegura que esté por encima de otros elementos */
            }

            .btn-retroceder:hover {
                background-color: #0056b3; /* Color más oscuro al hacer hover */
            }


    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">

            <?php
            // Paso 4: Revisar si hay resultados y mostrarlos
            if ($result->num_rows > 0) {
                // Recorrer cada fila de los resultados
                while($row = $result->fetch_assoc()) {
                    echo '
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">' . $row["titulo"] . '</h5>
                                <p class="card-text"><strong>Autor:</strong> ' . $row["autor"] . '</p>
                                <p class="card-text"><strong>Género:</strong> ' . $row["genero"] . '</p>
                                <p class="card-text"><strong>Precio:</strong> L.' . $row["precio"] . '</p>
                                <a href="#" class="btn btn-primary" onclick="agregarAlCarrito(' . $row['id_libro'] . ', \'' . addslashes($row['titulo']) . '\', ' . $row['precio'] . ')">Comprar</a>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<p>No se encontraron libros disponibles.</p>';
            }

            // Cerrar la conexión
            $conn->close();
            ?>

        </div>
    </div>

    <!-- Div que contiene el carrito de compras -->
    <div id="carrito">
        <h3>Carrito de Compras</h3>
        <div id="contenido_carrito">
            <p>El carrito está vacío.</p>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>

    <script>
        function agregarAlCarrito(id_libro, titulo, precio) {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "agregar_carrito.php?id_libro=" + id_libro + "&titulo=" + encodeURIComponent(titulo) + "&precio=" + precio, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('contenido_carrito').innerHTML = this.responseText;
                }
            };
            xhr.send();
        }

        function eliminarDelCarrito(index) {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "eliminar_carrito.php?index=" + index, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('contenido_carrito').innerHTML = this.responseText;
                }
            };
            xhr.send();
        }

        function reporte1() {
            window.location.href = 'reporte1.php'; // Redirigir a la página de la factura
        }
    </script>

</body>
</html>






   
    

