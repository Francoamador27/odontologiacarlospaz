<?php
require_once('../../backend/bd/Conexion.php');
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Mostrar errores como excepciones

if (isset($_POST['delete_appointment'])) {
    // Verificar el contenido de $_POST
    var_dump($_POST);

    ////////////// Actualizar la tabla /////////
    $consulta = "DELETE FROM `events` WHERE `id`=:id";
    $sql = $connect->prepare($consulta);

    // Verificar si la variable $id está correcta
    $idprcd = trim($_POST['id']);
    var_dump($idprcd); // Debug para ver el valor del ID
    $sql->bindParam(':id', $idprcd, PDO::PARAM_INT);

    try {
        $sql->execute();
        if ($sql->rowCount() > 0) {
            // Si se elimina correctamente
            echo '<script type="text/javascript">
            alert("Eliminado correctamente");
            window.location = "mostrar.php";
            </script>';
        } else {
            // Si no se elimina (por ejemplo, no encuentra el ID)
            echo '<script type="text/javascript">
            alert("Error al eliminar");
            window.location = "mostrar.php";
            </script>';
            print_r($sql->errorInfo()); // Mostrar detalles del error SQL
        }
    } catch (PDOException $e) {
        // Si ocurre una excepción, mostrarla en un alert
        echo '<script type="text/javascript">
        alert("Error: ' . $e->getMessage() . '");
        </script>';
    }
}
?>