<?php
// Cargar el archivo de conexión
require_once('../../../backend/bd/Conexion.php');

// Enviar el encabezado para JSON
header('Content-Type: application/json');

// Respuesta inicial
$response = [
    'success' => false,
    'message' => 'Error al procesar la solicitud.',
    'data' => []
];

try {
    // Preparar la consulta SQL para obtener id, nombre_categoria y detalle_categoria
    $sql = "SELECT id, nombre_categoria, detalle_categoria FROM categorias_gastos";
    $stmt = $connect->prepare($sql);
    $stmt->execute();

    // Obtener todas las categorías
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($categorias) {
        $response['success'] = true;
        $response['message'] = 'Categorías obtenidas correctamente.';
        $response['data'] = $categorias;
    } else {
        $response['message'] = 'No hay categorías disponibles.';
    }
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
} finally {
    // Enviar la respuesta en formato JSON
    echo json_encode($response);
}
?>
