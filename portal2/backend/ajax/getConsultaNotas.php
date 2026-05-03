<?php
header('Content-Type: application/json');
require_once('../../backend/bd/Conexion.php');

// Verificar conexión y entrada
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['error' => 'ID no proporcionado']);
    exit;
}

$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

try {
    // Conectar y realizar la consulta
    $sentencia = $connect->prepare("SELECT * FROM consult WHERE idpa = :id");
    $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
    $sentencia->execute();
    $data = $sentencia->fetchAll(PDO::FETCH_OBJ);

    // Retornar datos en formato JSON
    echo json_encode($data);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
