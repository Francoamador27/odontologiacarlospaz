<?php
require_once('../../backend/bd/Conexion.php');
header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => ''
];
$data = json_decode(file_get_contents("php://input"), true);
$title = $data['motivo'];
$duration = $data['duracion'];
$fecha = $data['fecha'];
$email_pa = $data['email'];



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $to = "odcapellan@gmail.com, $email_pa";
    $subject = "Turno odontológico";

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: turnoodontologico@odontologiacarlospaz.com.ar\r\n";

    $message = "
    <html>
    <body style='font-family: Arial, sans-serif; background-color: #f4f4f9; color: #333; margin: 0; padding: 0;'>
        <div style='background-color: #ffffff; border-radius: 8px; max-width: 600px; margin: 20px auto; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);'>
            <h1 style='color: #008DD2; margin: 0; font-size: 24px;'>Confirmación de Turno</h1>
            <p>Hola,</p>
            <p>Se ha registrado un nuevo turno con los siguientes detalles:</p>
            <ul>
                <li><strong>Motivo del turno:</strong> $title</li>
                <li><strong>Duración aproximada:</strong> $duration minutos</li>
                <li><strong>Fecha del turno:</strong> " . $fecha . "</li>
                <li><strong>Correo del paciente:</strong> $email_pa</li>
            </ul>
            <p>Para modificar el turno, haga clic en el siguiente enlace:</p>
            <p><a href='https://api.whatsapp.com/send/?phone=543518078727&text=Necesito%20modificar%20el%20turno&type=phone_number&app_absent=0' 
               style='background-color: #25D366; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>
               Modificar cita
               </a></p>
        </div>
    </body>
    </html>
    ";
    if (mail($to, $subject, $message, $headers)) {
        // Si el correo se envió con éxito
        $response['success'] = true;
        $response['message'] = 'Correo enviado';
    } else {
        // Si hubo un problema al enviar el correo
        $response['success'] = false;
        $response['message'] = 'Hubo un problema al enviar el correo';
    }

} else {
    $response['success'] = true;
    $response['message'] = 'Cita agregada exitosamente, no se encontró el email del paciente registrado';
}
echo json_encode($response);

