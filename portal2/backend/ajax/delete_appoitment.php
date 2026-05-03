<?php
header('Content-Type: application/json');
require_once('../../backend/bd/Conexion.php');
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Inicializar respuesta
$response = [
    'success' => false,
    'message' => ''
];

try {
    // Verificar si se recibió el ID del evento
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        throw new Exception("No se proporcionó un ID de evento válido");
    }

    // Preparar la consulta de eliminación
    $consulta = "DELETE FROM `events` WHERE `id` = :id";
    $sql = $connect->prepare($consulta);

    // Limpiar y vincular el ID
    $idprcd = trim($_POST['id']);
    $sql->bindParam(':id', $idprcd, PDO::PARAM_INT);

    // Ejecutar la eliminación
    $resultado = $sql->execute();

    // Verificar si se eliminó correctamente
    if ($resultado && $sql->rowCount() > 0) {
        $response['success'] = true;
        $response['message'] = 'Evento eliminado correctamente';
    } else {
        $response['success'] = false;
        $response['message'] = 'No se encontró el evento o no se pudo eliminar';
    }
} catch (PDOException $e) {
    // Capturar errores de base de datos
    $response['success'] = false;
    $response['message'] = 'Error de base de datos: ' . $e->getMessage();
} catch (Exception $e) {
    // Capturar otros errores
    $response['success'] = false;
    $response['message'] = $e->getMessage();
} finally {
    // Devolver respuesta JSON
    echo json_encode($response);
    exit;
}
?>