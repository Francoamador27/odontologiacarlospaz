<?php
header('Content-Type: application/json');

// Depuración: Verifica si se carga correctamente el archivo de conexión
if (!file_exists('../../../backend/bd/Conexion.php')) {
    echo json_encode(['error' => 'El archivo de conexión no existe']);
    exit;
}

require_once('../../../backend/bd/Conexion.php');

// Depuración: Verifica si la conexión a la base de datos se realizó correctamente
if (!isset($connect) || !$connect) {
    echo json_encode(['error' => 'No se pudo establecer la conexión a la base de datos']);
    exit;
}

// Verificar si se proporciona el parámetro `id`
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['error' => 'ID no proporcionado']);
    exit;
}

// Filtrar y validar el parámetro `id`
$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
if (!$id || $id <= 0) {
    echo json_encode(['error' => 'ID inválido']);
    exit;
}

// Depuración: Muestra el valor del ID recibido

try {
    // Prepara y ejecuta la consulta
    $sql = "  SELECT 
    e.id, 
    e.idpa, 
    e.idodc, 
    e.title, 
    e.start, 
    e.end, 
    e.monto, 
    e.chec, 
    e.color,
    d.nodoc AS doctor_name,
    d.apdoc AS doctor_lastname,
    p.nompa AS patient_name,
    p.email_p AS patient_email,
    p.phon AS patient_phone,
    p.apepa AS patient_lastname
FROM 
    events e
JOIN 
    patients p ON e.idpa = p.idpa
JOIN 
    doctor d ON e.idodc = d.idodc WHERE e.idpa = :id";
    $sentencia = $connect->prepare($sql);
    $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
    $sentencia->execute();

    // Verifica si hay resultados
    $data = $sentencia->fetchAll(PDO::FETCH_OBJ);
    if (empty($data)) {
        echo json_encode(['debug' => 'Consulta ejecutada, pero sin resultados', 'id' => $id]);
        exit;
    }

    // Array de días de la semana en español
    $dias_semana = [
        1 => 'lunes',
        2 => 'martes',
        3 => 'miércoles',
        4 => 'jueves',
        5 => 'viernes',
        6 => 'sábado',
        7 => 'domingo'
    ];

    // Formatear la fecha 'start' y agregar el día de la semana
    foreach ($data as $event) {
        $dateTime = new DateTime($event->start);
        
        // Formatear la fecha 'start' a dd/mm/yyyy
        $event->start = $dateTime->format('d/m/Y');
        
        // Obtener el número del día de la semana (1=lunes, 7=domingo)
        $dayOfWeek = $dateTime->format('N');
        
        // Obtener el nombre del día de la semana en español
        $event->day_of_week = $dias_semana[$dayOfWeek];
        
        // Obtener el día del mes
        $event->day_of_month = $dateTime->format('d');  // El día del mes
    }

    // Retornar datos en formato JSON
    echo json_encode(['success' => true, 'data' => $data]);
} catch (Exception $e) {
    // Captura errores y los muestra en el navegador
    echo json_encode(['error' => 'Error al realizar la consulta', 'message' => $e->getMessage()]);
}
?>
