<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../../backend/bd/Conexion.php');

if (isset($_POST['delete_doctor'])) {
    // Preparar la consulta para eliminar al doctor
    $consulta = "DELETE FROM `doctor` WHERE `idodc`=:idodc";
    $sql = $connect->prepare($consulta);
    $sql->bindParam(':idodc', $idodc, PDO::PARAM_INT);
    $idodc = trim($_POST['idodc']);
    
    try {
        // Ejecutar la consulta
        $sql->execute();

        // Verificar si se eliminó alguna fila
        if ($sql->rowCount() > 0) {
          $success_message = urlencode("Se pudo eliminar el doctor con exito.");
  
          header("Location: ?success=$success_message");
          exit();
        } else {
          echo "No se encontró el doctor.";
        }
      } catch (PDOException $e) {
        if ($e->getCode() == 23000) {  // Código de error de violación de integridad
          $error_message = urlencode("No se puede eliminar el doctor porque tiene citas pendientes.");

        header("Location: ?error=$error_message");
        exit();
      } else {
          echo "Ocurrió un error inesperado: " . $e->getMessage();
      }
  }
}