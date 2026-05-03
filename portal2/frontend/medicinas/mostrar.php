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
                <li><a href="#" class="active">Listado de medicinas</a></li>
            </ul>
            <button class="button" onclick="location.href='nuevo.php'">Nuevo</button>
            <div class="data">
                <div class="content-data">
                    <div class="head">
                        <h3>Medicinas</h3>


                    </div>
                    <div class="table-responsive" style="overflow-x:auto;">
                        <?php
                        require '../../backend/bd/Conexion.php';
                        $sentencia = $connect->prepare("SELECT product.idprcd, product.codpro, product.nompro, category.idcat, category.nomcat, product.preprd, product.stock, product.state, product.fere FROM product INNER JOIN category ON product.idcat = category.idcat ORDER BY idprcd DESC;");
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

                                        <th scope="col">Código</th>
                                        <th scope="col">Medicinas</th>
                                        <th scope="col">Categorias</th>
                                        <th scope="col">Stock</th>
                                        <th scope="col">Foto</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $d): ?>
                                        <tr>
                                            <th scope="row"><?php echo $d->codpro ?></th>
                                            <td data-title="Medicina"><?php echo $d->nompro ?></td>
                                            <td data-title="Categorias"><?php echo $d->nomcat ?></td>
                                            <td data-title="Stock"><?php echo $d->stock ?></td>
                                            <td data-title="Foto"><img src="../../backend/img/medicine.svg"></td>

                                            <td data-title="Estado">

                                                <label class="switch">
                                                    <input type="checkbox" id="<?= $d->idprcd ?>" value="<?= $d->state ?>"
                                                        <?= $d->state == '1' ? 'checked' : ''; ?> />

                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <a title="Actualizar" href="../medicinas/editar.php?id=<?php echo $d->idprcd ?>"
                                                    class="fa fa-pencil tooltip"></a>
                                                <a title="Información" href="../medicinas/info.php?id=<?php echo $d->idprcd ?>"
                                                    class="fa fa-info"></a>

                                                <a title="Stock" href="../medicinas/stock.php?id=<?php echo $d->idprcd ?>"
                                                    class="fa fa-tag"></a>


                                                <form onsubmit="return confirm('Realmente desea eliminar el registro?');"
                                                    method='POST' action='<?php $_SERVER['PHP_SELF'] ?>'>
                                                    <input type='hidden' name='idprcd' value="<?php echo $d->idprcd; ?>">

                                                    <button name='delete_medicine' style="cursor: pointer;"
                                                        class="fa fa-trash"></button>
                                                </form>


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
    <?php include_once '../../backend/php/delete_medicine.php' ?>
</body>

</html>