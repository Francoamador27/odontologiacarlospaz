<?php
// Cargar el archivo de conexión
require_once('../../backend/bd/Conexion.php');

// Enviar el encabezado para JSON
header('Content-Type: application/json');

// Respuesta inicial
$response = [
    'success' => false,
    'message' => 'Error al procesar la solicitud.'
];

try {
    // Verificar si los datos han sido enviados por POST
    if (!isset($_POST['consl'], $_POST['csidpa'], $_POST['csnopa'])) {
        $response['message'] = 'Faltan datos requeridos.';
        echo json_encode($response);
        exit;
    }

    // Sanitizar los datos recibidos
    $consl = filter_var($_POST['consl'], FILTER_SANITIZE_STRING);
    $csidpa = filter_var($_POST['csidpa'], FILTER_SANITIZE_STRING);
    $csnopa = filter_var($_POST['csnopa'], FILTER_SANITIZE_STRING);
    $fechanota = isset($_POST['fecha']) ? filter_var($_POST['fecha'], FILTER_SANITIZE_STRING) : null;
    $numdiente = isset($_POST['numdiente']) ? filter_var($_POST['numdiente'], FILTER_SANITIZE_STRING) : null;

    // Verificar si la columna 'numdiente' existe en la tabla
    $checkColumnSql = "
        SELECT COUNT(*) AS column_exists
        FROM information_schema.COLUMNS 
        WHERE TABLE_NAME = 'consult' 
          AND COLUMN_NAME = 'numdiente' 
          AND TABLE_SCHEMA = DATABASE()
    ";
    $checkStmt = $connect->query($checkColumnSql);
    $columnExists = $checkStmt->fetch(PDO::FETCH_ASSOC)['column_exists'];

    // Si la columna no existe, agregarla
    if (!$columnExists) {
        $alterTableSql = "ALTER TABLE consult ADD COLUMN numdiente VARCHAR(255) NULL";
        $connect->exec($alterTableSql);
    }

    // Insertar la información en la base de datos
    $sql = "INSERT INTO consult (mtcl, idpa, nompa, state, numdiente, fere) VALUES (:consl, :csidpa, :csnopa, '1', :numdiente,:fecha)";
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':consl', $consl);
    $stmt->bindParam(':csidpa', $csidpa);
    $stmt->bindParam(':csnopa', $csnopa);
    $stmt->bindParam(':numdiente', $numdiente);
    $stmt->bindParam(':fecha', $fechanota);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Agregado correctamente.';
    } else {
        $response['message'] = 'Error al insertar los datos.';
    }
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
} finally {
    echo json_encode($response);
}
