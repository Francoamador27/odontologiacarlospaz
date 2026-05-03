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
                <li><a href="mostrar.php">Listado de las medicinas</a></li>
                <li class="divider">></li>
                <li><a href="#" class="active">Nuevas medicinas</a></li>
            </ul>

            <form action="" enctype="multipart/form-data" method="POST" autocomplete="off"
                onsubmit="return validacion()">
                <div class="containerss">
                    <h1>Nueva medicinas</h1>

                    <div class="alert-danger">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <strong>Importante!</strong> Es importante rellenar los campos con &nbsp;<span
                            class="badge-warning">*</span>
                    </div>
                    <hr>
                    <br>
                    <label for="email"><b>Código de la medicina</b></label><span class="badge-warning">*</span>
                    <input type="text" placeholder="ejm:  877578VNRB4" maxlength="14" name="medicode" required>

                    <label for="email"><b>Nombre de la medicina</b></label><span class="badge-warning">*</span>
                    <input type="text" placeholder="ejm:  PRADAXA 75 MG X 30 CÁPSULAS" name="mediname" required>

                    <label for="psw"><b>Categoria de la medicina</b></label><span class="badge-warning">*</span>
                    <select required name="medicate" id="cat">
                        <option>Seleccione</option>

                    </select>

                    <label for="email"><b>Precio de la medicina</b></label><span class="badge-warning">*</span>
                    <input type="text" placeholder="ejm: 25.90" name="mediprec"
                        onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required>

                    <label for="email"><b>Stock de la medicina</b></label><span class="badge-warning">*</span>
                    <input type="text" placeholder="ejm: 90" name="medistoc" maxlength="3"
                        onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required>

                    <hr>

                    <button type="submit" name="add_medicine" class="registerbtn">Guardar</button>
                </div>

            </form>

        </main>
        <!-- MAIN -->
    </section>

    <!-- NAVBAR -->
    <script src="../../backend/js/jquery.min.js"></script>
    <script src="../../backend/js/cat.js"></script>
    <script src="../../backend/js/script.js"></script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php include_once '../../backend/php/add_medicine.php' ?>
</body>

</html>