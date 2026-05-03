<?php
require_once('../../../backend/bd/Conexion.php');
header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => 'Error al procesar la solicitud.',
    'data' => []
];

try {
    // Obtener mes desde el frontend o usar mes actual
    $mes = isset($_GET['mes']) ? $_GET['mes'] : date('m');
    
    // Validar formato del mes (01-12)
    if (!preg_match('/^(0[1-9]|1[0-2])$/', $mes)) {
        throw new Exception('Mes inválido. Debe ser entre 01 y 12');
    }

    // Construir consulta con filtro de mes
    $sql = "
    SELECT 
        e.start as fecha, 
        e.monto as monto
    FROM 
        events e
    WHERE 
        MONTH(e.start) = :mes AND e.chec = 1
    ";

    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':mes', $mes, PDO::PARAM_STR);
    $stmt->execute();

    $gastos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($gastos) {
        $response['success'] = true;
        $response['message'] = 'Gastos obtenidos correctamente.';
        $response['data'] = $gastos;
    } else {
        $response['message'] = "No hay gastos registrados para el mes $mes.";
        $response['success'] = true; // Mantenemos success=true porque no es un error
    }
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
} finally {
    echo json_encode($response);
}
?>