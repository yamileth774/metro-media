<?php
require("cnx.php");
$txtusuario = $_POST["txtusuario"];
$txtcontraseña = $_POST["txtcontraseña"];

try {
    $consulta = "INSERT INTO empledos (Usuario,Contraseña) VALUES('$txtusuario','$txtcontraseña')";
$ejecutar = mysqli_query($camino, $consulta);
echo "Datos almacenados correctamente";
} catch (Exception $ex) {
    echo "Error no se puede almacenar: " . $ex->getMessage();
}


?>