<?php
require('cnx.php'); // Archivo que contiene la conexión a la base de datos

// Obtener los datos del formulario
$U = $_POST["txtU"];
$C = $_POST["txtC"];

try {
    // Preparar la consulta SQL usando prepared statements para evitar inyecciones SQL
    $stmt = $camino->prepare("SELECT * FROM empleados WHERE Usuario = ? AND Contraseña = ?");
    $stmt->bind_param("ss", $U, $C); // Enlazar los parámetros (dos cadenas de texto)

    // Ejecutar la consulta
    $stmt->execute();
    $resultado = $stmt->get_result(); // Obtener el resultado de la consulta

    // Verificar si se encontró un empleado con esas credenciales
    if ($resultado->num_rows > 0) {
        session_start();
        $empleado = $resultado->fetch_assoc(); // Obtener los datos del empleado

        // Guardar el nombre de usuario o el ID del empleado en la sesión
        $_SESSION['empleados'] = $empleado['Usuario']; // O podrías guardar el ID: $empleado['ID']

        // Redirigir a la página de inicio
        header("location: menu.php");
        exit(); // Asegurarse de que el script se detenga después de la redirección
    } else {
        echo "Usuario y/o contraseña incorrecta";
    }

    // Cerrar la consulta y la conexión
    $stmt->close();
    mysqli_close($camino);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    mysqli_close($camino);
}
?>
