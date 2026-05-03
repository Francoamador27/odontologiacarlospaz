<style>
  .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
  }

  .modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
  }

  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }

  .modal-content {
    display: block;
    background: white;
    width: 360px !important;
    min-height: 322px;
    margin: 85px auto !important;
    padding: 20px;
    border: 1px solid #888;
    padding: 73px 10px;
  }
</style>
<?php
ob_start();
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
  header('location: ../login.php');

  $id = $_SESSION['id'];
}
?>
<?php
require_once('../../backend/bd/Conexion.php');
$req = $connect->prepare("SELECT * FROM events");
$req->execute();
$events = $req->fetchAll();
?>



<?php include('../componentes/header.php') ?>

<body>

  <!-- SIDEBAR -->
  <?php include('../componentes/sidebar.php') ?>

  <!-- SIDEBAR -->

  <!-- NAVBAR -->
  <section id="content">

    <main>
      <h1 class="title">Bienvenido <?php echo '<strong>' . $_SESSION['username'] . '</strong>'; ?></h1>
      <ul class="breadcrumbs">
        <li><a href="escritorio.php">Home</a></li>
        <li class="divider">/</li>
        <li><a href="#" class="active">Dashboard</a></li>
      </ul>
      <?php include('../componentes/calendario_citas.php') ?>
      <div class="info-data">
        <?php include('../componentes/grafico_gastos.php') ?>



      </div>

      <div class="data">
        <div class="content-data">
          <div class="table-responsive" style="overflow-x:auto;">
            <?php

            $sentencia = $connect->prepare("SELECT * FROM doctor ORDER BY idodc DESC LIMIT 10;");
            $sentencia->execute();
            $data = array();
            if ($sentencia) {
              while ($r = $sentencia->fetchObject()) {
                $data[] = $r;
              }
            }
            ?>
            <?php if (count($data) > 0): ?>
              <table id="example" class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden shadow-lg">
                <div>
                  <?php
                  $sql = "SELECT COUNT(*) total FROM doctor";
                  $result = $connect->query($sql); //$pdo sería el objeto conexión
                  $total = $result->fetchColumn();
                  ?>
                  <h2 class="text-xl font-semibold text-gray-800 py-4">Total de médicos: <?php echo $total; ?></h2>
                </div>

                <div class="head-medicos">
                  <p class="text-2xl font-semibold text-gray-700">Nuevos médicos</p>
                </div>

                <thead class="bg-[#31b0d5] text-white">
                  <tr>
                    <th class="py-3 px-6 text-left text-sm font-semibold uppercase">Doctor</th>
                    <th class="py-3 px-6 text-left text-sm font-semibold uppercase">Especialidad</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($data as $d): ?>
                    <tr class="hover:bg-[#f1f9fb] transition-colors duration-300">
                      <td class="py-4 px-6 border-t border-gray-200 text-gray-800">
                        <?php echo $d->nodoc ?>&nbsp;<?php echo $d->apdoc ?>
                      </td>
                      <td class="py-4 px-6 border-t border-gray-200 text-gray-600"><?php echo $d->nomesp ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>

            <?php else: ?>

              <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                <strong>Danger!</strong> No hay datos.
              </div>
            <?php endif; ?>


          </div>

        </div>

        <div class="content-data">

          <div class="table-responsive" style="overflow-x:auto;">
            <?php

            $sentencia = $connect->prepare("SELECT * FROM patients ORDER BY idpa DESC LIMIT 10;");
            $sentencia->execute();
            $data = array();
            if ($sentencia) {
              while ($r = $sentencia->fetchObject()) {
                $data[] = $r;
              }
            }
            ?>
            <?php if (count($data) > 0): ?>
              <table id="example" class="w-full border-collapse bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-4 bg-gray-50 border-b">
                  <?php
                  $sql = "SELECT COUNT(*) total FROM patients";
                  $result = $connect->query($sql);
                  $total = $result->fetchColumn();
                  ?>
                  <h2 class="text-xl font-semibold text-gray-800">Total de pacientes: <span
                      class="font-bold"><?php echo $total; ?></span></h2>
                </div>
                <thead>
                  <tr>
                    <th scope="col" class="px-6 py-4 bg-[#31b0d5] text-white font-semibold text-left">Nuevos pacientes
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($data as $d): ?>
                    <tr class="border-b hover:bg-gray-50 transition-colors">
                      <td data-title="Paciente" class="px-6 py-4"><?php echo $d->nompa ?>&nbsp;<?php echo $d->apepa ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php else: ?>

              <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                <strong>Danger!</strong> No hay datos.
              </div>



            <?php endif; ?>


          </div>
        </div>
      </div>

    </main>



  </section>




  </div>

  <!-- FullCalendar -->
  <script src='../../backend/js/moment.min.js'></script>
  <script src='../../backend/js/fullcalendar/fullcalendar.min.js'></script>
  <script src='../../backend/js/fullcalendar/fullcalendar.js'></script>
  <script src='../../backend/js/fullcalendar/locale/es.js'></script>



</body>

</html>


<script src="../../backend/js/script.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
  integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
  integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>