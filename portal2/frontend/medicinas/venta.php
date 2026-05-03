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

    <?php include('../componentes/sidebar.php') ?>


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
                <li><a href="#" class="active">Venta de medicinas</a></li>
            </ul>
            <button class="button" onclick="location.href='new_sale.php'">Nueva venta</button>
            <div class="data">
                <div class="content-data">
                    <div class="head">
                        <h3>Venta de medicinas</h3>


                    </div>
                    <div class="table-responsive" style="overflow-x:auto;">
                        <?php
                        require '../../backend/bd/Conexion.php';
                        $sentencia = $connect->prepare("SELECT * FROM orders ORDER BY idord DESC;");
                        $sentencia->execute();
                        $data = array();
                        if ($sentencia) {
                            while ($r = $sentencia->fetchObject()) {
                                $data[] = $r;
                            }
                        }
                        ?>
                        <?php if (count($data) > 0): ?>
                            <table id="example" class="responsive-table">
                                <thead>
                                    <tr>

                                        <th scope="col">Comprobante</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Cliente</th>
                                        <th scope="col">Medicinas</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $d): ?>
                                        <tr>
                                            <th scope="row"><?php echo $d->tipc ?></th>
                                            <td data-title="Fecha"><?php echo $d->placed_on ?></td>
                                            <td data-title="Total"> <?php echo number_format($d->total_price, 2); ?></td>

                                            <td data-title="Cliente"><?php echo $d->nomcl ?></td>
                                            <td data-title="Medicinas"><?php echo $d->total_products ?></td>

                                            <td data-title="Estado">

                                                <label class="switch">
                                                    <input type="checkbox" id="<?= $d->idord ?>" value="<?= $d->payment_status ?>"
                                                        <?= $d->payment_status == 'Aceptado' ? 'checked' : ''; ?> />

                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <?php
                                                if ($d->tipc = 'Boleta') {
                                                    echo '<a title="Boleta"  href="../medicinas/documento.php?id=' . $d->idord . '" class="fa fa-file-text-o"></a>';
                                                } else {

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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

</body>

</html>