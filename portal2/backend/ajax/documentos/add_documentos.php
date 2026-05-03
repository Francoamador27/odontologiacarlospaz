<?php
require_once('../../../backend/bd/Conexion.php');

header('Content-Type: application/json');
$response = array();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Información enviada por el formulario
        $idpa = isset($_POST['idpa']) ? $_POST['idpa'] : null;
        $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : null;

        if (!isset($_FILES['pdfFile'])) {
            throw new Exception("No se recibió ningún archivo.");
        }

        $pdfFile = $_FILES['pdfFile'];
        $imgFile = $pdfFile['name'];
        $tmpDir = $pdfFile['tmp_name'];
        $imgSize = $pdfFile['size'];

        // Validaciones
        if (empty($idpa)) {
            throw new Exception("El ID del paciente es requerido.");
        }
        if (empty($descripcion)) {
            throw new Exception("Por favor, ingrese la descripción del documento.");
        }
        if (empty($imgFile)) {
            throw new Exception("Por favor, seleccione un archivo para subir.");
        }

        // Configuración del directorio de subida y extensiones válidas
        $uploadDir = '../../../backend/pdfs/subidos/';
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION));
        $validExtensions = ['txt', 'xls', 'xlsx', 'doc', 'docx', 'pdf'];

        // Validar extensión y tamaño del archivo
        if (!in_array($imgExt, $validExtensions)) {
            throw new Exception("Solo se permiten archivos con extensiones: TXT, XLS, XLSX, DOC, DOCX y PDF.");
        }
        if ($imgSize > 5000000) {
            throw new Exception("El archivo es demasiado grande. Tamaño máximo permitido: 5MB.");
        }

        // Renombrar el archivo para evitar conflictos
        $fileName = uniqid("doc_") . "." . $imgExt;

        // Mover el archivo al directorio de subida
        if (!move_uploaded_file($tmpDir, $uploadDir . $fileName)) {
            throw new Exception("Error al subir el archivo. Por favor, intente nuevamente.");
        }

        // Guardar en la base de datos
        $sql = "INSERT INTO document (nomfi, descripcion, idpa) VALUES (:nomfi, :descripcion, :idpa)";
        $stmt = $connect->prepare($sql);

        $stmt->bindParam(':nomfi', $fileName, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':idpa', $idpa, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $lastInsertId = $connect->lastInsertId();
            $response = [
                'status' => 'success',
                'message' => 'Documento agregado correctamente.',
            ];
        } else {
            throw new Exception("Error al guardar los datos en la base de datos.");
        }
    } else {
        throw new Exception("Solicitud no válida.");
    }
} catch (Exception $e) {
    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
}

echo json_encode($response);
