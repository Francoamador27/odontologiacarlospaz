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
<style>
    button.guardar-categoria {
        background: white;
        padding: 10px 20px;
        color: black;
        border-radius: 10px;
    }

    /* From Uiverse.io by gharsh11032000 */
    .form-container {
        width: 400px;
        background: linear-gradient(#1a87a7, #1a87a7) padding-box, linear-gradient(145deg, transparent 35%, #e81cff, #40c9ff) border-box;
        border: 2px solid transparent;
        padding: 32px 24px;
        font-size: 14px;
        font-family: inherit;
        color: white;
        display: flex;
        flex-direction: column;
        gap: 20px;
        box-sizing: border-box;
        border-radius: 16px;
    }

    .form-container textarea {
        min-height: 100px;
        resize: vertical;
        color: black;
    }

    .form-container button:active {
        scale: 0.95;
    }

    .form-container .form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .form-container .form-group {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .form-container .form-group label {
        display: block;
        margin-bottom: 5px;
        color: #717171;
        font-weight: 600;
        font-size: 12px;
    }

    .form-container .form-group input {
        width: 100%;
        padding: 12px 16px;
        border-radius: 8px;
        color: #fff;
        font-family: inherit;
        background-color: transparent;
        border: 1px solid #414141;
    }

    .form-container .form-group textarea {
        width: 100%;
        padding: 12px 16px;
        border-radius: 8px;
        resize: none;
        color: #fff;
        height: 96px;
        border: 1px solid #414141;
        background-color: transparent;
        font-family: inherit;
    }

    .form-container .form-group input::placeholder {
        opacity: 0.5;
    }

    .form-container .form-group input:focus {
        outline: none;
        border-color: #e81cff;
    }

    .form-container .form-group textarea:focus {
        outline: none;
        border-color: #e81cff;
    }

    .form-container .form-submit-btn {
        display: flex;
        align-items: flex-start;
        justify-content: center;
        align-self: flex-start;
        font-family: inherit;
        color: #717171;
        font-weight: 600;
        width: 40%;
        background: #313131;
        border: 1px solid #414141;
        padding: 12px 16px;
        font-size: inherit;
        gap: 8px;
        margin-top: 8px;
        cursor: pointer;
        border-radius: 6px;
    }

    .form-container .form-submit-btn:hover {
        background-color: #fff;
        border-color: #fff;
    }

    input#nombre_categoria {
        color: black;
    }
</style>

<body>

    <!-- SIDEBAR -->
    <?php include('../componentes/sidebar.php') ?>
    <section id="content">

        <div class="contenedor-categorias">

            <section class="categorias-listado">

                <div x-data="categoriasApp()" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-init="iniciar">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Listado de Categorías</h2>

                    <div class="overflow-hidden bg-white shadow rounded-lg">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-2 px-4 text-left text-sm font-semibold text-gray-900">Nombre de la
                                        Categoría</th>
                                    <th class="py-2 px-4 text-left text-sm font-semibold text-gray-900">Detalle</th>
                                    <th class="py-2 px-4 text-left text-sm font-semibold text-gray-900">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí se mostrarán las categorías -->
                                <template x-for="categoria in categorias" :key="categoria.id">
                                    <tr class="border-b">
                                        <td class="py-2 px-4 text-sm text-gray-900" x-text="categoria.nombre_categoria">
                                        </td>
                                        <td class="py-2 px-4 text-sm text-gray-900"
                                            x-text="categoria.detalle_categoria"></td>
                                        <td class="py-2 px-4 text-sm">
                                            <button @click="eliminarCategoria(categoria.id)"
                                                class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <section class="max-w-3xl mx-auto my-8 p-6 bg-white rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6">Crear Nueva Categoría</h2>
        
                        <div class="space-y-4 md:space-y-0  md:gap-4 items-end">
                            <div class="flex-1">
                                <label for="nombre_categoria" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la
                                    categoría</label>
                                <input type="text" x-model="data.nombre_categoria" id="nombre_categoria"
                                    placeholder="Ej: Servicios Dentales" class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm shadow-sm 
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                               placeholder-gray-400 transition-colors">
                            </div>
        
                            <div class="flex-1">
                                <label for="detalle_categoria" class="block text-sm font-medium text-gray-700 mb-1">Detalle de
                                    la categoría</label>
                                <input type="text" x-model="data.detalle_categoria" id="detalle_categoria"
                                    placeholder="Ej: Servicios relacionados con tratamientos dentales" class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm shadow-sm 
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                               placeholder-gray-400 transition-colors">
                            </div>
        
                            <div class="md:self-end">
                                <button @click="agregar" class="w-full md:w-auto px-5 py-2 bg-blue-600 text-white font-medium rounded-md 
                               hover:bg-blue-700 active:bg-blue-800 
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 
                               transition-colors duration-200 transform hover:scale-105">
                                    <span class="flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Crear Categoría
                                    </span>
                                </button>
                            </div>
                        </div>
                    </section>
                </div>


            </section>
            <!-- Botón para abrir el modal -->






    </section>

</body>
<script>
    function categoriasApp() {
    return {
        categorias: [],
        data: {
            nombre_categoria: '',
            detalle_categoria: ''
        },
        obtenerCategorias: async function () {
            try {
                const response = await fetch('../../backend/ajax/actividades/get_categorias.php');
                const data = await response.json();
                if (data.success) {
                    this.categorias = data.data;
                } else {
                    alert('No se pudieron obtener las categorías.');
                }
            } catch (error) {
                console.error('Error al obtener las categorías:', error);
            }
        },
        agregar: async function () {
            // Validación básica
            if (!this.data.nombre_categoria.trim()) {
                alert('Por favor, ingresa el nombre de la categoría');
                return;
            }
            
            try {
                const response = await fetch('../../backend/ajax/actividades/agregar_categorias.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.data)
                });
                const result = await response.json();
                if (result.success) {
                    Swal.fire({
                        title: 'Categoría guardada',
                        icon: 'success'
                    });
                    this.obtenerCategorias(); // Actualizar el listado
                    this.data.nombre_categoria = '';
                    this.data.detalle_categoria = '';
                } else {
                    Swal.fire({
                        title: 'No se pudo guardar la categoria',
                        icon: 'error'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error en la solicitud');
            }
        },
        eliminarCategoria: async function (idCategoria) {
            const confirmacion = await Swal.fire({
            title: '¿Estás seguro de que deseas eliminar esta categoría?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
            });

            if (confirmacion.isConfirmed) {
            try {
                const response = await fetch(`../../backend/ajax/actividades/eliminar_categoria.php?id_categoria=${idCategoria}`, {
                method: 'GET'
                });
                const data = await response.json();

                if (data.status === 'success') {
                Swal.fire({
                    title: 'Categoría eliminada',
                    icon: 'success'
                }); 
                this.obtenerCategorias(); // Actualizar el listado
                } else {
                Swal.fire({
                    title: 'Error',
                    text: data.message || 'Error desconocido',
                    icon: 'error'
                });
                }
            } catch (error) {
                console.error('Error al eliminar la categoría:', error);
                Swal.fire({
                title: 'Error',
                text: 'Error de conexión al eliminar la categoría',
                icon: 'error'
                });
            }
            }
        },
        iniciar: function () {
            this.obtenerCategorias();
        }
    };
}
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
