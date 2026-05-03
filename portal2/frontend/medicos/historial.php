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
    <?php include('../componentes/sidebar.php') ?>
    
    <!-- SIDEBAR -->
\
    <!-- SIDEBAR -->

    <!-- NAVBAR -->
    <section id="content">


        <!-- MAIN -->
        <main>
            <h1 class="title">Bienvenido <?php echo '<strong>'.$_SESSION['username'].'</strong>'; ?></h1>
            <ul class="breadcrumbs">
                <li><a href="../admin/escritorio.php">Home</a></li>
                <li class="divider">></li>
                <li><a href="#" class="active">Historial de los médicos</a></li>
            </ul>
            
          <div class="data">
                <div class="content-data">
                    <div class="head">
                        <h3>Médicos</h3>
                       
                    </div>
                   <div class="table-responsive" style="overflow-x:auto;">
                       <?php 
require '../../backend/bd/Conexion.php';
$sentencia = $connect->prepare("SELECT * FROM doctor ORDER BY idodc DESC;");
 $sentencia->execute();
$data =  array();
if($sentencia){
  while($r = $sentencia->fetchObject()){
    $data[] = $r;
  }
}
     ?>
     <?php if(count($data)>0):?>
         <table id="example" class="responsive-table">
            <thead>
                <tr>
                    <th scope="col">Cédula</th>
                    <th scope="col">Doctor</th>
                    <th scope="col">Sexo</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $d):?>
                    <tr>
                        <th scope="row"><?php echo $d->ceddoc ?></th>
                        <td data-title="Doctor"><?php echo $d->nodoc ?>&nbsp;<?php echo $d->apdoc ?></td>
                        
                        <td data-title="Sexo"><?php echo $d->sexd ?></td>
                        <td data-title="Teléfono"><?php echo $d->phd ?></td>
                        

                        <td data-title="Estado">
    
                        <label class="switch">
                          <input type="checkbox" id="<?=$d->idodc?>" value="<?=$d->state ?>" <?=$d->state == '1' ? 'checked' : '' ;?>/> 

                          <span class="slider"></span>
                        </label>
                        </td>

                        <td>
                           
                            <a title="Información" href="../medicos/info.php?id=<?php echo $d->idodc ?>" class="fa fa-info"></a>
                            
        
                        </td>
                    </tr>
                    <?php endforeach; ?>
            </tbody>
         </table> 
         <?php else:?>
  
    <div class="alert">
      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
      <strong>Danger!</strong> No hay datos.
    </div>
    <?php endif; ?>
                    </div>
                </div>
            </div>  

        </main>
        <!-- MAIN -->
    </section>
    <?php include_once '../../backend/php/delete_doctor.php' ?>
    <!-- NAVBAR -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-3.5.1.js"></script>
     
    <script src="../../backend/js/script.js"></script>
    
    <!-- Data Tables -->
    <script type="text/javascript" src="../../backend/js/datatable.js"></script>
    <script type="text/javascript" src="../../backend/js/datatablebuttons.js"></script>
    <script type="text/javascript" src="../../backend/js/jszip.js"></script>
    <script type="text/javascript" src="../../backend/js/pdfmake.js"></script>
    <script type="text/javascript" src="../../backend/js/vfs_fonts.js"></script>
    <script type="text/javascript" src="../../backend/js/buttonshtml5.js"></script>
    <script type="text/javascript" src="../../backend/js/buttonsprint.js"></script>
    <script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
    </script>



 
</body>
</html>


