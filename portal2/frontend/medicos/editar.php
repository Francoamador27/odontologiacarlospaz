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



        <!-- MAIN -->

        <main>
            <h1 class="title">Bienvenido <?php echo '<strong>'.$_SESSION['username'].'</strong>'; ?></h1>
            <ul class="breadcrumbs">
                <li><a href="../admin/escritorio.php">Home</a></li>
                <li class="divider">></li>
                <li><a href="../medicos/mostrar.php">Listado de los médicos</a></li>
                <li class="divider">></li>
                <li><a href="#" class="active">Actualizar del médico</a></li>
            </ul>
           
           <!-- multistep form -->
<?php 
require '../../backend/bd/Conexion.php';
 $id = $_GET['id'];
 $sentencia = $connect->prepare("SELECT * FROM doctor  WHERE idodc= '$id';");
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

<form action="" enctype="multipart/form-data" method="POST"  autocomplete="off" >
  <div class="containerss">
    <h1>Actualizar médico</h1>
    
   <br>
    <hr>

    
    <input type="hidden" name="midp" value="<?php echo $d->idodc; ?>">

    <label for="psw"><b>Cédula del médico</b></label><span class="badge-warning">*</span>
    <input type="text" maxlength="15" name="docce" value="<?php echo $d->ceddoc; ?>"  required>


    <label for="psw"><b>Nombre del médico</b></label><span class="badge-warning">*</span>
    <input type="text"  name="docna" value="<?php echo $d->nodoc; ?>"  required>

    <label for="psw"><b>Apellido del médico</b></label><span class="badge-warning">*</span>
    <input type="text"  name="docap" value="<?php echo $d->apdoc; ?>"  required>


    <label for="psw"><b>Especialidad del médico</b></label><span class="badge-warning">*</span>
    <select required name="doces"  id="espm">
        <option value="<?php echo $d->nomesp; ?>"><?php echo $d->nomesp; ?></option>
        <option value="Odontologia">Odontologia</option>
       
        
    </select>



    <label for="psw"><b>Dirección del médico</b></label><span class="badge-warning">*</span>
    <input type="text"  name="docdi" value="<?php echo $d->direcd; ?>"  required>

    <label for="psw"><b>Género del médico</b></label><span class="badge-warning">*</span>
    <select required name="docge"  id="gep">
        <option value="<?php echo $d->sexd; ?>"><?php echo $d->sexd; ?></option>
        <option>----------------------SELECCIONE----------------</option>
        <option value="Masculino">Masculino</option>
        <option value="Femenino">Femenino</option>

    </select>

    <label for="psw"><b>Teléfono del médico</b></label><span class="badge-warning">*</span>
    <input type="text" maxlength="13"  name="docte" value="<?php echo $d->phd; ?>"  required>

    <label for="psw"><b>Nacimiento del médico</b></label><span class="badge-warning">*</span>
    <input type="date"  name="docda" value="<?php echo $d->nacd; ?>"  required>


    <hr>
   
   <button type="submit" name="upd_doctors" class="registerbtn">Guardar</button>
  </div>
  
</form>
<?php endforeach; ?>
  
    <?php else:?>
      <p class="alert alert-warning">No hay datos</p>
    <?php endif; ?>

        </main>
        <!-- MAIN -->
    </section>
    <script src="../../backend/js/jquery.min.js"></script>


    <!-- NAVBAR -->
    
    <script src="../../backend/js/script.js"></script>
    <script src="../../backend/js/multistep.js"></script>
    <script src="../../backend/js/vpat.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php include_once '../../backend/php/upd_doctor.php' ?>

   
</body>
</html>


