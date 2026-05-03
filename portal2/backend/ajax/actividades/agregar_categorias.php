<?php
// Cargar el archivo de conexión
require_once('../../../backend/bd/Conexion.php');

// Enviar el encabezado para JSON
header('Content-Type: application/json');

// Respuesta inicial
$response = [
    'success' => false,
    'message' => 'Error al procesar la solicitud.'
];

try {
    $rawData = file_get_contents('php://input');

    // Convertir el JSON en un array PHP
    $data = json_decode($rawData, true);
    // Verificar si los datos han sido enviados por POST
    if (!isset($data['nombre_categoria'], $data['detalle_categoria'])) {
        $response['message'] = 'Faltan datos requeridos.';
        echo json_encode($response);
        exit;
    }

    // Sanitizar los datos recibidos
    $nombreCategoria = filter_var($data['nombre_categoria'], FILTER_SANITIZE_STRING);
    $detalleCategoria = filter_var($data['detalle_categoria'], FILTER_SANITIZE_STRING);

    // Insertar la información en la base de datos
    $sql = "INSERT INTO categorias_gastos (nombre_categoria, detalle_categoria) VALUES (:nombre_categoria, :detalle_categoria)";
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':nombre_categoria', $nombreCategoria);
    $stmt->bindParam(':detalle_categoria', $detalleCategoria);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Categoría guardada correctamente.';
    } else {
        $response['message'] = 'Error al insertar los datos.';
    }
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
} finally {
    // Enviar la respuesta en formato JSON
    echo json_encode($response);
}
?>