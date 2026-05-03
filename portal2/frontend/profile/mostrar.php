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
                <li><a href="#" class="active">Mi perfil</a></li>
            </ul>
            <?php
            require_once('../../backend/bd/Conexion.php');
            $sentencia = $connect->prepare("SELECT * FROM users;");
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
                    <form action="" enctype="multipart/form-data" method="POST" autocomplete="off"
                        onsubmit="return validacion()">
                        <div class="containerss">
                            <h1>Mi perfil</h1>

                            <hr>
                            <br>

                            <label for="email"><b>Usuario del perfil</b></label><span class="badge-warning">*</span>
                            <input type="text" value="<?php echo $d->username ?>" placeholder="ejm: admin01" name="prouser"
                                required>
                            <input type="hidden" name="proid" value="<?php echo $d->id ?>">

                            <label for="email"><b>Nombre del perfil</b></label><span class="badge-warning">*</span>
                            <input type="text" value="<?php echo $d->name ?>" placeholder="ejm: admin" name="proname" required>

                            <label for="email"><b>Correo del perfil</b></label><span class="badge-warning">*</span>
                            <input type="text" value="<?php echo $d->email ?>" placeholder="ejm: admin@gmail.com" name="proema"
                                required>



                            <hr>

                            <button type="submit" name="upd_profile" class="registerbtn">Guardar</button>
                        </div>
                    </form>
                <?php endforeach; ?>
            <?php else: ?>

                <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <strong>Danger!</strong> No hay datos.
                </div>
            <?php endif; ?>


            <div class="content-data">
                <?php

                $sentencia = $connect->prepare("SELECT * FROM users;");
                $sentencia->execute();
                $data = array();
                if ($sentencia) {
                    while ($r = $sentencia->fetchObject()) {
                        $data[] = $r;
                    }
                }
                ?>
                <?php if (count($data) > 0): ?>
                    <?php foreach ($data as $e): ?>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="containerss">
                                <h1>Actualizar contraseña</h1>
                                <br>
                                <label for="email"><b>Nueva contraseña</b></label><span class="badge-warning">*</span>
                                <input type="password" placeholder="ejm: ******" name="newpass" required>
                                <input type="hidden" name="newid" value="<?php echo $d->id ?>">
                            </div>
                            <hr>

                            <button type="submit" name="upd_profile_pass" class="registerbtn">Guardar</button>
                        </form>
                    <?php endforeach; ?>
                <?php else: ?>

                    <div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <strong>Danger!</strong> No hay datos.
                    </div>
                <?php endif; ?>
            </div>

        </main>
        <!-- MAIN -->
    </section>

    <!-- NAVBAR -->
    <script src="../../backend/js/jquery.min.js"></script>

    <script src="../../backend/js/script.js"></script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php include_once '../../backend/php/upd_profile.php' ?>
    <?php include_once '../../backend/php/upd_pass.php' ?>
</body>

</html>