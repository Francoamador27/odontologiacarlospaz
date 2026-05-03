<?php 
require_once('../../../backend/bd/Conexion.php'); 

header('Content-Type: application/json'); // Configurar la respuesta como JSON
$response = array(); // Array para la respuesta JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    ///////////// Informacion enviada por el formulario ///////////// 
    $idpa = $_POST['idpa']; 
    $descripcion = $_POST['descripcion']; 
 
    $imgFile = $_FILES['imagen']['name']; 
    $tmp_dir = $_FILES['imagen']['tmp_name']; 
    $imgSize = $_FILES['imagen']['size']; 
    ///////// Fin informacion enviada por el formulario ///  
 
    if (empty($imgFile)) { 
        $response['status'] = 'error';
        $response['message'] = "Por favor ingrese el nombre del archivo.";
        echo json_encode($response);
        exit;
    } else if (empty($descripcion)) { 
        $response['status'] = 'error';
        $response['message'] = "Por favor ingrese la descripcion de la imagen.";
        echo json_encode($response);
        exit;
    } else { 
        $upload_dir = '../../../backend/img/subidas/'; // upload directory 
 
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension 
 
        // valid image extensions 
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions 
 
        // rename uploading image 
        $foto = rand(1000, 1000000) . "." . $imgExt; 
 
        // allow valid image file formats 
        if (in_array($imgExt, $valid_extensions)) { 
            // Check file size '5MB' 
            if ($imgSize < 5000000) { 
                move_uploaded_file($tmp_dir, $upload_dir . $foto); 
            } else { 
                $response['status'] = 'error';
                $response['message'] = "Lo sentimos, el archivo es demasiado grande.";
                echo json_encode($response);
                exit;
            } 
        } else { 
            $response['status'] = 'error';
            $response['message'] = "Lo sentimos, solo se permiten archivos JPG, JPEG, PNG y GIF.";
            echo json_encode($response);
            exit;
        } 
    } 
 
    $sql = "insert into imagenes_pacientes(nomfile, descripcion, idpa)  
            values(:nomfile, :descripcion, :idpa)"; 
 
    $sql = $connect->prepare($sql); 
 
    $sql->bindParam(':nomfile', $foto, PDO::PARAM_STR, 25); 
    $sql->bindParam(':descripcion', $descripcion, PDO::PARAM_STR, 25); 
    $sql->bindParam(':idpa', $idpa, PDO::PARAM_STR, 25); 
 
    $sql->execute(); 
 
    $lastInsertId = $connect->lastInsertId(); 
    
    if ($lastInsertId > 0) { 
        $response['status'] = 'success';
        $response['message'] = "Documento agregado correctamente";
        $response['redirect'] = "/pacientes/historia.php?id=" . $idpa . "&pestaña=documentos";
    } else { 
        $response['status'] = 'error';
        $response['message'] = "No se pueden agregar datos, comuníquese con el administrador";
        $response['redirect'] = "documentos.php";
        $response['errorInfo'] = $sql->errorInfo();
    } 
    
    echo json_encode($response);
} else {
    $response['status'] = 'error';
    $response['message'] = "Solicitud no válida";
    echo json_encode($response);
}
?>