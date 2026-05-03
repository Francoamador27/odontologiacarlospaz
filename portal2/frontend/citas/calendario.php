<?php
ob_start();
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
  header('location: ../login.php');

  $id = $_SESSION['id'];
}
?>
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
      <ul class="breadcrumbs">
        <li><a href="../admin/escritorio.php">Home</a></li>
        <li class="divider">></li>
        <li><a href="#" class="active">Calendario de las citas</a></li>
      </ul>

      <div class="data">
        <div class="content-data">
          <div class="head">
            <h3>Calendario</h3>

          </div>
          <div class="conte-header-calendario">

            <a href="../citas/nuevo.php" class="agregar-cita"><span class="fa fa-plus"></span>Agregar Nueva Cita</a>
            <div id="calendar" class="col-centered">

            </div>
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
  <!-- FullCalendar -->
  <script src='../../backend/js/moment.min.js'></script>
  <script src='../../backend/js/fullcalendar/fullcalendar.min.js'></script>
  <script src='../../backend/js/fullcalendar/fullcalendar.js'></script>
  <script src='../../backend/js/fullcalendar/locale/es.js'></script>




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
        eventLimit: true, // allow "more" link when too many events
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
            $('#ModalEdit #title').val(event.title);
            $('#ModalEdit #color').val(event.color);
            $('#ModalEdit').modal('show');
          });
        },
        eventDrop: function (event, delta, revertFunc) { // si changement de position
          edit(event);
        },
        eventResize: function (event, dayDelta, minuteDelta, revertFunc) { // si changement de longueur
          edit(event);
        },
        eventClick: function (event) {
          // SweetAlert dialog
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
            cancelButtonText: 'Eliminar cita',
            footer: `
        <button id="sendWhatsapp" class="swal2-confirm swal2-styled">
            Enviar por WhatsApp
        </button>
    `,
          }).then((result) => {
            if (result.isConfirmed) {
              console.log('Aceptar como está');
            } else if (result.isDenied) {
              console.log('Editar cita');
              window.location.href = `../citas/info.php?id=${event.id}`;
            } else if (result.dismiss === Swal.DismissReason.cancel) {
              console.log('Eliminar cita');

              // Crear dinámicamente el formulario para enviar la solicitud de eliminación
              const form = document.createElement('form');
              form.method = 'POST';
              form.action = window.location.href; // Utiliza la URL actual como acción del formulario

              // Agregar un campo oculto para enviar el ID del evento
              const inputId = document.createElement('input');
              inputId.type = 'hidden';
              inputId.name = 'id';
              inputId.value = event.id; // Asegúrate de que `event.id` sea correcto

              // Agregar un campo para identificar la acción de eliminación
              const inputAction = document.createElement('input');
              inputAction.type = 'hidden';
              inputAction.name = 'delete_appointment';
              inputAction.value = 'true';

              // Agregar los campos al formulario
              form.appendChild(inputId);
              form.appendChild(inputAction);

              // Confirmar antes de enviar el formulario
              if (confirm('¿Realmente desea eliminar el registro?')) {
                document.body.appendChild(form);
                form.submit(); // Enviar el formulario
              }
            }
          });

          // Agregar funcionalidad al botón de WhatsApp después de que el cuadro de diálogo esté renderizado
          document.getElementById('sendWhatsapp')?.addEventListener('click', () => {
            // Asegúrate de que el número de teléfono esté en formato internacional
            const phone = event.patientPhone; // Elimina caracteres no válidos
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
              title: <?php echo json_encode($event['title']); ?>,
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

</body>

</html>
<?php include_once '../../backend/php/delete_appointment.php' ?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
  integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
  integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>