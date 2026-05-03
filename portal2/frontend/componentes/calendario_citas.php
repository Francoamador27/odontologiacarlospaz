<style>
    .contenedor-agregar {
        text-align: center;
    }
</style>
<?php
require_once('../../backend/bd/Conexion.php');

$req = $connect->prepare("
    SELECT 
        e.id, 
        e.idpa, 
        e.idodc, 
        e.title, 
        e.start, 
        e.end, 
        e.color,
        d.nodoc AS doctor_name,
        d.apdoc AS doctor_lastname,
        p.nompa AS patient_name,
        p.email_p AS patient_email,
        p.phon AS patient_phone,
        p.apepa AS patient_lastname
    FROM 
        events e
    JOIN 
        patients p ON e.idpa = p.idpa
    JOIN 
        doctor d ON e.idodc = d.idodc
");
$req->execute();
$events = $req->fetchAll();
?>
<section class="contenedor-calendario">
    <div class="contenedor-agregar">
        <div class="max-w-4xl mx-auto mt-10">
            <div class="">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Gestión de Citas</h2>
                <p class="text-gray-600 mb-6">
                    En esta sección, puedes gestionar tus citas de manera rápida y eficiente.
                </p>

            </div>
        </div>

        <a href="../citas/nuevo.php" class="agregar-cita"><span class="fa fa-plus"></span>Agregar Nueva Cita</a>
    </div>

    <div id="calendar" class="col-centered">
</section>




<script>
    $(document).ready(function () {
        var date = new Date();
        var yyyy = date.getFullYear().toString();
        var mm = (date.getMonth() + 1).toString().length == 1 ? "0" + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString();
        var dd = (date.getDate()).toString().length == 1 ? "0" + (date.getDate()).toString() : (date.getDate()).toString();
        $('#calendar').fullCalendar({
            header: {
                language: 'es',
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay',
            },
            defaultDate: yyyy + "-" + mm + "-" + dd,
            editable: true,
            eventLimit: true,
            selectable: true,
            selectHelper: true,
            select: function (start, end) {
                $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                $('#ModalAdd').modal('show');
            },
            eventRender: function (event, element) {
                element.bind('dblclick', function () {
                    $('#ModalEdit #id').val(event.id);
                    $('#ModalEdit #title').val(`${event.patientName} ${event.patientLastName} - ${event.title}`);
                    $('#ModalEdit #color').val(event.color);
                    $('#ModalEdit').modal('show');
                });
            },
            eventDrop: function (event, delta, revertFunc) {
                edit(event);
            },
            eventResize: function (event, dayDelta, minuteDelta, revertFunc) {
                edit(event);
            },
            eventClick: function (event) {
                Swal.fire({
                    title: `<strong>Evento: ${event.title}</strong>`,
                    html: `
                    <p><strong>Inicio:</strong> ${event.start.format('YYYY-MM-DD HH:mm:ss')}</p>
                    ${event.end ? `<p><strong>Fin:</strong> ${event.end.format('YYYY-MM-DD HH:mm:ss')}</p>` : ''}
                    <p><strong>Doctor:</strong> ${event.doctorName} ${event.doctorLastName}</p>
                    <p><strong>Paciente:</strong> ${event.patientName} ${event.patientLastName}</p>
                    <p><strong>Email Paciente:</strong> ${event.patientEmail}</p>
                    <p><strong>Teléfono Paciente:</strong> ${event.patientPhone}</p>
                `,
                    icon: 'info',
                    showCancelButton: true,
                    showDenyButton: true,
                    confirmButtonText: 'Aceptar',
                    denyButtonText: 'Editar cita',
                    footer: `
                    <div class="swal2-footer-buttons">
                        <button id="sendWhatsapp" class="swal2-confirm swal2-styled">
                            Enviar por WhatsApp
                        </button>
                        <button id="${event.id}" class="eliminar-cita swal2-cancel swal2-styled">
                            Eliminar cita
                        </button>
                    </div>
                `,
                }).then((result) => {
                    if (result.isConfirmed) {
                    } else if (result.isDenied) {
                        window.location.href = `../citas/info.php?id=${event.id}`;
                    }
                });

                // WhatsApp functionality
                document.getElementById('sendWhatsapp')?.addEventListener('click', () => {
                    let phone = event.patientPhone;

                    console.log(phone);
const message = encodeURIComponent(`
Su cita ha sido agendada correctamente:

📅 Fecha: ${event.start.format('DD-MM-YYYY HH:mm:ss')}
👩🏻‍💼 Profesional: ${event.doctorName} ${event.doctorLastName}
📍 Lugar: Carlos Pellegrini 464, Villa Carlos Paz

Recordatorios importantes:
- Llegar puntualmente a su horario asignado (no es necesario llegar antes).
- Tolerancia de 10 minutos de demora.
- Traer estudios previos si los tuviera.
- Traer cepillo y elementos de higiene que utilice.

⚠ Importante: Por favor respete su horario exacto de cita. Llegar muy temprano puede interrumpir la atención del paciente anterior.

Si necesita cancelar o reprogramar, por favor avísenos con 24 horas de anticipación.
Gracias por confiar en nosotros para su atención odontológica!
`);

                    const whatsappUrl = `https://wa.me/${phone}?text=${message}`;
                    window.open(whatsappUrl, '_blank');
                });

                // Add event listener for delete button
                document.querySelector('.eliminar-cita')?.addEventListener('click', () => {
                    // Confirm deletion
                    Swal.fire({
                        title: '¿Está seguro?',
                        text: 'Esta acción no se puede deshacer',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Perform fetch request to delete the appointment
                            fetch('../../backend/ajax/delete_appoitment.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: `id=${event.id}`
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Remove event from calendar
                                        $('#calendar').fullCalendar('removeEvents', event.id);

                                        Swal.fire(
                                            'Eliminado',
                                            'La cita ha sido eliminada.',
                                            'success'
                                        );
                                    } else {
                                        Swal.fire(
                                            'Error',
                                            'No se pudo eliminar la cita.',
                                            'error'
                                        );
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire(
                                        'Error',
                                        'Hubo un problema al eliminar la cita.',
                                        'error'
                                    );
                                });
                        }
                    });
                });
            },
            events: [
                <?php foreach ($events as $event):
                    $start = explode(" ", $event['start']);
                    $end = explode(" ", $event['end']);
                    if ($start[1] == '00:00:00') {
                        $start = $start[0];
                    } else {
                        $start = $event['start'];
                    }
                    if ($end[1] == '00:00:00') {
                        $end = $end[0];
                    } else {
                        $end = $event['end'];
                    }
                    ?>
                                                                    {
                        id: '<?php echo $event['id']; ?>',
                        title: <?php echo json_encode($event['patient_name'] . ' - ' . $event['title']); ?>,
                        start: '<?php echo $start; ?>',
                        end: '<?php echo $end; ?>',
                        color: '<?php echo $event['color']; ?>',
                        doctorName: '<?php echo $event['doctor_name']; ?>',
                        doctorLastName: '<?php echo $event['doctor_lastname']; ?>',
                        patientName: '<?php echo $event['patient_name']; ?>',
                        patientLastName: '<?php echo $event['patient_lastname']; ?>',
                        patientPhone: '<?php echo $event['patient_phone']; ?>',
                        patientEmail: '<?php echo $event['patient_email']; ?>',
                    },
                <?php endforeach; ?>
            ]
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>