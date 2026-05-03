<?php
ob_start();
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('location: ../login.php');

    $id = $_SESSION['id'];
}
?>
<style>
    .actualizar-cita {
        position: relative;
        transition: all 0.3s ease-in-out;
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
        padding-block: 0.5rem;
        background-color: rgb(0 107 179);
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffff;
        font-weight: bold;
        border: 3px solid #ffffff4d;
        outline: none;
        overflow: hidden;
        font-size: 15px;
        cursor: pointer;
        margin-top: 20px;
        padding: 10px 17px;
    }

    .icon {
        width: 24px;
        height: 24px;
        transition: all 0.3s ease-in-out;
    }

    .actualizar-cita:hover {
        transform: scale(1.05);
        border-color: #fff9;
    }

    .actualizar-cita:hover .icon {
        transform: translate(4px);
    }

    .actualizar-cita:hover::before {
        animation: shine 1.5s ease-out infinite;
    }

    .actualizar-cita::before {
        content: "";
        position: absolute;
        width: 100px;
        height: 100%;
        background-image: linear-gradient(120deg,
                rgba(255, 255, 255, 0) 30%,
                rgba(255, 255, 255, 0.8),
                rgba(255, 255, 255, 0) 70%);
        top: 0;
        left: -100px;
        opacity: 0.6;
    }

    .input-checkbox {
        background: wheat;
        padding: 10px;
        border: 1px saddlebrown;
    }

    @keyframes shine {
        0% {
            left: -100px;
        }

        60% {
            left: 100%;
        }

        to {
            left: 100%;
        }
    }

    /* From Uiverse.io by chase2k25 */
    /* Checkbox Container */
    .checkbox-container {
        margin-left: 44px;
        margin-top: 10px;
    }

    /* Hidden Checkbox Input */
    .checkbox-input {
        display: none;
    }

    /* Checkbox Label */
    .checkbox {
        position: relative;
        width: 50px;
        height: 50px;
        background: #e0e0e0;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
        box-shadow:
            inset -4px -4px 8px #ffffff,
            inset 4px 4px 8px #b0b0b0;
    }

    /* X Mark Lines */
    .line {
        position: absolute;
        width: 30px;
        height: 4px;
        background: #a0a0a0;
        /* Disabled color */
        border-radius: 2px;
        transition: all 0.3s ease-in-out;
    }

    /* X Mark Line 1 */
    .line1 {
        transform: rotate(45deg);
    }

    /* X Mark Line 2 */
    .line2 {
        transform: rotate(-45deg);
    }

    /* Checked State */
    .checkbox-input:checked+.checkbox {
        background: #d4e9d4;
        /* Light green background */
    }

    .checkbox-input:checked+.checkbox .line1 {
        transform: rotate(50deg) translateX(-3px) translateY(8px) scaleX(0.6);
        background: #169c1fff;
    }

    .checkbox-input:checked+.checkbox .line2 {
        transform: rotate(-50deg) translateX(6px) translateY(3px);
        /* Second line in tick's opposite direction */
        background: #169c1fff;
    }
</style>
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
                <li><a href="../citas/mostrar.php">Listado de las citas</a></li>
                <li class="divider">></li>
                <li><a href="#" class="active">Información de la cita</a></li>
            </ul>

            <!-- multistep form -->
            <?php
            require '../../backend/bd/Conexion.php';
            $id = $_GET['id'];
            $sentencia = $connect->prepare("SELECT events.id, events.title, patients.idpa, patients.numhs,patients.nompa, patients.apepa, doctor.idodc, doctor.ceddoc, doctor.nodoc,doctor.nomesp, doctor.apdoc,events.start, events.end, events.color, events.state,events.chec,events.monto FROM events INNER JOIN patients ON events.idpa = patients.idpa INNER JOIN doctor ON events.idodc = doctor.idodc  WHERE id= '$id';");
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
                    <form action="" id="actualizar-cita-form" enctype="multipart/form-data" autocomplete="off"
                        class="max-w-lg mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                        <div class="space-y-4">
                            <input type="hidden" name="eventId" value="<?php echo $id; ?>" />

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="appnam">
                                    Motivo de la cita <span class="text-yellow-500 text-xs font-semibold ml-1">*</span>
                                </label>
                                <textarea name="appnam" placeholder="Escribe el motivo de la cita..."
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-40"><?php echo $d->title; ?></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="pati">
                                    Nombre del paciente <span class="text-yellow-500 text-xs font-semibold ml-1">*</span>
                                </label>
                                <select required name="apppac" id="pati"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="<?php echo $d->idpa; ?>"><?php echo $d->nompa; ?>         <?php echo $d->apepa; ?>
                                    </option>
                                    <!-- Aquí puedes agregar más opciones si es necesario -->
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="doc">
                                    Nombre del médico <span class="text-yellow-500 text-xs font-semibold ml-1">*</span>
                                </label>
                                <select required name="appdoc" id="doc"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="<?php echo $d->idodc; ?>"><?php echo $d->nodoc; ?>         <?php echo $d->apdoc; ?>
                                    </option>
                                    <!-- Aquí puedes agregar más opciones si es necesario -->
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="appini">
                                    Fecha inicial <span class="text-yellow-500 text-xs font-semibold ml-1">*</span>
                                </label>
                                <input type="datetime-local" value="<?php echo date('Y-m-d\TH:i', strtotime($d->start)); ?>"
                                    name="appini" required
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="appfin">
                                    Fecha final <span class="text-yellow-500 text-xs font-semibold ml-1">*</span>
                                </label>
                                <input type="datetime-local" value="<?php echo date('Y-m-d\TH:i', strtotime($d->end)); ?>"
                                    name="appfin" required
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="appmont">
                                    Monto a pagar <span class="text-yellow-500 text-xs font-semibold ml-1">*</span>
                                </label>
                                <input type="text" placeholder="S/. 0.00" value="<?php echo $d->monto; ?>" name="appmont"
                                    required
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="animated-checkbox">
                                    ¿Realizó el pago?
                                </label>
                                <div class="mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600"
                                            id="animated-checkbox" value="1" name="appreal" <?php echo $d->chec == '1' ? 'checked' : ''; ?>>
                                        <span class="ml-2 text-gray-700">Sí</span>
                                    </label>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-4">
                                <button id="update-cita"
                                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105"
                                    type="submit">
                                    Actualizar
                                </button>
                            </div>
                        </div>
                    </form>

                <?php endforeach; ?>

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
    <script src="../../backend/js/vpat.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>

        document.getElementById("update-cita").addEventListener("click", async function (event) {
            event.preventDefault(); // Detiene el envío del formulario por defecto
            const form = document.getElementById("actualizar-cita-form");
            const formData = new FormData(form); // Usa 'form' en lugar de 'this'
            try {
                const response = await fetch('../../backend/php/update.php', {
                    method: 'POST',
                    body: formData,
                });

                const result = await response.json();
                console.log('result', result);
                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Realizado!',
                        text: 'La operación se completó exitosamente.',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'La operación no se pudo completar.',
                    });
                }

            } catch (error) {
                Swal.fire({
                    icon: 'warning',
                    title: '¡Ups!',
                    text: 'Ocurrió un error inesperado.',
                });
            }

        });


    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>