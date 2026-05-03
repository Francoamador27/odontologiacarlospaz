<?php
// Cargar el archivo de conexión
require_once('../../bd/Conexion.php');

// Enviar el encabezado para JSON
header('Content-Type: application/json');
$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

// Respuesta inicial
$response = [
    'success' => false,
    'message' => 'Error al procesar la solicitud.'
];

try {
    // Verificar si los datos han sido enviados a través de DELETE
    $method = $_SERVER['REQUEST_METHOD']; // Obtener el método de la solicitud
    if ($method !== 'DELETE') {
        $response['message'] = 'El método de solicitud debe ser DELETE.';
        echo json_encode($response);
        exit;
    }

    // Obtener el cuerpo de la solicitud (en caso de que los parámetros estén en el cuerpo)

    // Verificar si se ha enviado el ID de la consulta
    if (!isset($data['id'])) {
        $response['message'] = 'Falta el ID de la consulta.';
        echo json_encode($response);
        exit;
    }

    // Sanitizar el ID recibido
    $idconslt = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

    // Borrar el registro en la base de datos
    $sql = "DELETE FROM consult WHERE idconslt = :idconslt";
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':idconslt', $idconslt, PDO::PARAM_INT);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Registro borrado correctamente.';
    } else {
        $response['message'] = 'Error al borrar el registro.';
    }
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
} finally {
    echo json_encode($response);
}
?>
