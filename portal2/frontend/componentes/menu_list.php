<div class="imagen">
    <img src="../imagenes/logo-dentalcor-blanco.png" alt="Logo" class="logo" />

</div>
<ul class="side-menu">
    <li><a href="../admin/escritorio.php"><i class='bx bxs-dashboard icon'></i> Escritorio</a></li>

    <!-- Menú Citas -->
    <li x-data="{ 
        isOpen: window.location.pathname.includes('/citas'), 
        activeItem: window.location.pathname 
    }">
        <a href="#" :class="{ 'active': isOpen }">
            <i class='bx bxs-book-alt icon'></i> Citas <i class='bx bx-chevron-right icon-right'></i>
        </a>
        <ul :class="{ 'show': isOpen }" class="side-dropdown">
            <li><a href="../citas/mostrar.php" :class="{ 'open': activeItem.includes('/citas/mostrar.php') }">Todas las
                    citas</a></li>
            <li><a href="../citas/nuevo.php" :class="{ 'open': activeItem.includes('/citas/nuevo.php') }">Nueva</a></li>
            <li><a href="../citas/calendario.php"
                    :class="{ 'open': activeItem.includes('/citas/calendario.php') }">Calendario</a></li>
        </ul>
    </li>

    <!-- Menú Pacientes -->
    <li x-data="{ 
        isOpen: window.location.pathname.includes('/pacientes'), 
        activeItem: window.location.pathname 
    }">
        <a href="#" :class="{ 'active': isOpen }">
            <i class='bx bxs-user icon'></i> Pacientes <i class='bx bx-chevron-right icon-right'></i>
        </a>
        <ul :class="{ 'show': isOpen }" class="side-dropdown">
            <li><a href="../pacientes/mostrar.php"
                    :class="{ 'open': activeItem.includes('/pacientes/mostrar.php') }">Lista de pacientes</a></li>
            <li><a href="../pacientes/pagos.php"
                    :class="{ 'open': activeItem.includes('/pacientes/pagos.php') }">Pagos</a></li>
            <li><a href="../pacientes/historial.php"
                    :class="{ 'open': activeItem.includes('/pacientes/historial.php') }">Historial de los pacientes</a>
            </li>
         
        </ul>
    </li>

    <!-- Menú Médicos -->
    <li x-data="{ 
        isOpen: window.location.pathname.includes('/medicos'), 
        activeItem: window.location.pathname 
    }">
        <a href="#" :class="{ 'active': isOpen }">
            <i class='bx bxs-briefcase icon'></i> Médicos <i class='bx bx-chevron-right icon-right'></i>
        </a>
        <ul :class="{ 'show': isOpen }" class="side-dropdown">
            <li><a href="../medicos/mostrar.php" :class="{ 'open': activeItem.includes('/medicos/mostrar.php') }">Lista
                    de médicos</a></li>
            <li><a href="../medicos/historial.php"
                    :class="{ 'open': activeItem.includes('/medicos/historial.php') }">Historial de los médicos</a></li>
        </ul>
    </li>



    <!-- Menú Actividades Financieras -->
    <li x-data="{ 
        isOpen: window.location.pathname.includes('/actividades'), 
        activeItem: window.location.pathname 
    }">
        <a href="#" :class="{ 'active': isOpen }">
            <i class='bx bxs-diamond icon'></i> Actividades Financieras <i class='bx bx-chevron-right icon-right'></i>
        </a>
        <ul :class="{ 'show': isOpen }" class="side-dropdown">
            <li><a href="../actividades/mostrar.php"
                    :class="{ 'open': activeItem.includes('/actividades/mostrar.php') }">Pagos</a></li>
            <li><a href="../actividades/nuevo.php"
                    :class="{ 'open': activeItem.includes('/actividades/nuevo.php') }">Gastos</a></li>
            <li><a href="../actividades/categorias.php"
                    :class="{ 'open': activeItem.includes('/actividades/categorias.php') }">Categorias</a></li>
        </ul>
    </li>

    <!-- Menú Medicina
    <li x-data="{ 
        isOpen: window.location.pathname.includes('/medicinas'), 
        activeItem: window.location.pathname 
    }">
        <a href="#" :class="{ 'active': isOpen }">
            <i class='bx bxs-spray-can icon'></i> Medicina <i class='bx bx-chevron-right icon-right'></i>
        </a>
        <ul :class="{ 'show': isOpen }" class="side-dropdown">
            <li><a href="../medicinas/venta.php"
                    :class="{ 'open': activeItem.includes('/medicinas/venta.php') }">Vender</a></li>
            <li><a href="../medicinas/mostrar.php"
                    :class="{ 'open': activeItem.includes('/medicinas/mostrar.php') }">Listado</a></li>
            <li><a href="../medicinas/nuevo.php"
                    :class="{ 'open': activeItem.includes('/medicinas/nuevo.php') }">Nueva</a></li>
            <li><a href="../medicinas/categoria.php"
                    :class="{ 'open': activeItem.includes('/medicinas/categoria.php') }">Categoría</a></li>
        </ul>
    </li> -->

    <!-- Menú Ajustes -->
    <li x-data="{ 
        isOpen: window.location.pathname.includes('/ajustes'), 
        activeItem: window.location.pathname 
    }">
        <a href="#" :class="{ 'active': isOpen }">
            <i class='bx bxs-cog icon'></i> Ajustes <i class='bx bx-chevron-right icon-right'></i>
        </a>
        <ul :class="{ 'show': isOpen }" class="side-dropdown">
            <li><a href="../ajustes/mostrar.php"
                    :class="{ 'open': activeItem.includes('/ajustes/mostrar.php') }">Ajustes</a></li>

            <li><a href="../ajustes/base.php" :class="{ 'open': activeItem.includes('/ajustes/base.php') }">Base de
                    datos</a></li>
        </ul>
    </li>

    <!-- Menú Perfil -->
    <li x-data="{ 
        isOpen: window.location.pathname.includes('/profile'), 
        activeItem: window.location.pathname 
    }">
        <a href="#" :class="{ 'active': isOpen }">
            <i class='bx bxs-user icon'></i> Perfil <i class='bx bx-chevron-right icon-right'></i>
        </a>
        <ul :class="{ 'show': isOpen }" class="side-dropdown">
            <li><a href="../profile/mostrar.php" :class="{ 'open': activeItem.includes('/profile/mostrar.php') }">Mi
                    cuenta</a></li>
            <li><a href="../salir.php">Logout</a></li>
        </ul>
    </li>
</ul>