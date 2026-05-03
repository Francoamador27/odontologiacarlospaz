<style>
    .firma canvas {
        border: 1px solid black;
        border-radius: 10px;
    }

    input#getImage {
        background: green;
        padding: 10px;
        color: white;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    input#resetCanvas {
        background: red;
        color: white;
        padding: 10px;
        border-radius: 10px;
    }

    div#root {
        font-size: 18px;
        margin-bottom: 10px;
    }

    #mensajeFirma {
        display: none;
        color: green;
        text-decoration: solid;
    }

    button#delete-tratamiento {
        background: red;
        padding: 10px;
        color: white;
        border-radius: 10px;
    }

    button#delete-tratamiento:hover {
        background: #d70606;

    }
</style>


<div x-data="{...tratamientosForm()}" x-init="iniciar" class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Botón para mostrar/ocultar -->
    <button @click="isOpen = !isOpen"
        class="bg-[#31b0d5] hover:bg-blue-600 text-white px-6 py-3 rounded-lg flex items-center">
        <span x-text="isOpen ? 'Cerrar Formulario' : 'Agregar un Tratamiento'"></span>
        <svg x-bind:class="{ 'rotate-180': isOpen }" xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 ml-2 transform transition-transform" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M10 3a1 1 0 01.707.293l7 7a1 1 0 11-1.414 1.414L10 5.414l-6.293 6.293A1 1 0 012.293 10l7-7A1 1 0 0110 3z"
                clip-rule="evenodd" />
        </svg>
    </button>

    <div x-show="isOpen" class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="bg-white shadow-2xl rounded-2xl p-4 sm:p-8 border border-gray-100">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800 mb-6 sm:mb-8 text-center border-b pb-4">
                Crear un tratamiento</h1>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre del tratamiento</label>
                <input x-model="datosProyecto.proyectoName" type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300"
                    placeholder="Ingrese el nombre del proyecto">
            </div>

            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Etapas</h2>
                <template x-for="(accion, index) in datosProyecto.acciones" :key="index">
                    <div
                        class="grid grid-cols-1 md:grid-cols-[2fr_3fr_1fr_auto] gap-3 mb-4 bg-gray-50 p-4 rounded-lg shadow-sm">
                        <input x-model="accion.nombre" type="text"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                            placeholder="Nombre de la acción">
                        <input x-model="accion.descripcion" type="text"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Descripción">
                        <input x-model="accion.monto" type="number"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Monto">
                        <button @click="eliminarAccion(index)"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">Eliminar</button>
                    </div>
                </template>
                <button @click="agregarAccion()"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Agregar otra etapa</button>
            </div>

            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Materiales</h2>
                <template x-for="(material, index) in datosProyecto.materiales" :key="index">
                    <div
                        class="grid grid-cols-1 md:grid-cols-[2fr_3fr_1fr_auto] gap-3 mb-4 bg-gray-50 p-4 rounded-lg shadow-sm">
                        <input x-model="material.nombre" type="text"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                            placeholder="Nombre del material">
                        <input x-model="material.descripcion" type="text"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Descripción">
                        <input x-model="material.monto" type="number"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Monto">
                        <button @click="eliminarMaterial(index)"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">Eliminar</button>
                    </div>
                </template>
                <button @click="agregarMaterial()"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">Agregar otro
                    material</button>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Monto Total</label>
                <input x-model="datosProyecto.montoTotal" type="number"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingrese el monto total">
            </div>

            <button @click="generarPDF()"
                class="w-full bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg">Guardar</button>
        </div>
    </div>
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 p-4">
        <template x-for="(tratamiento, index) in tratamientos" :key="tratamiento.id">
            <div
                class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                <!-- Encabezado del acordeón -->
                <div @click="openIndex = openIndex === index ? null : index"
                    class="cursor-pointer bg-[#31b0d5] hover:bg-blue-700 text-white p-4 flex justify-between items-center transition-colors duration-200">
                    <h5 class="font-semibold text-lg md:text-xl truncate">
                        Tratamiento: <span x-text="tratamiento.datos.proyectoName"></span>
                    </h5>
                    <!-- Icono de flecha con transición -->
                    <div>
                        <i :class="openIndex === index ? 'fa-chevron-down' : 'fa-chevron-right'"
                            class="fas transition-transform duration-300 transform text-xl"
                            :style="openIndex === index ? 'transform: rotate(180deg)' : ''"></i>
                    </div>
                </div>

                <!-- Contenido del acordeón, que se muestra u oculta -->
                <div x-show="openIndex === index" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95" class="p-4">

                    <!-- Etapas -->
                    <div class="mb-4">
                        <p class="text-lg font-bold text-gray-800 mb-2">Etapas:</p>
                        <template x-for="(etapa, index) in tratamiento.datos.acciones" :key="index">
                            <div class="mb-3 pb-3 border-b border-gray-200 last:border-b-0">
                                <div x-text="etapa.nombre" class="font-semibold text-blue-800"></div>
                                <div x-text="etapa.descripcion" class="text-gray-600 text-sm my-1"></div>
                                <div class="flex items-center text-gray-700">
                                    <p>Monto:</p>
                                    <div x-text="'$' + etapa.monto" class="ml-2 font-medium"></div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Materiales -->
                    <div class="mb-4">
                        <p class="text-lg font-bold text-gray-800 mb-2">Materiales:</p>
                        <template x-for="(material,index) in tratamiento.datos.materiales" :key="index">
                            <div class="mb-3 pb-3 border-b border-gray-200 last:border-b-0">
                                <div x-text="material.nombre" class="font-semibold text-blue-800"></div>
                                <div x-text="material.descripcion" class="text-gray-600 text-sm my-1"></div>
                                <div class="flex items-center text-gray-700">
                                    <p>Monto:</p>
                                    <div x-text="'$' + material.monto" class="ml-2 font-medium"></div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Monto Total -->
                    <div class="flex items-center mt-4 py-3 border-t border-gray-200">
                        <p class="font-bold text-gray-800">Monto Total:</p>
                        <h3 x-text="'$' + tratamiento.datos.montoTotal" class="ml-2 font-bold text-xl text-blue-700">
                        </h3>
                    </div>

                    <!-- Botón Eliminar -->
                    <button @click="eliminarTratamiento(tratamiento.id, tratamiento.idpa)"
                        class="mt-3 w-full bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50">
                        Eliminar
                    </button>
                </div>
            </div>
        </template>
    </section>
</div>

<script>

    function tratamientosForm() {
        return {
            datosProyecto: {
                proyectoName: '',
                acciones: [{ nombre: '', descripcion: '', monto: '' }],
                materiales: [{ nombre: '', descripcion: '', monto: '' }],
                imagenes: [],
                montoTotal: '',
                firma: '',
                idpa: new URLSearchParams(window.location.search).get('id') // obtenemos el id desde la url con el params
            },
            isOpen: false,
            tratamientos: [],
            openIndex: null, // Para controlar qué acordeón está abierto
            toggle(index) {
                this.openIndex = this.openIndex === index ? null : index; // Alternar entre abrir y cerrar
            },


            iniciar: function () {
                this.obtenerTratamientos();
            },
            obtenerTratamientos: async function () {
                try {
                    const urlParams = new URLSearchParams(window.location.search);
                    const id = urlParams.get('id');
                    const response = await fetch(`../../backend/ajax/tratamientos/get_tratamientos.php?id=${id}`);
                    const data = await response.json();
                    console.log('data sin decodificar', data);
                    if (!data) {
                        this.tratamientos = [];
                    } else {
                        data.forEach(tratamiento => {
                            if (tratamiento.datos) {
                                try {
                                    tratamiento.datos = JSON.parse(tratamiento.datos);  // Parseamos la cadena JSON
                                } catch (e) {
                                    console.error("Error al parsear datos:", e);
                                }
                            }
                        });
                        console.log('datos decodificados', data);
                        this.tratamientos = data;
                    }
                } catch (error) {
                    console.error('Error al obtener los tratamientos:', error);
                }
            },
            eliminarTratamiento: async function (id, idpa) {
                try {
                    const response = await fetch(`../../backend/ajax/tratamientos/delete_tratamiento.php?id=${id}&idpa=${idpa}`);
                    const data = await response.json();
                    if (data.status === 'ok') {
                        this.obtenerTratamientos();
                    }
                } catch (error) {
                    console.error('Error al eliminar el tratamiento:', error);
                }
            },


            agregarAccion() {
                this.datosProyecto.acciones.push({ nombre: '', descripcion: '', monto: '' });
            },

            eliminarAccion(index) {
                this.datosProyecto.acciones.splice(index, 1);
            },

            agregarMaterial() {
                this.datosProyecto.materiales.push({ nombre: '', descripcion: '', monto: '' });
            },

            eliminarMaterial(index) {
                this.datosProyecto.materiales.splice(index, 1);
            },

            cargarImagenes(event) {
                Array.from(event.target.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = e => {
                        this.datosProyecto.imagenes.push(e.target.result);
                    };
                    reader.readAsDataURL(file);
                });
            },

            async generarPDF() {
                try {
                    this.datosProyecto.montoTotal = this.datosProyecto.acciones.reduce((acc, accion) => acc + Number(accion.monto), 0);
                    this.datosProyecto.montoTotal += this.datosProyecto.materiales.reduce((acc, material) => acc + Number(material.monto), 0);
                    const response = await fetch('../../backend/ajax/pdf/tratamiento_pdf.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(this.datosProyecto),
                    });

                    const blob = await response.blob();
                    const url = window.URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = 'Reporte_Proyecto.pdf';
                    link.click();
                    window.URL.revokeObjectURL(url);
                    const urlParams = new URLSearchParams(window.location.search);
                    Swal.fire({
                        title: '¡Tratamiento creado!',
                        text: 'El tratamiento se ha creado correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        this.obtenerTratamientos();
                        this.isOpen = false;
                    });

                } catch (error) {
                    console.error('Error:', error);
                    alert('Error al generar el PDF');
                }
            }
        };
    }




</script>


<style>
    .card-header.acordeon-tra {
        background: #31b0d5;
        border-bottom: none;
        border-radius: 8px;
    }

    .rotate-90 {
        transform: rotate(90deg);
    }
</style>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>