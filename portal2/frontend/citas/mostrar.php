<?php
ob_start();
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('location: ../login.php');

    $id = $_SESSION['id'];
}
?>
<!DOCTYPE html>
<style>
    tr {
        border:
            none !important;
    }

    td {
        border:
            none !important;
    }
</style>
<html lang="es">

<?php include('../componentes/header.php') ?>


<body>

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
                <li><a href="#" class="active">Listado de las citas</a></li>
            </ul>
            <button class="button" onclick="location.href='nuevo.php'">Nuevo</button>
            <div class="data">
                <div class="content-data">
                    <div class="head">
                        <h3>Citas</h3>


                    </div>
                    <div class="table-responsive" style="overflow-x:auto;">
                        <?php
                        require '../../backend/bd/Conexion.php';
                        $sentencia = $connect->prepare("
                        SELECT events.id, events.title, patients.idpa, patients.numhs,patients.phon, patients.nompa, patients.apepa, doctor.idodc, doctor.ceddoc, doctor.nodoc, doctor.apdoc, events.start, events.end, events.color, events.state, events.chec, events.monto 
                        FROM events 
                        INNER JOIN patients ON events.idpa = patients.idpa 
                        INNER JOIN doctor ON events.idodc = doctor.idodc 
                        ORDER BY events.start DESC;
                    ");
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
                                        <th scope="col" class="px-4 py-3 text-left text-sm font-medium">Pacientes</th>
                                        <th scope="col" class="px-4 py-3 text-left text-sm font-medium">Motivo</th>
                                        <th scope="col" class="px-4 py-3 text-left text-sm font-medium">Médico</th>
                                        <th scope="col" class="px-4 py-3 text-left text-sm font-medium">Fecha inicio</th>
                                        <th scope="col" class="px-4 py-3 text-left text-sm font-medium">Fecha fin</th>
                                        <th scope="col" class="px-4 py-3 text-left text-sm font-medium">Estado del pago</th>
                                        <th scope="col" class="px-4 py-3 text-left text-sm font-medium">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $d): ?>
                                        <tr
                                            class="border-b border-gray-200 hover:bg-blue-50 transition-colors duration-200 even:bg-gray-50">
                                            <th scope="row" class="px-4 py-3 text-sm font-medium text-gray-900">
                                                <?php echo $d->nompa ?>&nbsp;<?php echo $d->apepa ?>
                                            </th>
                                            <td data-title="Cita" class="px-4 py-3 text-sm text-gray-700">
                                                <?php echo $d->title ?>
                                            </td>
                                            <td data-title="Médico" class="px-4 py-3 text-sm text-gray-700">
                                                <?php echo $d->nodoc ?>&nbsp;<?php echo $d->apdoc ?>
                                            </td>
                                            <td data-title="Fecha inicio" class="px-4 py-3 text-sm text-gray-700">
                                                <?php echo $d->start ?>
                                            </td>
                                            <td data-title="Fecha fin" class="px-4 py-3 text-sm text-gray-700">
                                                <?php echo $d->end ?>
                                            </td>


                                            <td data-title="Estado" class="px-4 py-3 text-sm">

                                                <form class="estado-form" data-id="<?= $d->id ?>" id="form-<?= $d->id ?>">
                                                    <label class="switch relative inline-block w-12 h-6">
                                                        <input class="estado-checkbox opacity-0 w-0 h-0" type="checkbox"
                                                            name="appreal" value="1" <?= $d->chec == '1' ? 'checked' : ''; ?> />
                                                        <span
                                                            class="slider absolute cursor-pointer inset-0 bg-gray-300 rounded-full transition-all duration-300 before:absolute before:h-5 before:w-5 before:left-0.5 before:bottom-0.5 before:bg-white before:rounded-full before:transition-all before:duration-300 before:shadow-md checked:bg-blue-600 checked:before:translate-x-6"></span>
                                                    </label>
                                                    <input type="hidden" name="id" value="<?= $d->id ?>" />
                                                </form>

                                            </td>


                                            <td class="px-4 py-3 text-sm">


                                                <a title="Información" href="../citas/info.php?id=<?php echo $d->id ?>"
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
                                                    method='POST' action='<?php $_SERVER['PHP_SELF'] ?>' class="inline">
                                                    <input type='hidden' name='id' value="<?php echo $d->id ?>">

                                                    <button name='delete_appointment' style="cursor: pointer;"
                                                        class="inline-flex items-center justify-center w-8 h-8 mr-1 text-red-600 bg-red-100 rounded-full hover:bg-red-200 transition-colors">
                                                        <i class="bx bx-trash text-lg"></i>
                                                    </button>
                                                </form>
                                                <?php
if ($d->phon) {
    // Formatear fecha
    $fecha = date('d-m-Y H:i:s', strtotime($d->start));
    $doctor = $d->doctorName . ' ' . $d->doctorLastName;
    $paciente = $d->patientName . ' ' . $d->patientLastName;
    $lugar = 'Carlos Pellegrini 464, Villa Carlos Paz';

    // Crear el mensaje (texto plano)
    $mensaje = "Su cita ha sido agendada correctamente:\n\n" .
        "📅 Fecha: $fecha\n" .
        "👩🏻‍💼 Profesional: $doctor\n" .
        "📍 Lugar: $lugar\n\n" .
        "Recordatorios importantes:\n" .
        "- Llegar puntualmente a su horario asignado (no es necesario llegar antes).\n" .
        "- Tolerancia de 10 minutos de demora.\n" .
        "- Traer estudios previos si los tuviera.\n" .
        "- Traer cepillo y elementos de higiene que utilice.\n\n" .
        "⚠ Importante: Por favor respete su horario exacto de cita. Llegar muy temprano puede interrumpir la atención del paciente anterior.\n\n" .
        "Si necesita cancelar o reprogramar, por favor avísenos con 24 horas de anticipación.\n" .
        "Gracias por confiar en nosotros para su atención odontológica!";

    // Encodear el mensaje UNA sola vez
    $mensaje = urlencode($mensaje);

    // Limpiar número de teléfono (ejemplo: 549354159120)
    $phone = preg_replace('/\D/', '', $d->phon);

    // Crear el enlace
    echo '<a href="https://wa.me/' . $phone . '?text=' . $mensaje . '" 
        title="WhatsApp" 
        class="inline-flex items-center px-3 py-1 mr-1 text-green-700 bg-green-100 rounded-full hover:bg-green-200 transition-colors" 
        target="_blank">
        <i class="bx bxl-whatsapp text-lg mr-1"></i> Enviar Turno al ' . $d->phon . '
    </a>';
}



                                                if ($d->chec == '0') {
                                                } else {
                                                    // code...
                                                    echo '<a title="Pago" href="../citas/money.php?id=' . $d->idpa . '" class="inline-flex items-center justify-center w-8 h-8 mr-1 text-green-600 bg-green-100 rounded-full hover:bg-green-200 transition-colors"><i class="bx bx-dollar text-lg"></i></a>';

                                                    echo '<a title="Boleta" href="../citas/documento.php?id=' . $d->id . '" class="inline-flex items-center justify-center w-8 h-8 mr-1 text-purple-600 bg-purple-100 rounded-full hover:bg-purple-200 transition-colors"><i class="bx bx-file text-lg"></i></a>';

                                                    echo '<a title="Ticket" href="../citas/ticket.php?id=' . $d->id . '" class="inline-flex items-center justify-center w-8 h-8 mr-1 text-amber-600 bg-amber-100 rounded-full hover:bg-amber-200 transition-colors"><i class="bx bx-receipt text-lg"></i></a>';
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
            <?php include_once '../../backend/php/delete_appointment.php' ?>

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
                ],
                order: [[3, 'desc']] // Ordena por la cuarta columna (índice 3) en orden descendente
            });
        });

    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        document.querySelectorAll('.estado-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', async function () {
                const form = this.closest('.estado-form'); // Obtener el formulario contenedor

                // Obtener los valores del formulario
                const id = form.querySelector('input[name="id"]').value; // Asegúrate de que haya un campo 'id' en el formulario
                const estado = this.checked ? 1 : 0; // Si el checkbox está marcado, se asigna 1, si no, 0
                console.log('estado', estado);
                const endpoint = '../../backend/ajax/cambiar.php'; // Ruta al archivo PHP

                try {
                    // Realizar la solicitud fetch
                    const response = await fetch(endpoint, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json', // Especificar el tipo de contenido como JSON
                        },
                        body: JSON.stringify({
                            id: id,
                            chec: estado,
                        }), // Enviar los datos como JSON
                    });

                    // Procesar la respuesta como JSON

                    const data = await response.json();
                    console.log('data', data)
                    if (data.success) {
                        // Si la actualización fue exitosa
                        Swal.fire({
                            icon: 'success',
                            title: 'Estado actualizado correctamente',
                            text: data.message, // Mensaje enviado desde el servidor
                        });
                    } else {
                        // Si hubo un error en el servidor
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message, // Mensaje de error desde el servidor
                        });
                    }
                } catch (error) {
                    // Si ocurre un error en la solicitud fetch
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al realizar la solicitud',
                        text: error.message,
                    });
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



</body>

</html>