<div x-data="crudDocumentos();" x-init="iniciar" class="max-w-6xl mx-auto px-4 py-8">
    <!-- Botón para mostrar/ocultar formulario -->
    <div class="mb-6">
        <button 
            @click="showForm = !showForm" 
            class="bg-[#31b0d5] hover:bg-[#2b9ec1] text-white font-medium py-2 px-4 rounded shadow transition-all duration-200 flex items-center"
        >
            <span x-text="showForm ? 'Cerrar formulario' : 'Agregar documento'"></span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-bind:class="{'rotate-180': showForm}">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
    </div>
    
    <!-- Formulario desplegable -->
    <div 
        x-show="showForm" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-4"
        class="bg-white rounded-lg shadow-md mb-8 overflow-hidden"
    >
        <div class="bg-[#31b0d5] text-white p-4">
            <h3 class="text-lg font-semibold">Agregar Documento</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div>
                    <label for="pdfFile" class="block text-sm font-medium text-gray-700 mb-1">Archivo</label>
                    <input 
                        type="file" 
                        id="pdfFile" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#31b0d5]"
                        accept=".txt, .xls, .xlsx, .doc, .docx, .pdf"
                    >
                    <input type="hidden" x-model="data.idpa">
                </div>
                <div>
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <input 
                        type="text" 
                        id="descripcion" 
                        x-model="data.descripcion"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#31b0d5]"
                        placeholder="Ingrese una descripción"
                    >
                </div>
                <div class="pt-3">
                    <button 
                        @click="agregar" 
                        class="w-full bg-[#31b0d5] hover:bg-[#2b9ec1] text-white font-medium py-2 px-4 rounded transition-colors duration-200"
                    >
                        Guardar documento
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de documentos -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-[#31b0d5] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Fecha de creación</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <template x-if="documentos.length > 0">
                        <template x-for="documento in documentos" :key="documento.id">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 capitalize" x-text="documento.descripcion"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="documento.fere"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a 
                                        :href="'../../backend/pdfs/subidos/' + documento.nomfi" 
                                        target="_blank"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-[#31b0d5] hover:bg-[#2b9ec1]"
                                    >
                                        Ver
                                    </a>
                                    <button 
                                        @click="eliminarDocumento(documento.id)" 
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700"
                                    >
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </template>
                    <template x-if="documentos.length === 0">
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500">
                                No hay documentos disponibles
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function crudDocumentos() {
        let idpa = new URLSearchParams(window.location.search).get('id');
        return {
            documentos: [],
            showForm: false,
            data: {
                pdfFile: null,
                descripcion: '',
                idpa: idpa
            },
            iniciar: function () {
                this.leer();
            },
            agregar: function () {
                let pdfFile = document.getElementById('pdfFile').files;
                if (pdfFile.length === 0) {
                    alert('Debe seleccionar al menos un archivo');
                    return;
                }
                
                let formData = new FormData();
                for (let i = 0; i < pdfFile.length; i++) {
                    formData.append('pdfFile', pdfFile[i]);
                }
                formData.append('idpa', this.data.idpa);
                formData.append('descripcion', this.data.descripcion);
              
                fetch('../../backend/ajax/documentos/add_documentos.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        this.leer();
                        this.data.descripcion = '';
                        document.getElementById('pdfFile').value = '';
                        this.showForm = false;
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Ocurrió un error al procesar la solicitud');
                });
            },
            leer: function () {
                fetch('../../backend/ajax/documentos/get_documentos.php?id=' + this.data.idpa)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        console.log('documentos', data);
                        this.documentos = data.data;
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Ocurrió un error al cargar los documentos');
                });
            },
            eliminarDocumento: function(id) {
                if (confirm('¿Está seguro de eliminar este documento?')) {
                    fetch('../../backend/ajax/documentos/delete_documento.php?id=' + id)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert(data.message);
                            this.leer();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Ocurrió un error al eliminar el documento');
                    });
                }
            }
        }
    }
</script>