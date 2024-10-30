<?php

try {
    $camino = mysqli_connect("localhost", "root", "","libreria");
   
} catch (Exception $ex) {
    echo "error en la conexion " . $ex->getMessage();
}
?>