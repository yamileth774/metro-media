<?php
require('fpdf186/fpdf.php');
session_start(); // Iniciar sesión para acceder al carrito

if (isset($_SESSION ['empleados'])){
    $empleados=$_SESSION['empleados'];
}else{
    $empleados = "Desconocido"; //valor por defecto
}


class PDF extends FPDF {
    function Header() {
        $this->Image('IMG/metromedia.jpeg',10,8,33);
        $this->SetFont('Arial','B',18);
        $this->Cell(80);
        $this->Cell(30,10,'Factura',0,0,'C');
        $this->Ln(20);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
    }

    function ImprovedTable($header, $data) {
        // Ancho de las columnas
        $w = array(100, 30, 30, 30);
        
        // Cabecera
        for($i = 0; $i < count($header); $i++) {
            $this->SetFont('Arial','B',12);
            $this->Cell($w[$i],10,$header[$i],1,0,'C');
        }
        $this->Ln();

        // Datos
        $this->SetFont('Arial','',12);
        foreach ($data as $row) {
            $this->Cell($w[0],10,$row[0],1);
            $this->Cell($w[1],10,$row[1],1);
            $this->Cell($w[2],10,$row[2],1);
            $this->Cell($w[3],10,$row[3],1);
            $this->Ln();
        }
    }
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

// Comprobar si hay libros en el carrito
if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
    $data = [];
    $total = 0;
    
    // Encabezados de la tabla
    $header = ['Titulo', 'Precio', 'Cantidad', 'Subtotal'];

    foreach ($_SESSION['carrito'] as $item) {
        $subtotal = $item['precio'] * $item['cantidad'];
        $total += $subtotal;

        // Agregar fila de datos
        $data[] = [
            $item['titulo'],
            'L.' . number_format($item['precio'], 2),
            $item['cantidad'],
            'L.' . number_format($subtotal, 2)
        ];
    }

    // Mostrar la tabla
    $pdf->ImprovedTable($header, $data);

    // Mostrar total
    $pdf->Ln(10);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(160, 10, 'Total:', 1, 0, 'C');
    $pdf->Cell(30, 10, 'L.' . number_format($total, 2), 1, 1, 'C');

    // Mostrar el nombre del empleado
    $pdf->Ln(10);
    $pdf->SetFont('Arial','I',12);
    $pdf->Cell(0,10,'Empleado: ' . $empleados,0,1);
} else {
    $pdf->Cell(0,10,'No hay libros en el carrito.',0,1);
}

// Generar el PDF
$pdf->Output();
?>



