<?php
session_start();

if (isset($_SESSION['carrito'])) {
    echo "<h1>Carrito de Compras</h1>";
    echo "<table>";
    echo "<tr><th>Título</th><th>Precio Unitario</th><th>Cantidad</th><th>Total</th></tr>";

    $total = 0;

    foreach ($_SESSION['carrito'] as $item) {
        $subtotal = $item['precio'] * $item['cantidad'];
        echo "<tr>";
        echo "<td>" . $item['titulo'] . "</td>";
        echo "<td>$" . $item['precio'] . "</td>";
        echo "<td>" . $item['cantidad'] . "</td>";
        echo "<td>$" . $subtotal . "</td>";
        echo "</tr>";
        $total += $subtotal;
    }

    echo "<tr><td colspan='3'>Total:</td><td>$" . $total . "</td></tr>";
    echo "</table>";
} else {
    echo "<p>No hay productos en el carrito.</p>";
}
?>
