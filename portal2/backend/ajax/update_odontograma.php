<?php
require '../bd/Conexion.php'; // Asegúrate de que Conexion.php use PDO
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Manejar solicitudes OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $input_json = file_get_contents('php://input');
        $input = json_decode($input_json, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Error decodificando JSON: " . json_last_error_msg());
        }

        if (!isset($input['idpa']) || !isset($input['datos']) || !isset($input['fecha_modificacion'])) {
            throw new Exception("Datos incompletos: idpa, datos o fecha_modificacion no proporcionados.");
        }

        $idpa = $input['idpa'];
        $datos = json_encode($input['datos']);
        $fecha_modificacion = $input['fecha_modificacion'];
        $fecha_creacion = date('Y-m-d H:i:s');

        // Verificar si el registro ya existe
        $stmt = $connect->prepare("SELECT id FROM odontograma WHERE idpa = :idpa");
        $stmt->bindParam(':idpa', $idpa);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            // Actualizar los datos existentes
            $updateQuery = "UPDATE odontograma 
                            SET datos = :datos, fecha_modificacion = :fecha_modificacion 
                            WHERE idpa = :idpa";
            $stmt = $connect->prepare($updateQuery);
        } else {
            // Insertar nuevos datos
            $insertQuery = "INSERT INTO odontograma (idpa, datos, fecha_modificacion, fecha_creacion) 
                            VALUES (:idpa, :datos, :fecha_modificacion, :fecha_creacion)";
            $stmt = $connect->prepare($insertQuery);
            $stmt->bindParam(':fecha_creacion', $fecha_creacion);
        }

        // Enlazar parámetros comunes
        $stmt->bindParam(':idpa', $idpa);
        $stmt->bindParam(':datos', $datos);
        $stmt->bindParam(':fecha_modificacion', $fecha_modificacion);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Datos guardados correctamente."]);
        } else {
            throw new Exception("Error al ejecutar la consulta.");
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
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}
?>
