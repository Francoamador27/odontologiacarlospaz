<?php
require_once('../../../backend/bd/Conexion.php');
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['error' => 'ID no proporcionado']);
    exit;
}
try {
    $sql = "SELECT * FROM tratamientos WHERE idpa = :id";
    $sentencia = $connect->prepare($sql);
    $sentencia->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $sentencia->execute();
    $tratamientos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    if(empty($tratamientos)) {
        echo json_encode([]);
    } else {
        echo json_encode($tratamientos);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}