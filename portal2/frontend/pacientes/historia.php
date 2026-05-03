<?php
ob_start();
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
  header('location: ../login.php');

  $id = $_SESSION['id'];
}
ini_set('display_errors', 1);

?>
<style>
  label.datos-paciente {
    text-transform: capitalize;
    font-weight: 600;
  }

  .pestañas-patients {
    margin: 20px;
  }

  .pestañas-botones {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
  }

  .pestañas-botones button {
    padding: 10px 20px;
    border: none;
    background-color: #f0f0f0;
    cursor: pointer;
    border-radius: 5px;
  }

  .pestañas-botones button.active {
    background-color: #31b0d5;
    color: white;
  }

  .pestañas-contenido {
    border: 1px solid #ccc;
    padding: 20px;
  }

  .pestañas-contenido {
    box-shadow: 0px 0px 25px 6px rgba(0, 0, 0, 0.1);
    border: navajowhite;
  }

  @media(max-width: 600px) {
    .botones-odontograma {
      display: grid;
      grid-template-columns: repeat(2, 1fr) !important;
    }
  }

  button#open-modal-nota {
    background: #1e2c4b;
    padding: 10px;
    color: white;
    border-radius: 10px 10px 0px 0px;
  }


  /* From Uiverse.io by vinodjangid07 */
  .print-btn {
    width: 141px;
    margin-top: 10px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: white;
    border: 1px solid rgb(213, 213, 213);
    border-radius: 10px;
    gap: 10px;
    font-size: 16px;
    cursor: pointer;
    overflow: hidden;
    font-weight: 500;
    box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.065);
    transition: all 0.3s;
  }

  .printer-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 100%;
  }

  .printer-container {
    height: 50%;
    width: 100%;
    display: flex;
    align-items: flex-end;
    justify-content: center;
  }

  .printer-container svg {
    width: 100%;
    height: auto;
    transform: translateY(4px);
  }

  .printer-page-wrapper {
    width: 100%;
    height: 50%;
    display: flex;
    align-items: flex-start;
    justify-content: center;
  }

  .printer-page {
    width: 70%;
    height: 10px;
    border: 1px solid black;
    background-color: white;
    transform: translateY(0px);
    transition: all 0.3s;
    transform-origin: top;
  }

  .print-btn:hover .printer-page {
    height: 16px;
    background-color: rgb(239, 239, 239);
  }

  .print-btn:hover {
    background-color: rgb(239, 239, 239);
  }
</style>

<?php include '../componentes/header.php'; ?>
<div x-data="{ hideSection: false,expandSection: false }">
  <!-- Botón de impresión -->

  <div class="contenedor-sidebar" x-bind:class="{ 'hidden-print': hideSection }">

    <?php include('../componentes/sidebar.php') ?>
  </div>
  <section id="content" class="historia-page" x-bind:style="expandSection ? 'width: 100%; left: 0;' : ''">
    <main>
      <ul class="breadcrumbs">

        <li><a href="../pacientes/mostrar.php">Listado de los pacientes</a></li>
        <li class="divider">></li>
        <li><a href="#" class="active">Historia clínica del paciente</a></li>
      </ul>
      <button class="print-btn" @click="
                hideSection = true; 
                expandSection = true; 
                setTimeout(() => { 
                    window.print(); 
                    hideSection = false; 
                    expandSection = false; 
                }, 1000)">
        <span class="printer-wrapper">
          <span class="printer-container">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 92 75">
              <path stroke-width="5" stroke="black"
                d="M12 37.5H80C85.2467 37.5 89.5 41.7533 89.5 47V69C89.5 70.933 87.933 72.5 86 72.5H6C4.067 72.5 2.5 70.933 2.5 69V47C2.5 41.7533 6.75329 37.5 12 37.5Z">
              </path>
              <mask fill="white" id="path-2-inside-1_30_7">
                <path d="M12 12C12 5.37258 17.3726 0 24 0H57C70.2548 0 81 10.7452 81 24V29H12V12Z"></path>
              </mask>
              <path mask="url(#path-2-inside-1_30_7)" fill="black"
                d="M7 12C7 2.61116 14.6112 -5 24 -5H57C73.0163 -5 86 7.98374 86 24H76C76 13.5066 67.4934 5 57 5H24C20.134 5 17 8.13401 17 12H7ZM81 29H12H81ZM7 29V12C7 2.61116 14.6112 -5 24 -5V5C20.134 5 17 8.13401 17 12V29H7ZM57 -5C73.0163 -5 86 7.98374 86 24V29H76V24C76 13.5066 67.4934 5 57 5V-5Z">
              </path>
              <circle fill="black" r="3" cy="49" cx="78"></circle>
            </svg>
          </span>

          <span class="printer-page-wrapper">
            <span class="printer-page"></span>
          </span>
        </span>
        Imprimir PDF
      </button>

      <br>

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
          <div class="input-block">
            <!-- Botón de impresión -->


            <div class=" bg-white p-6 rounded-lg shadow-md">
              <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <?php
                // Definir los campos a mostrar
                $campos = [
                  'Dni' => $d->numhs,
                  'nombre' => $d->nompa,
                  'apellido' => $d->apepa,
                  'direccion' => $d->direc,
                  'nacimiento' => $d->cump,
                  'Genero' => $d->sex,
                  'Grupo-Sanguineo' => $d->grup,
                  'Telefono' => $d->phon,
                ];

                // Generar los inputs dinámicamente
                foreach ($campos as $name => $value): ?>
                  <div class="relative">
                    <label class="block text-gray-700 text-sm font-medium mb-1"
                      for="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>">
                      <?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>
                    </label>

                    <input type="text" value="<?php echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?>"
                      name="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>" required
                      id="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">

                    <div
                      class="absolute bottom-0 left-0 w-full h-0.5 bg-gray-200 transform origin-bottom scale-x-0 transition-transform duration-300 group-focus-within:scale-x-100 group-focus-within:bg-blue-500">
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>

          </div>
        <?php endforeach; ?>
      <?php endif; ?>
      <section class="pestañas-patients" x-data="{ 
           pestañaActiva: (new URLSearchParams(window.location.search).get('pestaña') || 'odontograma'),
           validarPestaña(pestaña) {
             return ['informacion', 'historial', 'odontograma'].includes(pestaña) ? pestaña : 'odontograma';
           }
         }" x-init="pestañaActiva = validarPestaña(pestañaActiva)">
        <!-- Botones de las pestañas -->
        <div class="w-full">
          <!-- Versión para móviles - menú desplegable -->
          <div class="md:hidden relative">
            <select x-model="pestañaActiva"
              class="w-full py-2 px-3 border border-[#31b0d5] rounded bg-white text-gray-700 appearance-none focus:outline-none focus:ring-2 focus:ring-[#31b0d5]">
              <option value="historial">Historial Citas</option>
              <option value="informacion">Tratamientos</option>
              <option value="odontograma">Odontograma</option>
              <option value="imagenes">Imagenes</option>
              <option value="documentos">Documentos</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
              <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd" />
              </svg>
            </div>
          </div>

          <!-- Versión para tablets/desktop - pestañas horizontales -->
          <div class="hidden md:flex flex-wrap border-b border-[#31b0d5]">
            <button @click="pestañaActiva = 'historial'" :class="{ 
        'bg-[#31b0d5] text-white': pestañaActiva === 'historial',
        'text-gray-700 hover:text-[#31b0d5]': pestañaActiva !== 'historial'
      }" class="px-4 py-2 text-sm font-medium focus:outline-none transition-colors duration-200 rounded-t-lg">
              Historial Citas
            </button>
            <button @click="pestañaActiva = 'informacion'" :class="{ 
        'bg-[#31b0d5] text-white': pestañaActiva === 'informacion',
        'text-gray-700 hover:text-[#31b0d5]': pestañaActiva !== 'informacion'
      }" class="px-4 py-2 text-sm font-medium focus:outline-none transition-colors duration-200 rounded-t-lg">
              Tratamientos
            </button>
            <button @click="pestañaActiva = 'odontograma'" :class="{ 
        'bg-[#31b0d5] text-white': pestañaActiva === 'odontograma',
        'text-gray-700 hover:text-[#31b0d5]': pestañaActiva !== 'odontograma'
      }" class="px-4 py-2 text-sm font-medium focus:outline-none transition-colors duration-200 rounded-t-lg">
              Odontograma
            </button>
            <button @click="pestañaActiva = 'imagenes'" :class="{ 
        'bg-[#31b0d5] text-white': pestañaActiva === 'imagenes',
        'text-gray-700 hover:text-[#31b0d5]': pestañaActiva !== 'imagenes'
      }" class="px-4 py-2 text-sm font-medium focus:outline-none transition-colors duration-200 rounded-t-lg">
              Imagenes
            </button>
            <button @click="pestañaActiva = 'documentos'" :class="{ 
        'bg-[#31b0d5] text-white': pestañaActiva === 'documentos',
        'text-gray-700 hover:text-[#31b0d5]': pestañaActiva !== 'documentos'
      }" class="px-4 py-2 text-sm font-medium focus:outline-none transition-colors duration-200 rounded-t-lg">
              Documentos
            </button>
          </div>

          <!-- Contenido de las pestañas -->
          <div class="pestañas-contenido">
            <!-- Pestaña de Información -->
            <div x-show="pestañaActiva === 'historial'">
              <?php include '../componentes/historial_citas_pacientes.php'; ?>


            </div>

            <!-- Pestaña de Historial -->
            <div x-show="pestañaActiva === 'informacion'">
              <?php include '../componentes/mostrar_tratamientos.php'; ?>
              <?php include '../componentes/historial_tratamientos_pacientes.php'; ?>
            </div>

            <div x-show="pestañaActiva === 'imagenes'">
              <?php include '../componentes/mostrar_imagenes.php'; ?>
            </div>
            <div x-show="pestañaActiva === 'documentos'">
              <?php include '../componentes/documentos.php'; ?>
            </div>





            <!-- Pestaña de Odontograma -->
            <div x-show="pestañaActiva === 'odontograma'">
              <?php include '../componentes/odontograma.php'; ?>
              <?php include '../componentes/modal-notas.php'; ?>
            </div>

          </div>
      </section>

      <script src="../../backend/js/multistep.js"></script>
      <script src="../../backend/js/vpat.js"></script>
      <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
          acc[i].addEventListener("click", function () {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
              panel.style.display = "none";
            } else {
              panel.style.display = "block";
            }
          });
        }
      </script>

      <?php include_once '../../backend/modal/md_geog.php' ?>

      </form>
      <!--Fin de Ventana Modal--> <?php include_once '../../backend/modal/md_trat.php' ?>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </main>
</div>
<script src="../../backend/js/script.js"></script>