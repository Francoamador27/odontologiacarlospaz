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


    // Sanitizar los datos recibidos
    $descripcion = filter_var($data['descripcion'], FILTER_SANITIZE_STRING);
    $idcat = filter_var($data['categoria_id'], FILTER_SANITIZE_STRING);
    $importe = filter_var($data['importe'], FILTER_SANITIZE_STRING);
    $fecha = filter_var($data['fecha'], FILTER_SANITIZE_STRING);

    // Verificar si los datos no están vacíos
    if (empty($descripcion) || empty($idcat) || empty($importe) || empty($fecha)) {
        $response['message'] = 'Por favor, llena todos los campos.';
        echo json_encode($response);
        exit;
    }

    // Crear una instancia de la clase de conexión
// DATOS QUE VIENEN DESDE EL FRONT 
// formData: {
//     categoria_id: '',
//     descripcion: '',
//     importe: '',
//     fecha: new Date().toISOString().split('T')[0] // Fecha actual por defecto
// },

    // Insertar la información en la base de datos
    $sql = "INSERT INTO gastos (idcat, descripcion,importe,fecha) VALUES (:idcat, :descripcion, :importe, :fecha)";
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':idcat', $idcat);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':importe', $importe);
    $stmt->bindParam(':fecha', $fecha);
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