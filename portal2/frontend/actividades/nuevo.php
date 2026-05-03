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
                <li><a href="../actividades/mostrar.php">Listado de pago</a></li>
                <li class="divider">></li>
                <li><a href="#" class="active">Nueva gasto</a></li>
            </ul>

            <!-- multistep form -->
            <?php include '../componentes/comp_gastos.php'; ?>


        </main>
        <!-- MAIN -->
    </section>
    <script src="../../backend/js/jquery.min.js"></script>


    <!-- NAVBAR -->

    <script src="../../backend/js/script.js"></script>
    <script src="../../backend/js/multistep.js"></script>
    <script src="../../backend/js/vpat.js"></script>
    <script src="../../backend/js/patiens.js"></script>
    <script src="../../backend/js/doctor.js"></script>
    <script src="../../backend/js/laboratory.js"></script>
    <script>
    </script>
</body>

</html>