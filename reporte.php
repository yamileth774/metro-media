<?php
require('fpdf186/fpdf.php');
require('cnx.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo

     $this->Image('IMG/logo.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',18);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'Productos',0,0,'C');
    // Salto de línea
    $this->Ln(20);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$consulta="SELECT * FROM productos";
$ejecutar=mysqli_query($camino, $consulta);

while($fila=mysqli_fetch_array($ejecutar))
 $pdf->Cell(0,10,$fila['codPro']. " ". $fila['NomPro']. " ". $fila['Cantidad']. " ". $fila ['Precio'],0,1);
$pdf->Output();
?>