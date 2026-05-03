<?php
// Cargar el archivo de conexión
require_once('../../../backend/bd/Conexion.php');

// Enviar el encabezado para JSON
header('Content-Type: application/json');

$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Respuesta inicial
$response = [
    'success' => false,
    'message' => 'Error al procesar la solicitud.'
];

try {
    // Verificar si los datos han sido enviados por POST
    if (!isset($data['mtcl'], $data['idpa'])) {
        $response['message'] = 'Faltan datos requeridos.';
        echo json_encode($response);
        exit;
    }

    // Sanitizar los datos recibidos
    $consl = filter_var($data['mtcl'], FILTER_SANITIZE_STRING);
    $state = filter_var($data['state'], FILTER_SANITIZE_STRING);
    $csidpa = filter_var($data['idpa'], FILTER_SANITIZE_STRING);
    $ferenota = isset($data['fere']) ? filter_var($data['fere'], FILTER_SANITIZE_STRING) : null;
    $numdiente = isset($data['numdiente']) ? filter_var($data['numdiente'], FILTER_SANITIZE_STRING) : null;


 // Insertar la información en la base de datos
    $sql = "INSERT INTO consult (mtcl, idpa, state, numdiente, fere) VALUES (:consl, :csidpa, :state, :numdiente,:fere)";
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':consl', $consl);
    $stmt->bindParam(':csidpa', $csidpa);
    $stmt->bindParam(':numdiente', $numdiente);
    $stmt->bindParam(':fere', $ferenota);
    $stmt->bindParam(':state', $state);

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
