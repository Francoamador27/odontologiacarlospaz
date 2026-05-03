<?php
require_once('../../../backend/bd/Conexion.php');
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['error' => 'ID no proporcionado']);
    exit;
}
try {
    $sql = "DELETE FROM tratamientos WHERE id = :id and idpa = :idpa";
    $sentencia = $connect->prepare($sql);
    $sentencia->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $sentencia->bindParam(':idpa', $_GET['idpa'], PDO::PARAM_INT);
    $sentencia->execute();
    echo json_encode(['status' => 'ok']);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}