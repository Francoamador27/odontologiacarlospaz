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
        <li><a href="#" class="active">Listado de los pacientes</a></li>
      </ul>
      <button class="button" onclick="location.href='nuevo.php'">Nuevo</button>
      <div class="data">
        <div class="content-data">
          <div class="head">
            <h3>Pacientes</h3>

          </div>
          <div class="table-responsive" style="overflow-x:auto;">
            <?php
            require '../../backend/bd/Conexion.php';
            $sentencia = $connect->prepare("SELECT * FROM patients ORDER BY idpa DESC;");
            $sentencia->execute();
            $data = array();
            if ($sentencia) {
              while ($r = $sentencia->fetchObject()) {
                $data[] = $r;
              }
            }
            ?>
            <?php if (count($data) > 0): ?>
              <div class="overflow-x-auto shadow-md rounded-lg">
                <table id="example" class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-[#31b0d5] text-white">
                    <tr>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">DNI</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Paciente
                      </th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Sexo</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Grupo</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Teléfono
                      </th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Estado</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Acciones
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($data as $d): ?>
                      <tr class="hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                          <?php echo $d->numhs ?>
                        </th>
                        <td data-title="Paciente" class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 capitalize">
                          <?php echo $d->nompa ?>&nbsp;<?php echo $d->apepa ?>
                        </td>
                        <td data-title="Sexo" class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                          <?php echo $d->sex ?>
                        </td>
                        <td data-title="Grupo" class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                          <?php echo $d->grup ?>
                        </td>
                        <td data-title="Teléfono" class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                          <a href="tel:<?php echo $d->phon ?>"
                            class="text-[#31b0d5] hover:underline"><?php echo $d->phon ?></a>
                        </td>
                        <td data-title="Estado" class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                          <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="<?= $d->idpa ?>" value="<?= $d->state ?>" <?= $d->state == '1' ? 'checked' : ''; ?> class="sr-only peer">
                            <div
                              class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#31b0d5]">
                            </div>
                          </label>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                          <div class="flex space-x-2 items-center">
                            <a title="Actualizar" href="../pacientes/editar.php?id=<?php echo $d->idpa ?>"
                              class="text-blue-600 hover:text-blue-900">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                              </svg>
                            </a>
                            <a title="Información" href="../pacientes/info.php?id=<?php echo $d->idpa ?>"
                              class="text-green-600 hover:text-green-900">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                              </svg>
                            </a>
                            <a title="Historial médico" href="../pacientes/historia.php?id=<?php echo $d->idpa ?>"
                              class="text-[#31b0d5] hover:text-[#2b9ec1]">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                              </svg>
                            </a>
                            <a title="Pagos" href="../pacientes/pago.php?id=<?php echo $d->idpa ?>"
                              class="text-yellow-600 hover:text-yellow-900">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                              </svg>
                            </a>
                            <form onsubmit="return confirm('Realmente desea eliminar el registro?');" method='POST'
                              action='<?php $_SERVER['PHP_SELF'] ?>' class="inline-block">
                              <input type='hidden' name='idpa' value="<?php echo $d->idpa; ?>">
                              <button name='delete_patients' type="submit" class="text-red-600 hover:text-red-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                  stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                              </button>
                              <!-- // if ($d->rol == '2') {
                              // // code...
                              // echo '<a title="Cambiar contraseña" href="../pacientes/password.php?id=' . $d->idpa . '"
                                class="fa fa-key"></a>';
                              // } else {
                               // echo '<a title="Crear perfil" href="../pacientes/crear.php?id=' . $d->idpa . '"
                                class="fa fa-user-plus"></a>'; -->
                              <!-- } -->

                              <!-- ?> -->
                            </form>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>

              <!-- Estilos para hacer la tabla responsive en dispositivos móviles -->
              <style>
                @media (max-width: 768px) {
                  #example thead {
                    display: none;
                  }

                  #example tbody tr {
                    display: block;
                    margin-bottom: 1rem;
                    border: 1px solid rgba(209, 213, 219, 1);
                    border-radius: 0.5rem;
                  }

                  #example tbody tr td,
                  #example tbody tr th {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 0.75rem 1rem;
                    text-align: right;
                    border-bottom: 1px solid rgba(229, 231, 235, 1);
                  }

                  #example tbody tr td:last-child,
                  #example tbody tr th:last-child {
                    border-bottom: none;
                  }

                  #example tbody tr td::before,
                  #example tbody tr th::before {
                    content: attr(data-title);
                    font-weight: 600;
                    float: left;
                    color: rgba(107, 114, 128, 1);
                  }

                  #example tbody tr td[data-title="Acciones"]::before {
                    align-self: flex-start;
                    margin-top: 0.25rem;
                  }

                  #example tbody tr td[data-title="Acciones"] div {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 0.5rem;
                    justify-content: flex-end;
                  }
                }
              </style>
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
    <!-- MAIN -->
  </section>
  <?php include_once '../../backend/php/delete_patients.php' ?>
  <!-- NAVBAR -->
  <script src="../../backend/js/jquery.min.js"></script>

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
    $(document).ready(function () {
      $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
    });
  </script>

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