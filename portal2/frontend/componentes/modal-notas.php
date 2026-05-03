<div class="mostrar-notas" x-data="crudNotas();" x-init="iniciar">
    <!-- Toggle Button -->
    <div class="">
        <button @click="toggleForm" style="background-color: #31b0d5;"
            class="inline-flex items-center px-4 py-2 rounded-t-lg text-white font-medium transition-all duration-200"
            :class="showForm ? 'bg-blue-600 shadow-md' : 'bg-blue-500 hover:bg-blue-600'">
            <i class="fas fa-plus-circle mr-2"></i>
            Agregar Nota
        </button>
    </div>

    <!-- Form that slides down when button is clicked -->
    <div x-show="showForm" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-4"
        class="bg-white p-6  shadow-md mb-6 border-t-4 border-[#31b0d5]">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="mtcl" class="block text-sm font-medium text-gray-700 mb-1">Motivo de la consulta</label>
                <input type="text" id="mtcl" x-model="data.mtcl" placeholder="Describa el motivo"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>
            <div>
                <label for="fere" class="block text-sm font-medium text-gray-700 mb-1">Fecha y hora</label>
                <input type="datetime-local" id="fere" x-model="data.fere"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="numdiente" class="block text-sm font-medium text-gray-700 mb-1">Número de diente</label>
                <input type="text" id="numdiente" x-model="data.numdiente" placeholder="Ej: 32"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>
            <div class="flex items-center">
                <label class="inline-flex items-center">
                    <input type="checkbox" x-model="data.state" class="form-checkbox h-5 w-5 text-blue-600" />
                    <span class="ml-2 text-gray-700">Estado activo</span>
                </label>
            </div>
        </div>
        <div class="flex justify-end">
            <button @click="agregar"
                class="bg-blue-500 text-white py-2 px-4 rounded-lg shadow hover:bg-blue-600 transition focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-save mr-2"></i>Guardar Nota
            </button>
        </div>
    </div>

    <div>
        <section class="contenedor-imagenes">
            <div>
                <template x-if="notas.length > 0">
                    <div class="overflow-x-auto shadow-md ">
                        <table class="min-w-full bg-white divide-y divide-gray-200">
                            <thead style="background-color: #31b0d5;">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Número de diente</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Motivo de la consulta</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Estado</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Acciones</th>
                                        <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Fecha </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <template x-for="nota in notas" :key="nota.idconslt">
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 capitalize"
                                            x-text="nota.numdiente"></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize"
                                            x-text="nota.mtcl"></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span x-text="nota.state ? 'Activo' : 'Inactivo'"
                                                :class="nota.state ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full py-1">
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                       
                                            <button @click="borrar(nota.idconslt)"
                                                class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md text-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                Borrar
                                            </button>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                            x-text="nota.fere"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </template>
            </div>
        </section>
    </div>
</div>

<script>
    function crudNotas() {
        let idpa = new URLSearchParams(window.location.search).get('id');
        return {
            notas: [],
            showForm: false, // Estado para controlar la visibilidad del formulario
            lightboxOpen: false, // Estado para controlar la visibilidad del lightbox
            currentImage: '', // Imagen actual mostrada en el lightbox
            data: {
                mtcl: '',
                idpa: idpa,
                fere: '',
                numdiente: '',
                state: false,
            },
            url: '../../backend/ajax/imagenes/',
            iniciar: function () {
                this.leer();
            },
            toggleForm: function () {
                this.showForm = !this.showForm;
                if (!this.showForm) {
                    // Limpiar el formulario al cerrarlo
                    this.data.mtcl = '';
                    this.data.fere = '';
                    this.data.numdiente = '';
                    this.data.state = false;
                }
            },
            agregar: async function () {
                console.log('data', this.data);
                const response = await fetch('../../backend/ajax/notas/add_notas.php', {
                    method: 'POST',
                    body: JSON.stringify(this.data),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then(response => response.json()).then(data => {
                    console.log('response', data);
                    if (data.success === true) {
                        Swal.fire('Nota agregada', 'La nota ha sido agregada correctamente', 'success');
                        this.leer();
                        // Limpiar formulario después de guardar exitosamente
                        this.data.mtcl = '';
                        this.data.fere = '';
                        this.data.numdiente = '';
                        this.data.state = false;
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                }).catch(error => {
                    console.error('Error al agregar la nota:', error);
                    Swal.fire('Error', 'Ha ocurrido un error al procesar la solicitud', 'error');
                });
            },
            leer: async function () {
                try {
                    const response = await fetch(`../../backend/ajax/notas/getConsultaNotas.php?id=${idpa}`);
                    const data = await response.json();
                    console.log('notas', data);
                    this.notas = data;
                } catch (error) {
                    console.error('Error al obtener las notas:', error);
                }
            },
            borrar: function (idNota) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`../../backend/ajax/notas/delete_notas.php`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json'  // Indicar que estamos enviando JSON
                            },
                            body: JSON.stringify({ id: idNota })  // Enviar el id como JSON
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success === true) {
                                    Swal.fire('Eliminado', 'La nota ha sido eliminada correctamente', 'success');
                                    this.leer();
                                } else {
                                    Swal.fire('Error', data.message, 'error');
                                }
                            }).catch(error => {
                                console.error('Error al eliminar la nota:', error);
                                Swal.fire('Error', 'Ha ocurrido un error al procesar la solicitud', 'error');
                            });
                    }
                });
            },
        }
    }
</script>