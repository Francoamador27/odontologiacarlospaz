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
                <li><a href="../citas/mostrar.php">Listado de las citas</a></li>
                <li class="divider">></li>
                <li><a href="#" class="active">Nueva cita</a></li>
            </ul>

            <!-- multistep form -->
            <form id="appointment-form" enctype="multipart/form-data" method="POST" autocomplete="off"
                class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
                <div class="space-y-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Nueva cita</h1>

                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                        <div class="flex">
                            <div class="py-1">
                                <svg class="h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold">Importante!</p>
                                <p>Es importante rellenar los campos con <span
                                        class="inline-block px-1 py-0.5 text-xs font-semibold bg-yellow-200 text-yellow-800 rounded">*</span>
                                </p>
                            </div>
                            <button type="button" class="ml-auto"
                                onclick="this.parentElement.parentElement.style.display='none';">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4"></div>

                    <div class="space-y-4">
                        <div>
                            <label for="appnam" class="block text-sm font-medium text-gray-700 mb-1">
                                Motivo de la cita <span
                                    class="text-xs font-semibold bg-yellow-200 text-yellow-800 rounded px-1">*</span>
                            </label>
                            <textarea name="appnam" id="appnam" rows="5"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Describa el motivo de la cita..."> </textarea>
                        </div>

                        <div>
                            <label for="pati" class="block text-sm font-medium text-gray-700 mb-1">
                                Nombre del paciente <span
                                    class="text-xs font-semibold bg-yellow-200 text-yellow-800 rounded px-1">*</span>
                            </label>
                            <select required name="apppac" id="pati"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option>Seleccione</option>
                            </select>
                        </div>

                        <div>
                            <label for="doc" class="block text-sm font-medium text-gray-700 mb-1">
                                Nombre del médico <span
                                    class="text-xs font-semibold bg-yellow-200 text-yellow-800 rounded px-1">*</span>
                            </label>
                            <select required name="appdoc" id="doc"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option>Seleccione</option>
                            </select>
                        </div>

                        <div>
                            <label for="spe" class="block text-sm font-medium text-gray-700 mb-1">
                                Especialidad del médico <span
                                    class="text-xs font-semibold bg-yellow-200 text-yellow-800 rounded px-1">*</span>
                            </label>
                            <select disabled id="spe"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-500">
                                <option>Seleccione</option>
                            </select>
                        </div>

                        <div>
                            <label for="gep" class="block text-sm font-medium text-gray-700 mb-1">
                                Color <span
                                    class="text-xs font-semibold bg-yellow-200 text-yellow-800 rounded px-1">*</span>
                            </label>
                            <select required name="appco" id="gep"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option style="color:#CD5C5C;" value="#CD5C5C">&#9724; Indio Rojo</option>
                                <option style="color:#F08080;" value="#F08080">&#9724; Coral claro</option>
                                <option style="color:#8B0000;" value="#8B0000">&#9724; Rojo oscuro</option>
                                <option style="color:#0071c5;" value="#0071c5">&#9724; Azul oscuro</option>
                                <option style="color:#FFC0CB;" value="#FFC0CB">&#9724; Rosado</option>
                                <option style="color:#FFB6C1;" value="#FFB6C1">&#9724; Rosa claro</option>
                                <option style="color:#FF7F50;" value="#FF7F50">&#9724; Coral</option>
                                <option style="color:#FF4500;" value="#FF4500">&#9724; Rojo naranja</option>
                                <option style="color:#FFFF00;" value="#FFFF00">&#9724; Amarillo</option>
                                <option style="color:#EE82EE;" value="#EE82EE">&#9724; Violeta</option>
                            </select>
                        </div>

                        <div>
                            <label for="appini" class="block text-sm font-medium text-gray-700 mb-1">
                                Fecha del turno <span
                                    class="text-xs font-semibold bg-yellow-200 text-yellow-800 rounded px-1">*</span>
                            </label>
                            <input type="datetime-local" id="appini" name="appini" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label for="duracion" class="block text-sm font-medium text-gray-700 mb-1">
                                Duración del turno (en minutos)
                            </label>
                            <select id="duracion" name="duracion" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="30">30 minutos</option>
                                <option value="60">1 hora</option>
                                <option value="90">1 hora y 30 minutos</option>
                                <option value="120">2 horas</option>
                            </select>
                        </div>

                        <div>
                            <label for="appmont" class="block text-sm font-medium text-gray-700 mb-1">
                                Monto a pagar
                            </label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">S/.</span>
                                </div>
                                <input type="text" name="appmont" id="appmont" value="0.00"
                                    class="w-full pl-12 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="0.00">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <label for="appreal" class="block text-sm font-medium text-gray-700 mr-3">
                                Realiza pago <span
                                    class="text-xs font-semibold bg-yellow-200 text-yellow-800 rounded px-1">*</span>
                            </label>
                            <div class="flex items-center">
                                <span class="mr-2 text-sm text-gray-600">SI</span>
                                <input type="checkbox" name="appreal" value="1"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-5 mt-6">
                        <button type="submit" name="add_appointment"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            Guardar
                        </button>
                    </div>
                </div>
            </form>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        document.getElementById('appointment-form').addEventListener('submit', async function (e) {
            e.preventDefault(); // Prevenir el comportamiento por defecto del formulario

            const formData = new FormData(this);

            try {
                const response = await fetch('../../backend/php/add_appointment.php', {
                    method: 'POST',
                    body: formData,
                });

                const responseJson = await response.json();

                if (responseJson && responseJson.success) {

                    if (responseJson.email) {
                        console.log('responseJson', responseJson);
                        Swal.fire({
                            title: 'Cita agregada',
                            text: '¿Desea enviar un email con el turno?',
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonText: 'Sí',
                            cancelButtonText: 'No',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Si el usuario confirma que quiere enviar el email
                                let data = {
                                    email: responseJson.email,
                                    motivo: responseJson.motivo,
                                    duracion: responseJson.duracion,
                                    fecha: responseJson.fecha,

                                }
                                fetch('../../backend/ajax/send_email.php', {
                                    method: 'POST',
                                    body: JSON.stringify(data),
                                    headers: {
                                        'Content-Type': 'application/json'
                                    }
                                }).then(response => response.json()).then(result => {
                                    console.log('result del email', result);
                                    if (result && result.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Email enviado',
                                            text: 'Se envió el email con el turno',
                                            confirmButtonText: 'Cerrar',
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: result.message || 'Ocurrió un error al enviar el email',
                                            confirmButtonText: 'Cerrar',
                                        });
                                    }
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Cita agregada',
                            text: 'Se agregó la cita correctamente',
                            confirmButtonText: 'Cerrar',
                        });
                    }

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.message || 'Ocurrió un error al agregar la cita',
                        confirmButtonText: 'Cerrar',
                    });
                }
            }
            catch (error) {
                console.error("Ocurrió un error:");
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.message || 'Se agrego la cita, pero el email posiblemente no se envio',
                    confirmButtonText: 'Cerrar',
                });// Muestra el stack trace del error para ubicar dónde ocurrió
            }

        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>