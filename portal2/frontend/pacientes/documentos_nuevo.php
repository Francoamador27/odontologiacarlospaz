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

        <!-- MAIN -->

        <main>
            <h1 class="title">Bienvenido <?php echo '<strong>'.$_SESSION['username'].'</strong>'; ?></h1>
            <ul class="breadcrumbs">
                <li><a href="../admin/escritorio.php">Home</a></li>
                <li class="divider">></li>
                <li><a href="../pacientes/documentos.php">Documentos de los pacientes</a></li>
                <li class="divider">></li>
                <li><a href="#" class="active">Nuevo documento</a></li>
            </ul>
           <br>

           <?php 
require '../../backend/bd/Conexion.php';
 $id = $_GET['id'];
 $sentencia = $connect->prepare("SELECT * FROM patients  WHERE idpa= '$id';");
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
<div class="input-block">

                    <div class="wrap-line">

                                <!-- Inputs -->
        <div class="brise-input">
            
            <input type="text" value="<?php echo $d->numhs; ?>" name="text" required>
            
            <span class="line"></span>
        </div>
        <div class="brise-input">
            
            <input type="text" value="<?php echo $d->nompa; ?>" name="text" required>
           
            <span class="line"></span>
        </div>

                <!-- Inputs -->
        <div class="brise-input">
            
            <input type="text" value="<?php echo $d->apepa; ?>" name="text" required>
            
            <span class="line"></span>
        </div>
        <div class="brise-input">
           
            <input type="text" value="<?php echo $d->direc; ?>" name="text" required>
            
            <span class="line"></span>
        </div>

        <div class="brise-input">
          
            <input type="text" value="<?php echo $d->cump; ?>" name="text" required>
            
            <span class="line"></span>
        </div>


        <div class="brise-input">
          
            <input type="text" value="<?php echo $d->sex; ?>" name="text" required>
            
            <span class="line"></span>
        </div>

                <div class="brise-input">
            
            <input type="text" value="<?php echo $d->grup; ?>" name="text" required>
            
            <span class="line"></span>
        </div>

        <div class="brise-input">
           
            <input type="text" value="<?php echo $d->phon; ?>" name="text" required>
            
            <span class="line"></span>
        </div>
                        
                    </div>

</div>


<div class="data">
    <div class="content-data">
        <div class="head">
            <h3>Nuevo documento</h3>
                  <div class="botonsa-modals">
        <label for="btnsa-modals">
            Nuevo
        </label>
    </div>         
        </div>
<div class="flexbox">
        <ul class="flex-card-list">
             <?php 
$id = $_GET['id'];
 $sentencia = $connect->prepare("SELECT * FROM document  WHERE idpa= '$id';");
 $sentencia->execute();

$data =  array();
if($sentencia){
  while($r = $sentencia->fetchObject()){
    $data[] = $r;
  }
}

 ?>
 <?php  if(count($data)>0):?>

        <?php foreach($data as $e):?> 
          <li class="flex-card-listitem">
            <div class="flex-card">
              <div class="flex-card-image">
                <img src="../../backend/img/subidas/<?php echo $e->foto; ?>" />
              </div>
              <div class="flex-card-content">
                <a href="../../backend/img/subidas/<?php echo $e->foto; ?>" class="flex-card-button" download>Download</a>
              </div>
            </div>
          </li>
          <?php endforeach; ?>
  
    <?php else:?>
      <p class="alert alert-warning">No existe ningun documento</p>
    <?php endif; ?>

        </ul>
      </div>

    </div>
</div>



        <?php endforeach; ?>
  
    <?php else:?>
      <p class="alert alert-warning">No hay datos</p>
    <?php endif; ?>


        </main>
        <!-- MAIN -->
    </section>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <!-- NAVBAR -->
    
    <script src="../../backend/js/script.js"></script>
    <script src="../../backend/js/multistep.js"></script>
    <script src="../../backend/js/vpat.js"></script>
    


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include_once '../../backend/modal/md_docu.php' ?>
<?php include_once '../../backend/php/add_docu.php' ?>




</body>
</html>


