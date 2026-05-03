<?php
require_once('../../../backend/bd/Conexion.php');
// eliminamos las imagenes a traves de json
try {
    // Verificar que la solicitud es GET
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception('Método no permitido', 405);
    }

    // Verificar que el parámetro id existe
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        throw new Exception('ID no proporcionado', 400);
    }

    // Validar que el ID es numérico - ajusta según el tipo esperado
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if ($id === false) {
        throw new Exception('ID inválido', 400);
    }



    $sentencia = $connect->prepare("DELETE FROM imagenes_pacientes WHERE id = :id");
    $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
    $sentencia->execute();
    // Establecer encabezados para respuesta exitosa
    header('Content-Type: application/json');
    header('Cache-Control: no-cache, must-revalidate');


    $nombreArchivo = $_GET['name'];
    $rutaArchivo = '../../img/subidas/' . $nombreArchivo;

    // Eliminar el archivo del sistema de archivos
    if (file_exists($rutaArchivo)) {
        unlink($rutaArchivo);
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Imagen eliminada correctamente'
    ]);
} catch (e) {
    // Obtener el código de estado HTTP desde la excepción o usar 500 por defecto
    $statusCode = $e->getCode() ?: 500;
    $statusMessages = [
        400 => 'Bad Request',
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error'
    ];

    // Establecer encabezados para respuesta de error
    header('Content-Type: application/json');
    header('HTTP/1.1 ' . $statusCode . ' ' . ($statusMessages[$statusCode] ?? 'Error'));

    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);

}