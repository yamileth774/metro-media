<?php
// Inicia sesión
session_start();

// Configuración de la base de datos
$host = 'localhost'; // Cambia según tu servidor
$dbname = 'libreria'; // Nombre de la base de datos
$user = 'root'; // Cambia según tu configuración
$password = ''; // Cambia según tu configuración

// Conexión a la base de datos
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

// Verifica si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta para verificar usuario y contraseña
    $stmt = $conn->prepare("SELECT * FROM empleados WHERE Usuario = :usuario AND Contraseña = :contrasena");
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':contrasena', $contrasena);
    $stmt->execute();

    $empleado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($empleado) {
        // Si el usuario es válido, iniciar sesión
        $_SESSION['usuario'] = $empleado['Usuario'];
        header('Location: inicio.php'); // Redirige a una página llamada inicio.php
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Metromedia</title>
    <style>
        body {
            background-color: rgba(255, 255, 255, 0.8); /* Color blanco con opacidad */
            background-image: url('IMG/fondo1.jpg'); /* Si deseas usar una imagen */
            background-size: cover; /* Cubrir toda la pantalla */
            backdrop-filter: blur(2px); /* Aplicar desenfoque */
            height: 100vh; /* Altura completa de la ventana */
            display: flex; /* Para centrar el contenido */
            align-items: center; /* Centrando verticalmente */
            justify-content: center; /* Centrando horizontalmente */
            
        }
        .login-container {
            width: 300px;
            margin: 100px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
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

<div class="login-container">
        <div class="logo text-center">
            <img src="IMG/metromedia.jpeg" alt="Descripción de la imagen" class="img-fluid rounded mb-4">
        </div>

    <h2>Formulario de Ingreso</h2>
    <!-- Elimina el action para enviar los datos al mismo archivo -->
    <form method="POST" action="">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <input type="submit" value="Ingresar">
    </form>
    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
</div>

</body>
</html>

