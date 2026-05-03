<div class="container mx-auto my-8 px-4">
    <div x-data="gastosApp()">
        <!-- Elemento para depuración -->
        <div x-effect="console.log('Gastos actualizados:', gastos)" class="hidden"></div>

        <div class="flex flex-col md:flex-row gap-6">
            <!-- Formulario (Lado Izquierdo) -->
            <div class="md:w-1/3 bg-white p-4 rounded-lg shadow-lg">
                <h1 class="text-xl font-bold text-gray-800 mb-3">Nuevo Gasto</h1>

                <!-- Alerta de campos requeridos -->
                <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded relative mb-4 text-sm"
                    role="alert">
                    <span class="absolute top-0 right-0 px-2 py-1">
                        <svg @click="$el.parentElement.parentElement.remove()"
                            class="fill-current h-4 w-4 text-red-500 cursor-pointer" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                    <strong class="font-bold">¡Importante!</strong>
                    <span class="block sm:inline text-xs"> Campos con <span class="text-red-600 font-bold">*</span> son
                        requeridos</span>
                </div>

                <div class="space-y-4">
                    <!-- Selector de categorías -->
                    <div>
                        <label for="categoria" class="block text-sm font-medium text-gray-700 mb-1">
                            Categoría <span class="text-red-600">*</span>
                        </label>
                        <select x-model="formData.categoria_id" id="categoria"
                            class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="" disabled selected>Selecciona una categoría</option>
                            <template x-for="categoria in categorias" :key="categoria.id">
                                <option :value="categoria.id" x-text="categoria.nombre_categoria"></option>
                            </template>
                        </select>
                    </div>

                    <!-- Motivo del gasto -->
                    <div>
                        <label for="descgast" class="block text-sm font-medium text-gray-700 mb-1">
                            Motivo del gasto <span class="text-red-600">*</span>
                        </label>
                        <textarea x-model="formData.descripcion" id="descgast" rows="3"
                            class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none"
                            placeholder="Describe el motivo del gasto..." required></textarea>
                    </div>

                    <!-- Importe -->
                    <div>
                        <label for="importegasto" class="block text-sm font-medium text-gray-700 mb-1">
                            Importe <span class="text-red-600">*</span>
                            <span class="text-xs text-gray-500 ml-1">($)</span>
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-1 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" x-model="formData.importe" id="importegasto"
                                class="w-full pl-8 pr-3 py-1.5 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="0.00" min="0" step="0.01" required>
                        </div>
                    </div>

                    <!-- Fecha del gasto -->
                    <div>
                        <label for="fechagasto" class="block text-sm font-medium text-gray-700 mb-1">
                            Fecha del gasto <span class="text-red-600">*</span>
                        </label>
                        <input type="date" x-model="formData.fecha" id="fechagasto"
                            class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            :max="new Date().toISOString().split('T')[0]" required>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex justify-end space-x-3 pt-3 border-t border-gray-200">
                        <button type="button" @click="limpiarFormulario()"
                            class="px-3 py-1.5 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Cancelar
                        </button>
                        <button type="button" @click="guardarGasto()"
                            class="px-4 py-1.5 text-sm bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
                            :disabled="!formValido" :class="{'opacity-50 cursor-not-allowed': !formValido}">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Guardar
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Listado de Gastos (Lado Derecho) -->
            <div
                class="md:w-2/3 bg-gradient-to-br from-blue-50 to-white p-6 rounded-xl shadow-lg border border-blue-100">
                <h1 class="text-2xl font-bold text-blue-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Listado de Gastos
                </h1>
                <div class="mb-5">
                    <label for="selectMes" class="block text-sm font-medium text-blue-700 mb-1">Filtrar por
                        mes:</label>
                    <select id="selectMes" x-model="mesFiltro" @change="filtrarPorMes()"
                        class="mt-1 block w-full md:w-64 pl-1 pr-10 py-2 text-base border-blue-200 bg-blue-50 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg shadow-sm">
                        <option value="">Todos los meses</option>
                        <option value="01">01 - Enero</option>
                        <option value="02">02 - Febrero</option>
                        <option value="03">03 - Marzo</option>
                        <option value="04">04 - Abril</option>
                        <option value="05">05 - Mayo</option>
                        <option value="06">06 - Junio</option>
                        <option value="07">07 - Julio</option>
                        <option value="08">08 - Agosto</option>
                        <option value="09">09 - Septiembre</option>
                        <option value="10">10 - Octubre</option>
                        <option value="11">11 - Noviembre</option>
                        <option value="12">12 - Diciembre</option>
                    </select>
                </div>
                <!-- Tabla de gastos -->
                <div class="overflow-x-auto rounded-lg shadow">
                    <table class="min-w-full divide-y divide-blue-200">
                        <thead class="bg-[#31b0d5]">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Fecha</th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Categoría</th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Descripción</th>
                                <th scope="col"
                                    class="px-4 py-3 text-right text-xs font-medium text-white uppercase tracking-wider">
                                    Importe</th>
                                <th scope="col"
                                    class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-blue-100">
                            <!-- Aquí se mostrarían los gastos con un template x-for -->
                            <template x-for="(gasto, index) in gastos" :key="gasto.id">
                                <tr class="hover:bg-blue-50 transition-colors duration-150">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-blue-900"
                                        x-text="gasto.fecha"></td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-blue-800"
                                        x-text="gasto.nombre_categoria"></td>
                                    <td class="px-4 py-3 text-sm text-blue-700 truncate max-w-xs"
                                        x-text="gasto.descripcion"></td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-blue-900 text-right"
                                        x-text="'$' + gasto.importe"></td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-center">
                                        <button type="button"
                                            class="px-3 py-1.5 text-xs bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-150 shadow-sm"
                                            @click="eliminarGasto(gasto.id)">
                                            <span class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Eliminar
                                            </span>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            <!-- Mensaje cuando no hay gastos -->
                            <tr x-show="gastos.length === 0">
                                <td colspan="5" class="px-4 py-6 text-sm text-center text-blue-400 italic bg-blue-50">
                                    No hay gastos registrados para este período.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div
                    class="flex items-center p-4 mt-4 bg-[#31b0d5] rounded-lg shadow-md text-white font-medium text-lg">
                    Total de gastos: <span class="ml-2 font-bold text-white" x-text="'$' + totalGastos"></span>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function gastosApp() {
        return {
            gastos: [],
            totalGastos: '',
            mesFiltro: (new Date().getMonth() + 1).toString().padStart(2, '0'),
            categorias: [],
            formData: {
                categoria_id: '',
                descripcion: '',
                importe: '',
                fecha: new Date().toISOString().split('T')[0] // Fecha actual por defecto
            },
            cargando: false,
            mensaje: '',
            tipoMensaje: '',

            get formValido() {
                return this.formData.categoria_id &&
                    this.formData.descripcion &&
                    this.formData.importe > 0 &&
                    this.formData.fecha;
            },

            init() {
                this.obtenerCategorias();
                this.getGastos();
            },
            eliminarGasto: async function (id) {
                const confirmacion = await Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                });

                if (confirmacion.isConfirmed) {
                    try {
                        const response = await fetch(`../../backend/ajax/actividades/eliminar_gastos.php?id=${id}`);

                        const data = await response.json();

                        if (data.success) {
                            Swal.fire({
                                title: 'Eliminado',
                                text: 'Gasto eliminado correctamente.',
                                icon: 'success',
                                confirmButtonText: 'Aceptar'
                            });
                            this.getGastos();
                        } else {
                            this.mostrarMensaje('Error al eliminar el gasto: ' + (data.message || 'Error desconocido'), 'error');
                        }
                    } catch (error) {
                        console.error('Error en la solicitud de eliminación:', error);
                        this.mostrarMensaje('Error de conexión al eliminar el gasto.', 'error');
                    }
                }
            },
            filtrarPorMes() {
                this.getGastos(this.mesFiltro);
            },
            async obtenerCategorias() {
                try {
                    const response = await fetch('../../backend/ajax/actividades/get_categorias.php');
                    const data = await response.json();

                    if (data.success) {
                        this.categorias = data.data;
                    } else {
                        console.error('Error al obtener categorías:', data.message);
                        this.mostrarMensaje('No se pudieron cargar las categorías.', 'error');
                    }
                } catch (error) {
                    console.error('Error en la solicitud de categorías:', error);
                    this.mostrarMensaje('Error de conexión al cargar categorías.', 'error');
                }
            },
            async getGastos(mes = '') {
                try {
                    // Modificamos la URL para incluir el parámetro del mes si existe
                    const url = mes
                        ? `../../backend/ajax/actividades/get_gastos.php?mes=${mes}`
                        : '../../backend/ajax/actividades/get_gastos.php';

                    const response = await fetch(url);
                    const data = await response.json();

                    if (data.success) {
                        console.log('data data', data.data);
                        console.log('gastos', this.gastos);
                        this.totalGastos = data.data.reduce((total, gasto) => total + parseFloat(gasto.importe || 0), 0);
                        this.gastos = data.data;
                    } else {
                        console.error('Error al obtener gastos:', data.message);
                        this.mostrarMensaje('No se pudieron cargar las gastos.', 'error');
                    }
                } catch (error) {
                    console.error('Error en la solicitud de gastos:', error);
                    this.mostrarMensaje('Error de conexión al cargar gastos.', 'error');
                }
            },

            // Guardar el gasto
            async guardarGasto() {
                if (!this.formValido) {
                    this.mostrarMensaje('Por favor, completa todos los campos requeridos.', 'error');
                    return;
                }

                this.cargando = true;

                try {
                    const response = await fetch('../../backend/ajax/actividades/guardar_gasto.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(this.formData)
                    });

                    const result = await response.json();

                    if (result.success) {
                        this.mostrarMensaje('Gasto registrado correctamente.', 'success');
                        this.getGastos();
                        this.limpiarFormulario();
                    } else {
                        this.mostrarMensaje('Error al guardar el gasto: ' + (result.message || 'Error desconocido'), 'error');
                    }
                } catch (error) {
                    console.error('Error en la solicitud:', error);
                    this.mostrarMensaje('Error de conexión al guardar el gasto.', 'error');
                } finally {
                    this.cargando = false;
                }
            },

            // Limpiar el formulario
            limpiarFormulario() {
                this.formData = {
                    categoria_id: '',
                    descripcion: '',
                    importe: '',
                    fecha: new Date().toISOString().split('T')[0]
                };
            },

            // Mostrar mensaje al usuario
            mostrarMensaje(mensaje, tipo) {
                this.mensaje = mensaje;
                this.tipoMensaje = tipo;

                // Aquí podrías implementar una lógica para mostrar alertas
                alert(mensaje);
            }
        };
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>