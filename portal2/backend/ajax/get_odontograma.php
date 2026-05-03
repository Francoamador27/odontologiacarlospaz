<?php
require '../bd/Conexion.php'; // Asegúrate de que Conexion.php use PDO
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Manejar solicitudes OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Verificar si la solicitud es GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Validar que se proporcionó el parámetro idpa
        if (!isset($_GET['idpa'])) {
            throw new Exception("Parámetro idpa no proporcionado.");
        }

        $idpa = $_GET['idpa'];
        
        // Sanitizar el valor de idpa
        if (!is_numeric($idpa)) {
            throw new Exception("El valor de idpa debe ser numérico.");
        }
        
        // Preparar la consulta para obtener los datos
        $stmt = $connect->prepare("
            SELECT 
                id, 
                idpa, 
                datos, 
                DATE_FORMAT(fecha_creacion, '%d/%m/%Y %H:%i:%s') as fecha_creacion, 
                DATE_FORMAT(fecha_modificacion, '%d/%m/%Y %H:%i:%s') as fecha_modificacion 
            FROM odontograma 
            WHERE idpa = :idpa
        ");
        $stmt->bindParam(':idpa', $idpa);
        $stmt->execute();
        
        // Verificar si se encontraron resultados
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Decodificar los datos JSON para devolverlos como objeto
            $datos = json_decode($row['datos']);
            
            echo json_encode([
                "success" => true,
                "data" => [
                    "id" => $row['id'],
                    "idpa" => $row['idpa'],
                    "fecha_creacion" => $row['fecha_creacion'],
                    "fecha_modificacion" => $row['fecha_modificacion'],
                    "registros" => $datos
                ]
            ]);
        } else {
            echo json_encode([
                "success" => true,
                "data" => null,
                "message" => "No se encontraron registros para el paciente con id " . $idpa
            ]);
        }
        
    } catch (PDOException $e) {
        echo json_encode([
            "success" => false, 
            "message" => "Error de base de datos: " . $e->getMessage()
        ]);
    } catch (Exception $e) {
        echo json_encode([
            "success" => false, 
            "message" => "Error: " . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        "success" => false, 
        "message" => "Método no permitido. Use GET para esta solicitud."
    ]);
}
?>
