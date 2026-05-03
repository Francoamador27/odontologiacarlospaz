<?php
require('../../fpdf/fpdf.php');
require_once('../../../backend/bd/Conexion.php');
$input = json_decode(file_get_contents('php://input'), true);



// Clase extendida de FPDF para personalizar el PDF
class PDFTemplate extends FPDF
{
    private $title;
    private $logo;

    public function __construct($title, $logo = null)
    {
        parent::__construct();
        $this->title = $title;
        $this->logo = $logo;
    }

    function Header()
    {
        // Ancho total de la página
        $pageWidth = $this->GetPageWidth();
        $columnWidth = $pageWidth / 3;  // Dividir en tres columnas

        // Fondo blanco en el header
        $this->SetFillColor(255, 255, 255);  // Fondo blanco
        $this->Rect(0, 0, $pageWidth, 40, 'F');  // Ajusté la altura para mayor margen

        // Texto en color negro
        $this->SetTextColor(0, 0, 0);  // Color negro para el texto

        // Primera columna: Logo (más grande)
        $this->SetY(5);
        $imagePath = '../../img/logo-letras-negras.png';  // Ajusta la ruta según corresponda

        if (file_exists($imagePath)) {
            // Si la imagen existe, la incluye en el header
            $this->Image($imagePath, 10, 5, 50, 30);  // Ajusta el tamaño del logo
        }

        // Segunda columna: Vacía, pero puedes agregar contenido aquí si lo necesitas
        // Se ha eliminado la columna del nombre del proyecto

        // Tercera columna: Datos de contacto divididos en dos columnas
        $this->SetY(5);
        $this->SetX($columnWidth);  // Posición en la tercera columna
        $this->SetFont('Arial', '', 10);
        $this->MultiCell($columnWidth, 5, utf8_decode(  // Ajuste aquí el valor de 10 a 5
            "Med Tech Solutions\n" .
            "Ondiep 21\n" .
            "3552EA Utrecht\n" .
            "Info@medtechsolutions.nl\n" .
            "www.medtechsolutions.nl\n"
        ), 0, 'C');

        // Segunda parte de los datos (en la tercera columna, pero debajo de los datos anteriores)
        $this->SetY(5 + 5);  // Ajusta la posición para que no se solape
        $this->SetX($columnWidth * 2);  // Posición en la tercera columna
        $this->SetFont('Arial', '', 8);
        $this->MultiCell($columnWidth, 5, utf8_decode(
            "KVK: 914118291\n" .
            "BTW: NL004889478B82\n" .
            "NL14INGB0103090010"
        ), 0, 'L');
    }



    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'C');
    }

    function AddSection($title, $data, $columns)
    {
        // Si no hay datos, no crear la sección
        if (empty($data) && $title != 'Imágenes') {
            return;
        }

        // Título de la sección
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(49, 176, 213);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(180, 10, utf8_decode($title), 0, 1, 'C', true);
        $this->Ln(0);

        // Cabeceras de tabla - solo si hay datos o es sección de imágenes
        if (!empty($data) || $title == 'Imágenes') {
            $this->SetFont('Arial', 'B', 10);
            $this->SetFillColor(49, 176, 213);
            $this->SetTextColor(255, 255, 255);
            $this->SetDrawColor(169, 169, 169); // Gris para los bordes

            foreach ($columns as $col) {
                $this->Cell($col['width'], 7, utf8_decode($col['name']), 1, 0, 'C', true); // Agregar borde a las celdas de las cabeceras
            }
            $this->Ln();
        }

        // Filas de la tabla - solo si hay datos
        if (!empty($data)) {
            $this->SetFont('Arial', '', 10);
            $this->SetTextColor(0, 0, 0);
            $this->SetDrawColor(169, 169, 169); // Gris para los bordes de las filas

            $fill = false; // Alternar colores
            foreach ($data as $item) {
                $this->SetFillColor(240, 240, 240); // Gris claro para las filas alternas
                foreach ($columns as $col) {
                    $value = isset($item[$col['key']]) ? $item[$col['key']] : '';
                    $this->Cell($col['width'], 6, utf8_decode($value), 1, 0, 'L', $fill); // Agregar borde a las celdas de las filas
                }
                $fill = !$fill; // Alternar color
                $this->Ln();
            }
        }
        $this->Ln(10);
    }
}

// Procesar datos del frontend


if (!$input) {
    http_response_code(400);
    die(json_encode(['error' => 'Datos inválidos']));
}

// Configurar PDF
$pdf = new PDFTemplate(utf8_decode($input['proyectoName']));
$pdf->AddPage();

// 🔍 Agregar el nombre del proyecto después del header
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetY(40);  // Ajusta la posición vertical después del header
$pdf->Cell(180, 10, utf8_decode('Nombre del Proyecto: ' . $input['proyectoName']), 0, 1, 'C');

// 🔍 Bajar la sección de Acciones
$pdf->Ln(5); // Agregamos 20 unidades de espacio antes de Acciones

// Sección de Acciones
$pdf->AddSection('Acciones', $input['acciones'], [
    ['name' => 'Acción', 'key' => 'nombre', 'width' => 40],
    ['name' => 'Descripción', 'key' => 'descripcion', 'width' => 110],
    ['name' => 'Monto (S/)', 'key' => 'monto', 'width' => 30]
]);

// Sección de Materiales
$pdf->AddSection('Materiales', $input['materiales'], [
    ['name' => 'Material', 'key' => 'nombre', 'width' => 40],
    ['name' => 'Descripción', 'key' => 'descripcion', 'width' => 110],
    ['name' => 'Monto (S/)', 'key' => 'monto', 'width' => 30]
]);

// Monto Total
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(49, 176, 213);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(180, 10, utf8_decode('Monto Total del Proyecto: S/ ' . $input['montoTotal']), 0, 1, 'C', true);

// Procesar la firma primero
if (!empty($input['firma'])) {
    // Extraer la parte de datos del base64 para la firma
    if (preg_match('/^data:image\/(\w+);base64,/', $input['firma'], $matches)) {
        $firmaType = $matches[1];
        $base64Data = substr($input['firma'], strpos($input['firma'], ',') + 1);
        $decodedFirma = base64_decode($base64Data);

        // Crear archivo temporal para la firma
        $firmaFile = sys_get_temp_dir() . '/firma_' . uniqid() . '.' . $firmaType;
        file_put_contents($firmaFile, $decodedFirma);

        // Añadir la firma al costado derecho
        $pdf->SetY($pdf->GetY() + 10); // Ajustar posición vertical
        $pdf->SetX(150); // Posicionar la firma al lado derecho
        $pdf->Image($firmaFile, null, null, 50, 50); // Tamaño de 50x50

        // Añadir texto "Firma____________" debajo de la firma
        $pdf->SetY($pdf->GetY() + 55); // Ajustar posición vertical (después de la firma)
        $pdf->SetX(150); // Mantener el texto alineado con la firma
        $pdf->SetFont('Arial', '', 10); // Configurar la fuente y tamaño del texto
        $pdf->Cell(50, 10, 'Firma____________', 0, 0, 'C'); // Añadir texto centrado

        // Eliminar archivo temporal
        unlink($firmaFile);
    }
}


// Procesar imágenes después de la firma
if (!empty($input['imagenes'])) {
    // Título de la sección de imágenes (sin usar AddSection para evitar la celda vacía)
    $pdf->SetY($pdf->GetY() + 10); // Espacio después de la firma
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(49, 176, 213);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(180, 10, utf8_decode('Imágenes'), 0, 1, 'C', true);
    $pdf->Ln(5);

    $columnWidth = 30; // Ancho de cada columna
    $rowHeight = 30; // Alto de cada fila (aumentado para más espacio)
    $maxColumns = 4; // Máximo de 3 columnas
    $xStart = 10; // Posición X inicial
    $yStart = $pdf->GetY(); // Posición Y inicial

    $currentColumn = 0; // Contador de columnas
    $currentRow = 0; // Contador de filas
    $currentY = $yStart; // Posición actual en Y
    $maxY = $currentY; // Para seguir la posición Y máxima

    // Limitar a máximo 9 imágenes (3 filas de 3 columnas)
    $imagenes = array_slice($input['imagenes'], 0, 9);

    foreach ($imagenes as $base64Image) {
        // Extraer la parte de datos del base64
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $matches)) {
            $imageType = $matches[1];
            $base64Data = substr($base64Image, strpos($base64Image, ',') + 1);
            $decodedImage = base64_decode($base64Data);

            // Crear archivo temporal
            $tempFile = sys_get_temp_dir() . '/img_' . uniqid() . '.' . $imageType;
            file_put_contents($tempFile, $decodedImage);

            // Calcular la posición X e Y

            $xPosition = $xStart + ($currentColumn * ($columnWidth + 20)); // Añadir espacio horizontal entre imágenes
            $pdf->Image($tempFile, $xPosition, $currentY, 40, 40);

            // Incrementar columnas
            $currentColumn++;
            if ($currentColumn >= $maxColumns) {
                $currentColumn = 0;
                $currentRow++;
                if ($currentRow < 3) { // Solo avanzar filas si aún no hemos completado 3 filas
                    $currentY += $rowHeight; // Mover a la siguiente fila
                }
                $maxY = $currentY + 50; // Actualizar la posición Y máxima
            } else {
                $maxY = max($maxY, $currentY + 60);
            }

            // Eliminar archivo temporal
            unlink($tempFile);
        }
    }

    // Añadir espacio adicional después de las imágenes
    $pdf->SetY($maxY + 450); // 20 unidades extra de espacio
}



// Salida del PDF
$pdfContent = $pdf->Output('S', 'Reporte_Proyecto.pdf');

// --- Ahora inserta en la base de datos incluyendo el PDF ---
$idpa = $input['idpa'];

//Insertamos los datos en la tabla tratamientos atraves de sql 

$sql = "INSERT INTO tratamientos (idpa, datos) VALUES (:idpa, :datos)";
$stmt = $connect->prepare($sql);
$stmt->bindParam(':idpa', $idpa);
$stmt->bindParam(':datos', json_encode($input));   // Convertir a JSON antes de insertar
$stmt->execute();
// --- Finalmente envía el PDF al cliente ---
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="Reporte_Proyecto.pdf"');
echo $pdfContent;
exit();


