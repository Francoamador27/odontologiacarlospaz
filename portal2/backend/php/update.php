<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../../backend/bd/Conexion.php');

$response = ['success' => false, 'message' => ''];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validar y obtener datos del formulario
        $eventId = isset($_POST['eventId']) ? intval($_POST['eventId']) : null;
        $title = isset($_POST['appnam']) ? trim($_POST['appnam']) : '';
        $idpa = isset($_POST['apppac']) ? trim($_POST['apppac']) : '';
        $idodc = isset($_POST['appdoc']) ? trim($_POST['appdoc']) : ''; // Ajusta el name del médico
        $start = isset($_POST['appini']) ? $_POST['appini'] : '';
        $end = isset($_POST['appfin']) ? $_POST['appfin'] : '';
        $monto = isset($_POST['appmont']) ? floatval($_POST['appmont']) : 0.00;
        $chec = isset($_POST['appreal']) && $_POST['appreal'] === '1' ? 1 : 0;

        // Validar campos requeridos
        // Array para almacenar los errores de validación
        $missingFields = [];
        
        // Validar campos requeridos
        if (!$eventId) {
            $missingFields[] = 'eventId';
        }
        if (!$title) {
            $missingFields[] = 'appnam (Motivo de la cita)';
        }
        if (!$idpa) {
            $missingFields[] = 'apppac (Paciente)';
        }
        if (!$idodc) {
            $missingFields[] = 'appdoc (Médico)';
        }
        if (!$start) {
            $missingFields[] = 'appini (Fecha inicial)';
        }
        if (!$end) {
            $missingFields[] = 'appfin (Fecha final)';
        }
        if ($monto <= 0) {
            $missingFields[] = 'appmont (Monto a pagar)';
        }
        
        if (!empty($missingFields)) {
            $response['success'] = false;
            $response['message'] = 'Faltan los siguientes campos: ' . implode(', ', $missingFields);
            echo json_encode($response);
            exit;
        }
        

        // Actualizar evento en la base de datos
        $sql = "UPDATE events 
                SET title = :title, idpa = :idpa, idodc = :idodc, start = :start, end = :end, monto = :monto, chec = :chec
                WHERE id = :eventId";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':idpa', $idpa);
        $stmt->bindParam(':idodc', $idodc);
        $stmt->bindParam(':start', $start);
        $stmt->bindParam(':end', $end);
        $stmt->bindParam(':monto', $monto);
        $stmt->bindParam(':chec', $chec);
        $stmt->bindParam(':eventId', $eventId);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $response['success'] = true;
            $response['message'] = 'Evento actualizado exitosamente.';
        } else {
            $response['message'] = 'No se encontró el evento o no se realizaron cambios.';
        }
    } else {
        $response['message'] = 'Método no permitido.';
    }
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

echo json_encode($response);
