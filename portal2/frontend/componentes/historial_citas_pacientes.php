<style>
  .contenedor-citas {
  display: grid;
  grid-template-columns: repeat(3, 1fr); /* 3 columnas iguales en escritorio */
  gap: 16px; /* Espaciado entre elementos, opcional */
}

@media (max-width: 768px) { /* Ajuste para pantallas móviles */
  .contenedor-citas {
    grid-template-columns: 1fr; /* 1 columna en móviles */
  }
}

</style>

<div x-data="{
    events: [],
    async init() {
        try {
            const response = await fetch(`../../backend/ajax/citas/get_citaspacientes.php?id=${new URLSearchParams(window.location.search).get('id')}`);
            const data = await response.json();
            this.events = data.data; // Actualizar los eventos
        } catch (error) {
            console.error('Error al cargar los eventos:', error);
        }
    }
}" class="contenedor-citas" x-init="init()">
  <template x-for="event in events" :key="event.id">
    <div
      class="cards-citas bg-white shadow-lg rounded-lg p-6 border border-gray-200 hover:shadow-xl transition-all duration-300">
      <p class="text-gray-800 font-semibold text-lg">
        <strong class="text-indigo-500">Motivo:</strong>
        <span x-text="event.title"></span>
      </p>

      <p class="text-gray-600 mt-3 text-sm">
        <strong class="text-gray-700">Fecha:</strong>
        <span x-text="`${event.day_of_week}, ${event.start}`"></span>
      </p>

      <p class="text-gray-600 mt-3 text-sm">
        <strong class="text-gray-700">Nombre del doctor:</strong>
        <span x-text="event.doctor_name"></span>
      </p>

      <p class="text-gray-600 mt-3 text-sm">
        <strong class="text-gray-700">Apellido del doctor:</strong>
        <span x-text="event.doctor_lastname"></span>
      </p>

      <p class="text-gray-600 mt-3 text-sm">
        <strong class="text-gray-700">Monto:</strong>
        <span x-text="event.monto"></span>
      </p>
      <template x-if="event.chec === '1'">
        <p class="text-gray-600 mt-3 text-sm">
          <strong class="text-gray-700">Estado del pago:</strong>
          <i class="fas fa-check text-green-500"></i>
        </p>
      </template>
      <template x-if="!event.chec">
        <p class="text-gray-600 mt-3 text-sm">
          <strong class="text-gray-700">Estado del pago:</strong>
          <i class="fas fa-times text-red-500"></i>
        </p>
      </template>
    </div>


  </template>
  <template x-if="events.length === 0">
    <p class="alert alert-warning">No hay citas registradas</p>
  </template>
</div>