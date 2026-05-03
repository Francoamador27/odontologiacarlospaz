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
        <!-- NAVBAR -->

        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <h1 class="title">Bienvenido <?php echo '<strong>' . $_SESSION['username'] . '</strong>'; ?></h1>
            <ul class="breadcrumbs">
                <li><a href="../admin/escritorio.php">Home</a></li>
                <li class="divider">></li>
                <li><a href="#" class="active">Historial de los pagos de paciente</a></li>
            </ul>

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
                            <table id="example"
                                class="w-full border-collapse bg-white shadow-md rounded-lg overflow-hidden">
                                <thead class="bg-[#31b0d5] text-white">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">DNI
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                            Paciente</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Sexo
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Grupo
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                            Teléfono</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Estado
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <?php foreach ($data as $d): ?>
                                        <tr class="hover:bg-gray-50">
                                            <th scope="row"
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <?php echo $d->numhs ?></th>
                                            <td data-title="Paciente" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php echo $d->nompa ?>&nbsp;<?php echo $d->apepa ?></td>
                                            <td data-title="Sexo" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php echo $d->sex ?></td>
                                            <td data-title="Grupo" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php echo $d->grup ?></td>
                                            <td data-title="Teléfono" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <a href="tel:<?php echo $d->phon ?>"
                                                    class="text-blue-600 hover:text-blue-800"><?php echo $d->phon ?></a>
                                            </td>
                                            <td data-title="Estado" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" id="<?= $d->idpa ?>" value="<?= $d->state ?>"
                                                        <?= $d->state == '1' ? 'checked' : ''; ?> class="sr-only peer" />
                                                    <div
                                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                    </div>
                                                </label>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a title="Pagos" href="../actividades/pagos.php?id=<?php echo $d->idpa ?>"
                                                    class="text-green-600 hover:text-green-900">
                                                    <i class="fa fa-money"></i>
                                                </a>
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



</body>

</html>