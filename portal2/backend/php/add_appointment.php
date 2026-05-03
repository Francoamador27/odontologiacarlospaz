<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../../backend/bd/Conexion.php');
require_once(__DIR__ . '/PHPMailer/src/PHPMailer.php');
require_once(__DIR__ . '/PHPMailer/src/Exception.php');
require_once(__DIR__ . '/PHPMailer/src/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;

$response = ['success' => false, 'message' => ''];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = trim($_POST['appnam']);
        $idpa = trim($_POST['apppac']);
        $idodc = trim($_POST['appdoc']);
        $color = trim($_POST['appco']);
        $start = $_POST['appini'];
        $duration = intval($_POST['duracion']);
        $monto = $_POST['appmont'];
        $chec = isset($_POST['appreal']) ? $_POST['appreal'] : '';

        $startDateTime = new DateTime($start);
        $endDateTime = clone $startDateTime;
        $endDateTime->modify("+{$duration} minutes");

        $start = $startDateTime->format('Y-m-d H:i:s');
        $end = $endDateTime->format('Y-m-d H:i:s');

        // Insertar evento en la base de datos
        $sql = "INSERT INTO events(title, idpa, idodc, color, start, end, state, monto, chec) 
                VALUES(:title, :idpa, :idodc, :color, :start, :end, 1, :monto, :chec)";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':idpa', $idpa);
        $stmt->bindParam(':idodc', $idodc);
        $stmt->bindParam(':color', $color);
        $stmt->bindParam(':start', $start);
        $stmt->bindParam(':end', $end);
        $stmt->bindParam(':monto', $monto);
        $stmt->bindParam(':chec', $chec);

        $stmt->execute();

        $lastInsertId = $connect->lastInsertId();

        if ($lastInsertId > 0) {
            $email_pa = buscar_email($connect, $idpa);
            if ($email_pa) {
                $response['success'] = true;
                $response['email'] = $email_pa;
                $response['motivo'] = $title;
                $response['duracion'] = $duration;
                $response['fecha'] = $startDateTime->format('d/m/Y H:i');
                $response['monto'] = $monto;
                $response['message'] = 'Cita agregada exitosamente';

            }else{
                $response['success'] = true;
                $response['email'] = false;
                $response['motivo'] = $title;
                $response['duracion'] = $duration;
                $response['fecha'] = $startDateTime->format('d/m/Y H:i');
                $response['monto'] = $monto;
                $response['message'] = 'Cita agregada exitosamente';
            }
        } else {
            $response['message'] = 'No se pudo agregar la cita';
        }
    } else {
        $response['message'] = 'Método no permitido';
    }
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

// Función para buscar el correo del paciente
function buscar_email($connect, $pa_id)
{
    $logFile = __DIR__ . '/error_log.txt';
    try {
        $sql = "SELECT email_p FROM patients WHERE idpa = :paId";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':paId', $pa_id);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result; // Devuelve el email o false si no se encuentra
    } catch (PDOException $e) {
        // Ruta del archivo donde se guardarán los errores

        // Mensaje del error
        $errorMessage = "Error al buscar el email del paciente: " . $e->getMessage() . 
                        " en " . $e->getFile() . 
                        " línea " . $e->getLine() . PHP_EOL;

        // Registrar el error en el archivo de texto

        // Opcional: devolver false si hay un error
        return false;
    }
}



echo json_encode($response);
?>
