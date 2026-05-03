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



        <!-- MAIN -->

        <main>


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
                    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                        <!-- Encabezado -->
                        <div class="bg-[#31b0d5] p-4">
                            <h1 class="text-xl md:text-2xl font-bold text-white">Información del paciente</h1>
                        </div>

                        <!-- Contenido principal -->
                        <div class="p-6">
                            <!-- Sección de información personal -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div class="space-y-4">
                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-700 border-b border-gray-200 pb-1 mb-2">Datos
                                            personales</h2>

                                        <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                                            <div class="text-sm text-gray-500">DNI:</div>
                                            <div class="text-sm font-medium"><?php echo $d->numhs; ?></div>

                                            <div class="text-sm text-gray-500">Nombre:</div>
                                            <div class="text-sm font-medium"><?php echo $d->nompa; ?></div>

                                            <div class="text-sm text-gray-500">Apellido:</div>
                                            <div class="text-sm font-medium"><?php echo $d->apepa; ?></div>

                                            <div class="text-sm text-gray-500">Género:</div>
                                            <div class="text-sm font-medium"><?php echo $d->sex; ?></div>
                                        </div>
                                    </div>

                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-700 border-b border-gray-200 pb-1 mb-2">
                                            Información médica</h2>

                                        <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                                            <div class="text-sm text-gray-500">Grupo sanguíneo:</div>
                                            <div class="text-sm font-medium"><?php echo $d->grup; ?></div>

                                            <div class="text-sm text-gray-500">Fecha de nacimiento:</div>
                                            <div class="text-sm font-medium"><?php echo $d->cump; ?></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-700 border-b border-gray-200 pb-1 mb-2">
                                            Información de contacto</h2>

                                        <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                                            <div class="text-sm text-gray-500">Dirección:</div>
                                            <div class="text-sm font-medium"><?php echo $d->direc; ?></div>

                                            <div class="text-sm text-gray-500">Teléfono:</div>
                                            <div class="text-sm font-medium"><?php echo $d->phon; ?></div>

                                            <div class="text-sm text-gray-500">Correo electrónico:</div>
                                            <div class="text-sm font-medium"><?php echo $d->email_p; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones de acción (opcional) -->
                            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-100">
                                <button
                                    class="px-4 py-2 bg-blue-100 text-blue-600 rounded hover:bg-blue-200 transition duration-300">
                                    Imprimir
                                </button>
                                <a
                                    class="px-4 py-2 bg-[#31b0d5] text-white rounded hover:bg-blue-700 transition duration-300" href="editar.php?id=<?php echo $d->idpa; ?>">
                                    Editar información
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php else: ?>
                <p class="alert alert-warning">No hay datos</p>
            <?php endif; ?>
        </main>
        <!-- MAIN -->
    </section>
    <script src="../../backend/js/jquery.min.js"></script>
    <script src="../../backend/js/script.js"></script>



</body>

</html>