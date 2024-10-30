<?php
session_start();
if (!$_SESSION['usuarios']) {
   header("location: index.php");
}
else {
    print_r($_SESSION['usuarios']);
    echo "usuario correcto";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   
    <meta name="viewport" content="width=device-width, initial-scale=1.0 ">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Bienvenidos</title>
</head>
<body>
    <body>
    
           
            <ul  class="nav justify-content-center bg-black mt-5 ">
            
            
            <li class="nav-item">
                <a class="nav-link text-white" href="inicio.php">Inicio</a>
            </li>
           
            <li class="nav-item">
                <a class="nav-link  text-white" href="producto.php">Producto</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link  text-white" href="#">Acerca de</a>
            </li>
            <li class="nav-item">
                <a class="nav-link  text-white" href="Factura.php">Factura</a>
            </li>

            <li class="nav-item">
                <a class="nav-link  text-white" href="cerrar.php">Salir</a>
            </li>
        </ul>
        
       