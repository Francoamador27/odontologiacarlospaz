<?php
header('Content-Type: application/json');

// Conexión a la base de datos
require_once('../../backend/bd/Conexion.php');

// Connecting database
try {
    $connect = new PDO("mysql:host=".dbhost."; dbname=".dbname, dbuser, dbpass);
    $connect->query("set names utf8;");
    // $connect->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    //$connect->setAttribute( PDO::ATTR_EMULATE_PREPARES, true );
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
}
catch(PDOException $e) {
    echo $e->getMessage();
}
//---------------

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Comprobar si la solicitud es GET
header('Content-Type: application/json');


// Comprobar si la solicitud es POST

// Ruta para guardar el archivo de errores
$error_log_file = __DIR__ . '/errores.txt';

// Función para guardar el error en el archivo de texto
function log_error($message) {
    global $error_log_file;
    $timestamp = date("Y-m-d H:i:s");
    $error_message = "[{$timestamp}] - {$message}\n";
    file_put_contents($error_log_file, $error_message, FILE_APPEND);
}
$rawData = file_get_contents('php://input');
    
// Convertir el JSON en un array PHP
$data = json_decode($rawData, true);

// Mostrar los datos recibidos en el POST
log_error("Datos recibidos: " . print_r($data, true)); if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($data['id']) && isset($data['chec'])) {
        $checkboxId = $data['id']; // ID del checkbox
        $checkboxValue = $data['chec']; // Valor 1 o 0

        // SQL para actualizar el estado en la base de datos
        $sql = "UPDATE events SET chec = :estado WHERE id = :id";

        try {
            // Preparar la consulta
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':estado', $checkboxValue, PDO::PARAM_INT);
            $stmt->bindParam(':id', $checkboxId, PDO::PARAM_INT);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Registro del éxito en el archivo de errores
                // Enviar respuesta exitosa
                echo json_encode(['success' => true, 'message' => 'Estado actualizado correctamente']);
            } else {
                // Registrar error en el archivo de errores
                // Enviar error si la actualización falla
                echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta']);
            }
        } catch (PDOException $e) {
            // Registrar la excepción en el archivo de errores
            echo json_encode(['success' => false, 'message' => 'Error en la consulta: ' . $e->getMessage()]);
        }
    } else {
        // Si no se reciben los datos correctamente, registrar el error
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    }
} else {
    // Si no se recibe el método POST ni GET, registrar el error
    echo json_encode(['success' => false, 'message' => 'Método no aceptado']);
}



