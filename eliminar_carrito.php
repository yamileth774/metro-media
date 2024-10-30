<?php
session_start(); 


if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = []; 
}

// Obtener el índice del libro a eliminar
$index = $_GET['index'];

// Eliminar el libro del carrito
if (isset($_SESSION['carrito'][$index])) {
    unset($_SESSION['carrito'][$index]); 
    $_SESSION['carrito'] = array_values($_SESSION['carrito']); 
}


$contenido = '<ul>';
$total = 0; 

foreach ($_SESSION['carrito'] as $index => $item) {
    $subtotal = $item['precio'] * $item['cantidad'];
    $total += $subtotal; 
    $contenido .= '<li>' . htmlspecialchars($item['titulo']) . ' - Precio: $' . htmlspecialchars($item['precio']) . ' - Cantidad: ' . htmlspecialchars($item['cantidad']) . ' <button onclick="eliminarDelCarrito(' . $index . ')">Eliminar</button></li>';
}
$contenido .= '</ul>';
$contenido .= '<strong>Total: $' . $total . '</strong>';
$contenido .= '<button onclick="reporte1()">Mostrar Factura</button'; 

echo $contenido; 
?>

