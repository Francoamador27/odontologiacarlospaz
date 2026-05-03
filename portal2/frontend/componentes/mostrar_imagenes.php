<style>
    .modal-display{
        display: none;
    }
</style>
<div class="mostrar-imagenes" x-data="crudImagenes();" x-init="iniciar">
    <!-- Botón para mostrar/ocultar el formulario -->
    <div class="mb-4">
        <button @click="toggleForm" 
                class="bg-[#31b0d5] text-white py-2 px-4 rounded-lg shadow hover:bg-blue-600 transition focus:outline-none focus:ring-2 focus:ring-blue-500">
            <span x-text="showForm ? 'Ocultar formulario' : 'Agregar imagen'"></span>
        </button>
    </div>
    
    <!-- Formulario con transición de mostrar/ocultar -->
    <div x-show="showForm" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         class="space-y-4 bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="flex flex-col space-y-2">
            <label for="imagenes" class="text-sm font-medium text-gray-700">Imágenes</label>
            <input type="text" name="descripcion" x-model="data.descripcion"
                class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Descripción" />
        </div>
        <div class="flex flex-col space-y-2">
            <input type="file" name="imagen" id="imagen"
                class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                 />
        </div>
        <div class="flex flex-col space-y-2">
            <input hidden type="text" name="docidpa" x-model="data.idpa"
                class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="ID del Documento" />
        </div>
        <div class="flex justify-between">
            <button @click="agregar"
                class="bg-[#31b0d5] text-white py-2 px-4 rounded-lg shadow hover:bg-blue-600 transition focus:outline-none focus:ring-2 focus:ring-blue-500">
                Guardar
            </button>
            <button @click="toggleForm"
                class="bg-gray-300 text-gray-700 py-2 px-4 rounded-lg shadow hover:bg-gray-400 transition focus:outline-none focus:ring-2 focus:ring-gray-500">
                Cancelar
            </button>
        </div>
    </div>
    
    <section class="contenedor-imagenes">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <template x-for="imagen in imagenes" :key="imagen.id">
                <div class="relative bg-white p-4 rounded-lg shadow-md">
                    <div class="descripcion text-sm text-gray-700 mt-2">
                        <p x-text="imagen.descripcion" class="text-center"></p>
                    </div>
                    
                    <!-- Botón Eliminar en la esquina superior derecha de la imagen -->
                    <button @click="borrar(imagen.id,imagen.nomfile)"
                        class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded-full shadow hover:bg-red-600 transition focus:outline-none focus:ring-2 focus:ring-red-500 z-10">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    
                    <!-- Botón Lupa en la esquina superior izquierda de la imagen -->
                    <button @click="openLightbox(imagen.nomfile)"
                        class="absolute top-2 left-2 bg-[#31b0d5] text-white p-2 rounded-full shadow hover:bg-blue-600 transition focus:outline-none focus:ring-2 focus:ring-blue-500 z-10">
                        <i class="fas fa-search"></i>
                    </button>

                    <img :src="'../../backend/img/subidas/' + imagen.nomfile" alt="Imagen"
                        class="w-full h-48 object-cover rounded-lg transition hover:opacity-90" />

                    <div class="acciones mt-4">
                        <button @click="descargarImagen(imagen.nomfile)"
                            class="w-full bg-[#31b0d5] text-white py-2 rounded-lg shadow hover:bg-blue-600 transition focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Descargar
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </section>
    
    <!-- Lightbox Modal -->
    <div id="modal-lightbox" x-show="lightboxOpen" 

         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.away="closeLightbox"
         @keydown.escape.window="closeLightbox"
         class="fixed modal-display inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 p-4">
        <div class="relative max-w-4xl w-full bg-white rounded-lg overflow-hidden" @click.stop>
            <div class="absolute top-0 right-0 p-4">
                <button @click="closeLightbox" class="text-gray-800 hover:text-gray-600 focus:outline-none">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div class="p-2">
                <img :src="'../../backend/img/subidas/' + currentImage" alt="Imagen ampliada" 
                     class="w-full object-contain" style="max-height: 80vh;" />
            </div>
            <div class="p-4 bg-white">
                <p x-text="getImageDescription()" class="text-center text-gray-700"></p>
            </div>
        </div>
    </div>
</div>

<script>
    function crudImagenes() {
        let idpa = new URLSearchParams(window.location.search).get('id');
        return {
            imagenes: [],
            showForm: false, // Estado para controlar la visibilidad del formulario
            lightboxOpen: false, // Estado para controlar la visibilidad del lightbox
            currentImage: '', // Imagen actual mostrada en el lightbox
            data: {
                descripcion: '',
                idpa: idpa
            },
            url: '../../backend/ajax/imagenes/',
            iniciar: function () {
                this.leer();
            },
            toggleForm: function() {
                this.showForm = !this.showForm;
                if (!this.showForm) {
                    // Limpiar el formulario al cerrarlo
                    this.data.descripcion = '';
                    document.getElementById('imagen').value = '';
                }
            },
            openLightbox: function(imageName) {
                let modal = document.getElementById('modal-lightbox');
                modal.classList.remove('modal-display');
                this.currentImage = imageName;
                this.lightboxOpen = true;
                // Añadir clase al body para evitar scroll
                document.body.classList.add('overflow-hidden');
            },
            closeLightbox: function() {
                this.lightboxOpen = false;
                // Remover clase del body para permitir scroll
                document.body.classList.remove('overflow-hidden');
            },
            getImageDescription: function() {
                // Buscar la descripción de la imagen actual
                const imagen = this.imagenes.find(img => img.nomfile === this.currentImage);
                return imagen ? imagen.descripcion : '';
            },
            agregar: function () {
                let imagenes = document.getElementById('imagen').files;
                if (imagenes.length === 0) {
                    Swal.fire('Error', 'Debe seleccionar al menos una imagen', 'error');
                    return;
                }
                
                let formData = new FormData();
                for (let i = 0; i < imagenes.length; i++) {
                    formData.append('imagen', imagenes[i]);
                }
                formData.append('idpa', this.data.idpa);
                formData.append('descripcion', this.data.descripcion);
                
                fetch(this.url + '/add_imagen.php', {
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire('Imagen agregada', 'La imagen ha sido agregada correctamente', 'success');
                            this.leer();
                            this.toggleForm(); // Ocultar el formulario después de agregar
                        } else {
                            Swal.fire('Error', data.message || 'Error al subir la imagen', 'error');
                        }
                    }).catch(error => {
                        console.error('Error al subir la imagen:', error);
                        Swal.fire('Error', 'Ha ocurrido un error al procesar la solicitud', 'error');
                    });
            },
            leer: function () {
                fetch(this.url + `/get_imagenes.php?id=${idpa}`).then(response => response.json())
                    .then(data => {
                        this.imagenes = data.data;
                    }).catch(error => {
                        console.error('Error al obtener las imágenes:', error);
                    });
            },
            borrar: function(idImagen,nameImg) {
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
                        fetch(this.url + `/eliminar_imagen.php?id=${idImagen}&name=${nameImg}`).then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    Swal.fire('Imagen eliminada', 'La imagen ha sido eliminada correctamente', 'success');
                                    this.leer();
                                } else {
                                    Swal.fire('Error', data.message, 'error');
                                }
                            }).catch(error => {
                                console.error('Error al eliminar la imagen:', error);
                                Swal.fire('Error', 'Ha ocurrido un error al procesar la solicitud', 'error');
                            });
                    }
                });
            },
            descargarImagen: function(imagen) {
                try {
                    let a = document.createElement('a');
                    a.href = `../../backend/img/subidas/${imagen}`;
                    a.download = imagen;
                    a.click();
                } catch (error) {
                    console.error('Error al descargar la imagen:', error);
                    Swal.fire('Error', 'No se pudo descargar la imagen', 'error');
                }
            }
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />