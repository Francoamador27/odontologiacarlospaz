<?php
    ob_start();
     session_start();
    
    if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 1){
    header('location: ../login.php');

    $id=$_SESSION['id'];
  }
?>
<!DOCTYPE html>
<html lang="es">
<?php include('../componentes/header.php') ?>

<body>
    
    <!-- SIDEBAR -->
    <?php include('../componentes/sidebar.php') ?>

    <!-- SIDEBAR -->

    <!-- NAVBAR -->
    <section id="content">
        <!-- NAVBAR -->

        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <h1 class="title">Bienvenido <?php echo '<strong>'.$_SESSION['username'].'</strong>'; ?></h1>
            <ul class="breadcrumbs">
                <li><a href="../admin/escritorio.php">Home</a></li>
                <li class="divider">></li>
              
                <li><a href="#" class="active">Idioma del sistema</a></li>
            </ul>
       <?php 
require '../../backend/bd/Conexion.php';
$sentencia = $connect->prepare("SELECT * FROM idiom;");
 $sentencia->execute();
$data =  array();
if($sentencia){
  while($r = $sentencia->fetchObject()){
    $data[] = $r;
  }
}
     ?>
     <?php if(count($data)>0):?>
     <?php foreach($data as $d):?>    
<form action="" enctype="multipart/form-data" method="POST"  autocomplete="off" onsubmit="return validacion()">
  <div class="containerss">
    <h1>Idioma del sistema</h1>
   <br>
    <div class="alert-danger">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong>Importante!</strong> Es importante rellenar los campos con &nbsp;<span class="badge-warning">*</span>
</div>
    <hr>
    <br>

    <label for="email"><b>Nombre del idioma</b></label><span class="badge-warning">*</span>
   
    <select required="" name="confna" id="grp">
        <option value="<?php echo $d->nomidi ?>"><?php echo $d->nomidi ?></option>
      
        <option>-------------------</option>

        <option value="Spanish">Spanish</option>
        <option value="English">English</option>
  
    </select>
    <input type="hidden" value="<?php echo $d->idoma ?>" name="confid" required>

    

   

    <hr>
   
    <button type="submit" name="upd_idom" class="registerbtn">Guardar</button>
  </div>
  
</form>

 <?php endforeach; ?>
 <?php else:?>
  
    <div class="alert">
      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
      <strong>Danger!</strong> No hay datos.
    </div>
    <?php endif; ?>

        </main>
        <!-- MAIN -->
    </section>
    
    <!-- NAVBAR -->
    <script src="../../backend/js/jquery.min.js"></script>
    
    <script src="../../backend/js/script.js"></script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
 <?php include_once '../../backend/php/upd_idom.php' ?>
</body>
</html>


