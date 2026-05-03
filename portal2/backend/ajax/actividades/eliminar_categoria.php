<?php 
require_once('../../../backend/bd/Conexion.php');

// Enviar el encabezado para JSON
header('Content-Type: application/json');
try{
    $response = [
        'success' => false,
        'message' => 'Error al procesar la solicitud.',
        'data' => []
    ];
    if (!isset($_GET['id_categoria']) || empty($_GET['id_categoria'])) {
        throw new Exception('ID no proporcionado', 400);
    }
    $id = filter_var($_GET['id_categoria'], FILTER_VALIDATE_INT);
    
    
    $sql = "DELETE FROM categorias_gastos WHERE id = :id";
    $sentencia = $connect->prepare($sql);
    $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
    $sentencia->execute();
    echo json_encode([
        'status' => 'success',
        'message' => 'Categoria eliminada correctamente'
    ]);

}catch(e){
    $statusCode = $e->getCode() ?: 500;
    $statusMessages = [
        400 => 'Bad Request',
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error'
    ];
    header('HTTP/1.1 ' . $statusCode . ' ' . ($statusMessages[$statusCode] ?? 'Error'));
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);

}
// Respuesta inicial
