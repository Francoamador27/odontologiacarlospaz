<?php
session_start();
require '../../backend/fpdf/fpdf.php';
require '../../backend/bd/Conexion.php'; // Asegúrate de que este archivo existe

// Configuración de zona horaria
date_default_timezone_set('America/Lima');

// Validación de sesión
$doctorName = isset($_SESSION['name']) ? $_SESSION['name'] : 'No definido';

// Validación de ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id === 0) {
    die('ID inválido.');
}

class PDF extends FPDF
{
    function Header()
    {
        // Cabecera
        $this->SetFont('times', 'B', 13);
        $this->Text(25, 15, utf8_decode('Odontologia integral carlos paz'));
        $this->Text(25, 20, utf8_decode('Dr(a): ' . $_SESSION['name']));
        $this->Text(25, 25, utf8_decode('Tel: 3518078727'));
        $this->Text(25, 30, utf8_decode('odcapellan@gmail.com'));
        $this->Image('../../backend/img/logo-letras-negras.png', 160, 5, 33);

        // Datos adicionales
        $this->SetFont('Arial', 'B', 10);
        $this->Text(10, 48, utf8_decode('DATOS DEL PACIENTE'));
        $this->Ln(50);
    }

    function Footer()
    {
        $this->SetFont('helvetica', 'B', 8);
        $this->SetY(-15);
        $this->Cell(95, 5, utf8_decode('Página ') . $this->PageNo() . ' / {nb}', 0, 0, 'L');
        $this->Cell(95, 5, date('d/m/Y | g:i:a'), 0, 1, 'R');
        $this->Line(10, 287, 200, 287);
        $this->Cell(0, 5, utf8_decode("clinicasalud © Todos los derechos reservados."), 0, 0, "C");
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Conexión a la base de datos y consulta
try {
    $stmt = $connect->prepare("SELECT * FROM patients WHERE idpa = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 7, utf8_decode($row['numhs']), 1, 0, 'L', 0);
        $pdf->Cell(40, 7, utf8_decode($row['nompa']), 1, 0, 'L', 0);
        $pdf->Cell(40, 7, utf8_decode($row['apepa']), 1, 0, 'L', 0);
        $pdf->Cell(60, 7, utf8_decode($row['email_p']), 1, 0, 'L', 0);
        $pdf->Cell(30, 7, utf8_decode($row['phon']), 1, 1, 'R', 0);
    } else {
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 7, 'No se encontraron datos para el paciente.', 1, 1, 'C');
    }
} catch (PDOException $e) {
    die('Error en la consulta: ' . $e->getMessage());
}

$pdf->Output('historia_clinica.pdf', 'D');