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
<style>
    td{
        border: none !important;
    }
    tr{
        border: none !important;
    }
</style>
<?php include('../componentes/header.php') ?>


<body>
    <?php include('../componentes/sidebar.php') ?>

    <!-- SIDEBAR -->

    <!-- NAVBAR -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu toggle-sidebar'></i>
            <form action="#">
                <div class="form-group">
                    <input type="text" placeholder="Search...">
                    <i class='bx bx-search icon'></i>
                </div>
            </form>


            <span class="divider"></span>
            <div class="profile">
                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8cGVvcGxlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
                    alt="">
                <ul class="profile-link">
                    <li><a href="../profile/mostrar.php"><i class='bx bxs-user-circle icon'></i> Profile</a></li>

                    <li>
                        <a href="../salir.php"><i class='bx bxs-log-out-circle'></i> Logout</a>
                    </li>

                </ul>
            </div>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <h1 class="title">Bienvenido <?php echo '<strong>' . $_SESSION['username'] . '</strong>'; ?></h1>
            <ul class="breadcrumbs">
                <li><a href="../admin/escritorio.php">Home</a></li>
                <li class="divider">></li>
                <li><a href="#" class="active">Listado de los médicos</a></li>
            </ul>
            <button class="button" onclick="location.href='nuevo.php'">Nuevo</button>
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
                        $data = array();
                        if ($sentencia) {
                            while ($r = $sentencia->fetchObject()) {
                                $data[] = $r;
                            }
                        }
                        ?>
                        <?php if (count($data) > 0): ?>
                            <table id="example"
                                class="responsive-table w-full border-collapse bg-white shadow-lg rounded-lg overflow-hidden">
                                <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left text-sm font-medium">Cédula</th>
                                        <th scope="col" class="px-4 py-3 text-left text-sm font-medium">Doctor</th>
                                        <th scope="col" class="px-4 py-3 text-left text-sm font-medium">Sexo</th>
                                        <th scope="col" class="px-4 py-3 text-left text-sm font-medium">Teléfono</th>
                                        <th scope="col" class="px-4 py-3 text-left text-sm font-medium">Estado</th>
                                        <th scope="col" class="px-4 py-3 text-left text-sm font-medium">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $d): ?>
                                        <tr
                                            class="border-b border-gray-200 hover:bg-blue-50 transition-colors duration-200 even:bg-gray-50">
                                            <th scope="row" class="px-4 py-3 text-sm font-medium text-gray-900">
                                                <?php echo $d->ceddoc ?></th>
                                            <td data-title="Doctor" class="px-4 py-3 text-sm text-gray-700">
                                                <?php echo $d->nodoc ?>&nbsp;<?php echo $d->apdoc ?></td>
                                            <td data-title="Sexo" class="px-4 py-3 text-sm text-gray-700"><?php echo $d->sexd ?>
                                            </td>
                                            <td data-title="Teléfono" class="px-4 py-3 text-sm text-gray-700">
                                                <?php echo $d->phd ?></td>

                                            <td data-title="Estado" class="px-4 py-3 text-sm">
                                                <label class="switch relative inline-block w-12 h-6">
                                                    <input type="checkbox" id="<?= $d->idodc ?>" value="<?= $d->state ?>"
                                                        <?= $d->state == '1' ? 'checked' : ''; ?> class="opacity-0 w-0 h-0" />
                                                    <span
                                                        class="slider absolute cursor-pointer inset-0 bg-gray-300 rounded-full transition-all duration-300 before:absolute before:h-5 before:w-5 before:left-0.5 before:bottom-0.5 before:bg-white before:rounded-full before:transition-all before:duration-300 before:shadow-md checked:bg-blue-600 checked:before:translate-x-6"></span>
                                                </label>
                                            </td>

                                            <td class="px-4 py-3 text-sm">
                                                <a title="Actualizar" href="../medicos/editar.php?id=<?php echo $d->idodc ?>"
                                                    class="inline-flex items-center justify-center w-8 h-8 mr-1 text-blue-600 bg-blue-100 rounded-full hover:bg-blue-200 transition-colors">
                                                    <i class="bx bx-pencil text-lg"></i>
                                                </a>
                                                <a title="Información" href="../medicos/info.php?id=<?php echo $d->idodc ?>"
                                                    class="inline-flex items-center justify-center w-8 h-8 mr-1 text-blue-600 bg-blue-100 rounded-full hover:bg-blue-200 transition-colors">
                                                    <i class="bx bx-info-circle text-lg"></i>
                                                </a>

                                                <?php if (isset($_GET['error'])) { ?>
                                                    <script>
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Oops...',
                                                            text: "<?php echo addslashes($_GET['error']); ?>"
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                window.location = "mostrar.php";
                                                            }
                                                        });
                                                    </script>
                                                <?php } ?>
                                                <?php if (isset($_GET['success'])) { ?>
                                                    <script>
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Exito',
                                                            text: "<?php echo addslashes($_GET['success']); ?>"
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                window.location = "mostrar.php";
                                                            }
                                                        });
                                                    </script>
                                                <?php } ?>

                                                <form onsubmit="return confirm('Realmente desea eliminar el registro?');"
                                                    method="POST" action='<?php $_SERVER['PHP_SELF'] ?>' class="inline">
                                                    <input type="hidden" name="idodc" value="<?php echo $d->idodc; ?>">
                                                    <button name="delete_doctor" style="cursor: pointer;"
                                                        class="inline-flex items-center justify-center w-8 h-8 mr-1 text-red-600 bg-red-100 rounded-full hover:bg-red-200 transition-colors">
                                                        <i class="bx bx-trash text-lg"></i>
                                                    </button>
                                                </form>

                                                <?php
                                                if ($d->rol == '3') {
                                                    // code...
                                                    echo '<a title="Cambiar contraseña" href="../medicos/password.php?id=' . $d->idodc . '" class="inline-flex items-center justify-center w-8 h-8 mr-1 text-yellow-600 bg-yellow-100 rounded-full hover:bg-yellow-200 transition-colors"><i class="bx bx-key text-lg"></i></a>';
                                                } else {
                                                    echo '<a title="Crear perfil" href="../medicos/crear.php?id=' . $d->idodc . '" class="inline-flex items-center justify-center w-8 h-8 mr-1 text-green-600 bg-green-100 rounded-full hover:bg-green-200 transition-colors"><i class="bx bx-user-plus text-lg"></i></a>';
                                                }
                                                ?>
                                            </td>
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
        <!-- MAIN -->
    </section>
    <?php include_once '../../backend/php/delete_doctor.php' ?>
    <!-- NAVBAR -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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