<?php
ob_start();
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
  header('location: ../login.php');

  $id = $_SESSION['id'];
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



    <main>
      <h1 class="title">Bienvenido <?php echo '<strong>' . $_SESSION['username'] . '</strong>'; ?></h1>
      <ul class="breadcrumbs">
        <li><a href="../admin/escritorio.php">Home</a></li>
        <li class="divider">></li>
        <li><a href="../pacientes/mostrar.php">Listado de los pacientes</a></li>
        <li class="divider">></li>
        <li><a href="#" class="active">Actualizar paciente</a></li>
      </ul>

      <!-- multistep form -->
      <?php
      require '../../backend/bd/Conexion.php';
      $id = $_GET['id'];
      $sentencia = $connect->prepare("SELECT * FROM patients  WHERE idpa= '$id';");
      $sentencia->execute();

      $data = array();
      if ($sentencia) {
        while ($r = $sentencia->fetchObject()) {
          $data[] = $r;
        }
      }
      ?>
      <?php if (count($data) > 0): ?>
        <?php foreach ($data as $d): ?>

          <form action="" enctype="multipart/form-data" method="POST" autocomplete="off" onsubmit="return validacion()"
            class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg p-6">
            <div class="space-y-6">
              <div class="text-center">
                <h1 class="text-2xl font-bold text-gray-800">Actualizar pacientes</h1>
                <?php include_once '../../backend/php/upd_patiens.php' ?>
              </div>

              <div class="border-b border-gray-200 my-4"></div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                  <div>
                    <label for="nhi" class="block text-sm font-medium text-gray-700">DNI del paciente <span
                        class="text-red-500 text-xs font-bold">*</span></label>
                    <input type="text" placeholder="ejm: ASCS855CS74" value="<?php echo $d->numhs; ?>" name="nhi"
                      maxlength="8" required
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <input type="hidden" name="pid" value="<?php echo $d->idpa; ?>">
                  </div>

                  <div>
                    <label for="namp" class="block text-sm font-medium text-gray-700">Nombre del paciente <span
                        class="text-red-500 text-xs font-bold">*</span></label>
                    <input type="text" placeholder="ejm: Juan Raul" name="namp" value="<?php echo $d->nompa; ?>" required
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                  </div>

                  <div>
                    <label for="apep" class="block text-sm font-medium text-gray-700">Apellido del paciente <span
                        class="text-red-500 text-xs font-bold">*</span></label>
                    <input type="text" placeholder="ejm: Ramirez Requena" value="<?php echo $d->apepa; ?>" name="apep"
                      required
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                  </div>

                  <div>
                    <label for="dip" class="block text-sm font-medium text-gray-700">Dirección del paciente <span
                        class="text-red-500 text-xs font-bold">*</span></label>
                    <input type="text" placeholder="ejm: calle los medanos" value="<?php echo $d->direc; ?>" name="dip"
                      required
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                  </div>

                  <div>
                    <label for="gep" class="block text-sm font-medium text-gray-700">Género del paciente <span
                        class="text-red-500 text-xs font-bold">*</span></label>
                    <select required name="gep" id="gep"
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                      <option value="<?php echo $d->sex; ?>"><?php echo $d->sex; ?></option>
                      <option>----------------------</option>
                      <option value="Masculino">Masculino</option>
                      <option value="Femenino">Femenino</option>
                    </select>
                  </div>
                </div>

                <div class="space-y-4">
                  <div>
                    <label for="grp" class="block text-sm font-medium text-gray-700">Grupo sanguíneo del paciente <span
                        class="text-red-500 text-xs font-bold">*</span></label>
                    <select required name="grp" id="grp"
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                      <option value="<?php echo $d->grup; ?>"><?php echo $d->grup; ?></option>
                      <option>-----------------------</option>
                      <option value="A+">A+</option>
                      <option value="O-">O-</option>
                    </select>
                  </div>

                  <div>
                    <label for="telp" class="block text-sm font-medium text-gray-700">Teléfono del paciente <span
                        class="text-red-500 text-xs font-bold">*</span></label>
                    <input type="text" maxlength="25" value="<?php echo $d->phon; ?>" placeholder="ejm: +51 999 888 111"
                      name="telp" required
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                  </div>

                  <div>
                    <label for="cump" class="block text-sm font-medium text-gray-700">Fecha de nacimiento del paciente <span
                        class="text-red-500 text-xs font-bold">*</span></label>
                    <input type="date" value="<?php echo $d->cump; ?>" name="cump" required
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                  </div>

                  <div>
                    <label for="email_p" class="block text-sm font-medium text-gray-700">Correo del paciente <span
                        class="text-red-500 text-xs font-bold">*</span></label>
                    <input type="text" value="<?php echo $d->email_p; ?>" name="email_p" required
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                  </div>
                </div>
              </div>

              <div class="border-t border-gray-200 pt-5 mt-6">
                <button type="submit" name="upd_patiens"
                  class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                  Guardar
                </button>
              </div>
            </div>
          </form> <?php endforeach; ?>

      <?php else: ?>
        <p class="alert alert-warning">No hay datos</p>
      <?php endif; ?>

    </main>
    <!-- MAIN -->
  </section>
  <script src="../../backend/js/jquery.min.js"></script>


  <!-- NAVBAR -->

  <script src="../../backend/js/script.js"></script>
  <script src="../../backend/js/multistep.js"></script>



  <script type="text/javascript">
    let popUp = document.getElementById("cookiePopup");
    //When user clicks the accept button
    document.getElementById("acceptCookie").addEventListener("click", () => {
      //Create date object
      let d = new Date();
      //Increment the current time by 1 minute (cookie will expire after 1 minute)
      d.setMinutes(2 + d.getMinutes());
      //Create Cookie withname = myCookieName, value = thisIsMyCookie and expiry time=1 minute
      document.cookie = "myCookieName=thisIsMyCookie; expires = " + d + ";";
      //Hide the popup
      popUp.classList.add("hide");
      popUp.classList.remove("shows");
    });
    //Check if cookie is already present
    const checkCookie = () => {
      //Read the cookie and split on "="
      let input = document.cookie.split("=");
      //Check for our cookie
      if (input[0] == "myCookieName") {
        //Hide the popup
        popUp.classList.add("hide");
        popUp.classList.remove("shows");
      } else {
        //Show the popup
        popUp.classList.add("shows");
        popUp.classList.remove("hide");
      }
    };
    //Check if cookie exists when page loads
    window.onload = () => {
      setTimeout(() => {
        checkCookie();
      }, 2000);
    };
  </script>

</body>

</html>