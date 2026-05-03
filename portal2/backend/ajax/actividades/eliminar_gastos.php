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
    // Verificar si se recibió el parámetro 'id' en la solicitud GET
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = intval($_GET['id']); // Sanitizar el parámetro 'id'

        // Preparar la consulta SQL para eliminar el gasto
        $sql = "DELETE FROM gastos WHERE id = :id";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $response['success'] = true;
                $response['message'] = 'Gasto eliminado correctamente.';
            } else {
                $response['message'] = 'No se encontró un gasto con el ID proporcionado.';
            }
        } else {
            $response['message'] = 'Error al intentar eliminar el gasto.';
        }
    } else {
        $response['message'] = 'El parámetro "id" es requerido.';
    }
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
} finally {
    // Enviar la respuesta en formato JSON
    echo json_encode($response);
}
?>