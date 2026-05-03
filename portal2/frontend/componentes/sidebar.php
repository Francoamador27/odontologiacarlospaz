<style>
    .logo-imagen {
        width: 100px;
    }

    .logo-imagen img {
        width: 100%;
    }



    .toggle-icon:hover {
        transform: scale(1.1);
        /* Efecto de agrandamiento al pasar el mouse */
    }
    
</style>

<!-- Contenedor principal con Alpine -->
<div x-data="{ open: false }" class="absolute">

    <!-- Botón para abrir el menú -->
    <button @click="open = true" class="btn menu-button-movile btn-primary m-4">

        <i class="bx bx-menu toggle-icon"></i>
        Menú
    </button>

    <!-- Sidebar -->
    <div class="fixed top-0 left-0 w-64 h-full bg-white shadow-lg z-50 transform transition-transform duration-300"
        :class="{ '-translate-x-full': !open }">
        <div class="p-4">
            <h2 class="text-lg font-bold">Menú</h2>
            <button @click="open = false" class="btn btn-secondary mt-4">
                <i class="bx bx-x close-icon"></i>

            </button>
            <section id="sidebar" class="sidebar sidebar-movile">
                <?php
                include('menu_list.php');
                ?>

            </section>
        </div>
    </div>

    <!-- Overlay oscuro -->
    <div x-show="open" @click="open = false" class="sidebar-overlay" x-cloak></div>

</div>

<section id="sidebar" class="sidebar sidebar-desktop">


    <?php
    include('menu_list.php');
    ?>



</section>