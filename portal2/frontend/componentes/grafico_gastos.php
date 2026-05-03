<?php
$total = 0;
if (isset($_GET['mes']) && is_numeric($_GET['mes'])) {
    $mes = isset($_GET['mes']) ? $_GET['mes'] : date('m'); // Obtener el mes actual en formato numérico (01-12)
    $anio = isset($_GET['anio']) ? $_GET['anio'] : date('Y'); // Si no se pasa el año, por defecto será el año actual
    $mes = (int) $mes;

    $sql = "SELECT SUM(monto) AS total FROM events WHERE MONTH(start) = :mes AND YEAR(start) = :anio";
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':anio', $anio, PDO::PARAM_INT);

    $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
    $stmt->execute();
    $total = $stmt->fetchColumn() ?: 0;
}
?>
<?php
// Consulta para obtener los años únicos desde el campo 'start'
$sql = "SELECT DISTINCT YEAR(start) AS anio FROM events ORDER BY anio DESC";
$stmt = $connect->prepare($sql);
$stmt->execute();
$anios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener el año seleccionado, si está presente en la URL
$anioSeleccionado = isset($_GET['anio']) ? $_GET['anio'] : date('Y'); // Predeterminado al año actual
?>
<div x-data="appGraficos()" x-init="iniciar()">

    <div
        class="flex flex-col items-center justify-center w-full max-w-3xl mx-auto px-4 py-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl shadow-lg">

        <div class="w-full max-w-md">
            <label for="selectMes" class="block text-center text-lg font-semibold text-blue-700 mb-3">
                Estadisticas mensuales
            </label>

            <div class="relative">
                <select id="selectMes" x-model="mesFiltro" @change="filtrarPorMes()"
                    class="appearance-none w-full px-5 py-3 text-center text-lg font-medium text-blue-800 bg-white border-2 border-blue-300 rounded-lg shadow-sm hover:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-50 transition duration-200 cursor-pointer">
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

                <!-- Flecha personalizada para el select -->
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-blue-700">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div id="chart">
    </div>
</div>
<script>
    function appGraficos() {
        return {
            ingresos: 0,
            gastos: 0,
            mesFiltro: (new Date().getMonth() + 1).toString().padStart(2, '0'),
            chart: null, // Para almacenar la referencia al gráfico

            filtrarPorMes() {
                // Destruir el gráfico existente si hay uno
                if (this.chart) {
                    this.chart.destroy();
                }
                // Recargar datos y renderizar nuevo gráfico
                this.cargarDatos();
            },

            async getGastos() {
                try {
                    // Añadir el parámetro de mes a la URL
                    const url = `../../backend/ajax/actividades/get_gastos.php?mes=${this.mesFiltro}`;
                    const response = await fetch(url);
                    const data = await response.json();

                    if (data.success) {
                        console.log('data gastos', data.data);
                        const totalGastos = data.data.reduce((total, gasto) =>
                            total + parseFloat(gasto.importe || 0), 0
                        );
                        console.log('totalGastos', totalGastos);
                        this.gastos = totalGastos;
                    } else {
                        console.error('Error al obtener gastos:', data.message);
                        this.gastos = 0; // Asignar 0 en caso de error
                    }
                } catch (error) {
                    console.error('Error en la solicitud de gastos:', error);
                    this.gastos = 0; // Asignar 0 en caso de error
                }
            },

            async getIngresos() {
                try {
                    // Añadir el parámetro de mes a la URL para obtener los ingresos del mes seleccionado
                    const url = `../../backend/ajax/actividades/get_pagos.php?mes=${this.mesFiltro}`;
                    const response = await fetch(url);
                    const data = await response.json();

                    if (data.success) {
                        console.log('data ingresos', data.data);
                        const totalIngresos = data.data.reduce((total, ingreso) =>
                            total + parseFloat(ingreso.monto || 0), 0
                        );
                        console.log('totalIngresos', totalIngresos);
                        this.ingresos = totalIngresos;
                    } else {
                        console.error('Error al obtener ingresos:', data.message);
                        this.ingresos = 0; // Asignar 0 en caso de error
                    }
                } catch (error) {
                    console.error('Error en la solicitud de ingresos:', error);
                    this.ingresos = 0; // Asignar 0 en caso de error

                    // Si hay un error con la ruta de ingresos, podemos intentar usar la misma de gastos
                    // pero debes ajustar esto según tu backend
                    console.log("Intentando obtener ingresos desde otra fuente...");
                    try {
                        const respuesta = await fetch(`../../backend/ajax/actividades/get_gastos.php?tipo=ingreso&mes=${this.mesFiltro}`);
                        const datos = await respuesta.json();
                        if (datos.success) {
                            this.ingresos = datos.data.reduce((total, ingreso) =>
                                total + parseFloat(ingreso.importe || 0), 0
                            );
                            console.log("Ingresos alternativos:", this.ingresos);
                        }
                    } catch (e) {
                        console.error("También falló la fuente alternativa:", e);
                    }
                }
            },

            renderGrafico() {
                // Limpiar el contenedor antes de renderizar
                document.querySelector("#chart").innerHTML = '';

                // Calcular ganancias netas (ingresos - gastos)
                const gananciasNetas = this.ingresos - this.gastos;
                console.log("Ganancias netas calculadas:", gananciasNetas);

                // Determinar nombre del mes para la categoría
                const nombresMeses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                const numeroMes = parseInt(this.mesFiltro, 10) - 1; // Convertir a índice base 0
                const nombreMes = nombresMeses[numeroMes] || 'Total';

                const options = {
                    series: [
                        {
                            name: 'Citas abonadas',
                            data: [this.ingresos]
                        },
                        {
                            name: 'Gastos',
                            data: [this.gastos]
                        },
                        {
                            name: 'Ganancias netas',
                            data: [gananciasNetas]
                        }
                    ],
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            borderRadius: 5,
                            borderRadiusApplication: 'end'
                        },
                    },
                    colors: ['#10B981', '#EF4444', '#3B82F6'], // Verde para ingresos, rojo para gastos, azul para ganancias
                    dataLabels: {
                        enabled: true,
                        formatter: function (val) {
                            // Formatear con separador de miles y dos decimales
                            return '$ ' + val.toLocaleString('es-AR', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: [this.mesFiltro ? nombreMes : 'Total'],
                    },
                    yaxis: {
                        title: {
                            text: '$'
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return "$ " + val.toFixed(2);
                            }
                        }
                    }
                };

                // Crear un nuevo gráfico
                this.chart = new ApexCharts(document.querySelector("#chart"), options);
                this.chart.render();
            },

            async cargarDatos() {
                try {
                    // Cargar todos los datos necesarios
                    await Promise.all([
                        this.getIngresos(),
                        this.getGastos()
                    ]);

                    // Renderizar el gráfico una sola vez después de tener todos los datos
                    this.renderGrafico();
                } catch (error) {
                    console.error("Error al cargar datos:", error);
                    document.querySelector("#chart").innerHTML = '<div class="text-red-500 p-4">Error al cargar los datos del gráfico</div>';
                }
            },

            async iniciar() {
                // Establecer el valor inicial del filtro al mes actual
                this.mesFiltro = (new Date().getMonth() + 1).toString().padStart(2, '0');
                console.log("Mes inicial:", this.mesFiltro);

                // Inicializar todo al cargar la página
                await this.cargarDatos();
            }
        }
    }

</script>