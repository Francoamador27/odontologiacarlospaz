<?php
// Conexión a la base de datos
include('../backend/db_connection.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Comprobar si la solicitud es GET


// Comprobar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Recibir los datos enviados desde el frontend (usando POST)
    $data = json_decode(file_get_contents('php://input'), true);

    echo json_encode(['success' => true, 'message' => 'Estado actualizado correctamente']);
    // Debug: Mostrar los datos recibidos
    error_log("Datos recibidos: " . print_r($data, true));

    // Validar que los datos estén presentes
    if (isset($data['id']) && isset($data['appreal'])) {
        $checkboxId = $data['id']; // ID del checkbox
        $checkboxValue = $data['appreal']; // Valor 1 o 0
        echo json_encode(['success' => true, 'message' => 'Estado actualizado correctamente']);

        // Debug: Mostrar las variables

        // SQL para actualizar el estado en la base de datos
        $sql = "UPDATE events SET chec = :estado WHERE id = :id";

        try {
            // Preparar la consulta
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':estado', $checkboxValue, PDO::PARAM_INT);
            $stmt->bindParam(':id', $checkboxId, PDO::PARAM_INT);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Debug: Mostrar éxito
                error_log("Actualización exitosa para el ID: " . $checkboxId);
                // Enviar respuesta exitosa
                echo json_encode(['success' => true, 'message' => 'Estado actualizado correctamente']);
            } else {
                // Debug: Mostrar error en la ejecución
                error_log("Error al ejecutar la consulta");
                // Enviar error si la actualización falla
                echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta']);
            }
        } catch (PDOException $e) {
            // Enviar error con el mensaje de la excepción
            error_log("Error en la consulta: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error en la consulta: ' . $e->getMessage()]);
        }
    } else {
        // Si no se reciben los datos correctamente, enviar error
        error_log("Datos incompletos: ID o appreal no recibidos");
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    }
} else {
    // Si no se recibe el método POST ni GET, enviar error
    error_log("Método no aceptado");
    echo json_encode(['success' => false, 'message' => 'Método no aceptado']);
}
?>
