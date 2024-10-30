<?php
session_start(); // Iniciar la sesión para manejar el carrito

// Verificar si el carrito ya está creado
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = []; // Inicializar el carrito
}

// Obtener los parámetros de la URL
$id_libro = $_GET['id_libro'];
$titulo = $_GET['titulo'];
$precio = $_GET['precio'];

// Verificar si el libro ya está en el carrito
$existe = false;
foreach ($_SESSION['carrito'] as &$item) {
    if ($item['id_libro'] == $id_libro) {
        $item['cantidad']++; // Aumentar la cantidad
        $existe = true;
        break;
    }
}

// Si el libro no está en el carrito, agregarlo
if (!$existe) {
    $_SESSION['carrito'][] = [
        'id_libro' => $id_libro,
        'titulo' => $titulo,
        'precio' => $precio,
        'cantidad' => 1 // Inicializar la cantidad en 1
    ];
}

// Mostrar el contenido del carrito
$contenido = '<ul>';
$total = 0; // Variable para calcular el total

foreach ($_SESSION['carrito'] as $index => $item) {
    $subtotal = $item['precio'] * $item['cantidad'];
    $total += $subtotal; // Sumar al total
    $contenido .= '<li>' . htmlspecialchars($item['titulo']) . ' - Precio: $' . htmlspecialchars($item['precio']) . ' - Cantidad: ' . htmlspecialchars($item['cantidad']) . ' <button onclick="eliminarDelCarrito(' . $index . ')">Eliminar</button></li>';
}
$contenido .= '</ul>';
$contenido .= '<strong>Total: $' . $total . '</strong>';
$contenido .= '<button onclick="reporte1()">Mostrar Factura</button'; 

echo $contenido; // Enviar el contenido del carrito como respuesta
?>




