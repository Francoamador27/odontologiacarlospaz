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
        <nav>
            <i class='bx bx-menu toggle-sidebar' ></i>
            <form action="#">
                <div class="form-group">
                    <input type="text" placeholder="Search...">
                    <i class='bx bx-search icon' ></i>
                </div>
            </form>
            
           
            <span class="divider"></span>
            <div class="profile">
                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8cGVvcGxlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="">
                <ul class="profile-link">
              <li><a href="../profile/mostrar.php"><i class='bx bxs-user-circle icon' ></i> Profile</a></li>
                    
                    <li>
                     <a href="../salir.php"><i class='bx bxs-log-out-circle' ></i> Logout</a>
                    </li>
                   
                </ul>
            </div>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->

        <main>
            <h1 class="title">Bienvenido <?php echo '<strong>'.$_SESSION['username'].'</strong>'; ?></h1>
            <ul class="breadcrumbs">
                <li><a href="../admin/escritorio.php">Home</a></li>
                <li class="divider">></li>
                <li><a href="../medicos/mostrar.php">Listado de los médicos</a></li>
                <li class="divider">></li>
                <li><a href="#" class="active">Información del médico</a></li>
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

<form action="" enctype="multipart/form-data" method="POST"  autocomplete="off" onsubmit="return validacion()">
  <div class="containerss">
    <h1>Información del médico</h1>
   <br>
    <hr>

    <label for="email"><b>Cédula del médico</b></label><span class="badge-warning">*</span>
    <input type="text" placeholder="ejm: 09741478" value="<?php echo $d->ceddoc; ?>" readonly name="cem" maxlength="8" required>

    <label for="psw"><b>Nombre del médico</b></label><span class="badge-warning">*</span>
    <input type="text"  placeholder="ejm: Juan Raul" value="<?php echo $d->nodoc; ?>"  name="named" readonly required>

    <label for="psw"><b>Apellido del médico</b></label><span class="badge-warning">*</span>
    <input type="text" placeholder="ejm: Ramirez Requena" value="<?php echo $d->apdoc; ?>" name="apeme" readonly required>

    <label for="psw"><b>Dirección del médico</b></label><span class="badge-warning">*</span>
    <input type="text" placeholder="ejm: calle los medanos" value="<?php echo $d->direcd; ?>" name="dime" readonly required>

    <label for="psw"><b>Género del médico</b></label><span class="badge-warning">*</span>
    <select required name="geme" readonly id="gep">
        <option value="<?php echo $d->sexd; ?>"><?php echo $d->sexd; ?></option>

    </select>

    <label for="psw"><b>Especialidad del médico</b></label><span class="badge-warning">*</span>
    <select required name="espm" readonly id="espm">
        <option value="<?php echo $d->nomesp; ?>"><?php echo $d->nomesp; ?></option>
        
        
    </select>


    <label for="psw"><b>Teléfono del médico</b></label><span class="badge-warning">*</span>
    <input type="text" value="<?php echo $d->phd; ?>"  maxlength="13" readonly placeholder="ejm: +51 999 888 111" name="telme" required>

    <label for="psw"><b>Fecha de nacimiento del médico</b></label><span class="badge-warning">*</span>
    <input type="date" value="<?php echo $d->nacd; ?>" name="cumme" readonly required>

    <label for="psw"><b>Correo  del médico</b></label><span class="badge-warning">*</span>
    <input type="text" value="<?php echo $d->corr; ?>" name="corr" readonly required>

     <label for="psw"><b>Usuario  del médico</b></label><span class="badge-warning">*</span>
    <input type="text" value="<?php echo $d->username; ?>" name="username" readonly required>

    <hr>
   
   
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
    

   
</body>
</html>


