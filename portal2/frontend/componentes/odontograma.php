<!-- Font Awesome -->
<style>
    .botones-odontograma button {

        gap: 8px;
        /* Espacio entre el icono y el texto */
        background-color: #008DD2;
        /* Color de fondo */
        color: white;
        /* Color de texto */
        border: none;
        /* Sin bordes */
        border-radius: 8px;
        /* Bordes redondeados */
        padding: 10px 16px;
        /* Espaciado interno */
        font-size: 14px;
        /* Tamaño de fuente */
        font-family: Arial, sans-serif;
        /* Fuente */
        cursor: pointer;
        /* Cambiar el cursor al pasar */
        margin: 1px 2px;
        transition: all 0.3s ease;
        /* Animación para el hover */
    }

    .botones-odontograma button:hover {
        background-color: #005F8A;
        /* Color más oscuro al pasar */
        transform: translateY(-2px);
        /* Levantar el botón */
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        /* Sombra suave */
    }

    .botones-odontograma button:active {
        transform: translateY(0);
        /* Volver al estado normal al presionar */
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
        /* Sombra más sutil */
    }

    .botones-odontograma button i {
        font-size: 18px;
        /* Tamaño del icono */
    }

    .botones-odontograma {
        width: 100%;
        max-width: 100%;
    }

    .botones-odontograma {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
    }

    /* Adaptabilidad para pantallas más pequeñas */
    @media (max-width: 600px) {
        .botones-odontograma button {
            font-size: 12px;
            /* Reducir el tamaño del texto */
            padding: 8px 12px;
            /* Ajustar el espaciado interno */
        }

        .botones-odontograma button i {
            font-size: 16px;
            /* Ajustar el tamaño del icono */
        }
    }

    section.odontograma-gral {
        display: block;
        margin: 0 auto;
        width: 100%;
        margin: 0 auto;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    a#guardar-odontograma {
        background: wheat;
        color: white;
        padding: 20px;
        margin: 10px !important;
        cursor: pointer;
    }

    .botones-odontograma {
        margin: 5px 0px 26px;
        padding: 10px
    }






    .guardar-cambios {
        padding: 1em 2em;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        letter-spacing: 5px;
        text-transform: uppercase;
        cursor: pointer;
        color: #2c9caf;
        transition: all 1000ms;
        font-size: 15px;
        position: relative;
        overflow: hidden;
        outline: 2px solid #2c9caf;
    }

    .guardar-cambios:hover {
        color: #ffffff;
        transform: scale(1.1);
        outline: 2px solid #70bdca;
        box-shadow: 4px 5px 17px -4px #268391;
    }

    .guardar-cambios::before {
        content: "";
        position: absolute;
        left: -50px;
        top: 0;
        width: 0;
        height: 100%;
        background-color: #2c9caf;
        transform: skewX(45deg);
        z-index: -1;
        transition: width 1000ms;
    }

    .guardar-cambios:hover::before {
        width: 250%;
    }


    /* Asegurar que el contenido oculto no deje espacio en la impresión */
    .hidden-print {
        display: none;
    }
    canvas#odontogram {
    width: 100% !important;
    max-width: 900px;
}
</style>



    <section class="odontograma-gral">
        <h3>Odontograma del Paciente</h3>



        <div class="botones-odontograma" x-bind:class="{ 'hidden-print': hideSection }">


            <button type="button" id="ODONTOGRAM_MODE_HAPUS" title="Borrar">
                <i class="fas fa-eraser"></i> Borrar
            </button>

            <button type="button" id="ODONTOGRAM_MODE_FIS">Restauracion existente</button>
            <button type="button" id="ODONTOGRAM_MODE_AMF" title="Amalgama">
                Restauracion Requerida
            </button>
            <button type="button" id="ODONTOGRAM_MODE_CARIES" title="Caries">
                Restauracion filtrada
            </button>

            <button type="button" id="ODONTOGRAM_MODE_POC" title="Pérdida ósea">
                Corona existente
            </button>
            <button type="button" id="ODONTOGRAM_MODE_NVT">Corona requerida</button>

            <button type="button" id="ODONTOGRAM_MODE_MIS" title="Misión">
                Extraccion requerida

            </button>
            <button type="button" id="ODONTOGRAM_MODE_ANO" title="Anomalía">
                Extraccion existente
            </button>



            <button type="button" id="ODONTOGRAM_MODE_RCT" title="Tratamiento de conductos">
                Tratamiento de conducto
            </button>
            <button type="button" id="ODONTOGRAM_MODE_PRE" title="Prótesis removible">
                Prótesis
            </button>

            <button type="button" id="ODONTOGRAM_MODE_BRIDGE" title="Puente">
                Puente
            </button>
            <button type="button" id="ODONTOGRAM_MODE_FMC">Protesis removible</button>




            <button type="button" id="ODONTOGRAM_MODE_ARROW_TOP_LEFT" title="Flecha superior izquierda">
                <i class="fas fa-arrow-up-left"></i> Arriba Izq.
            </button>
            <button type="button" id="ODONTOGRAM_MODE_ARROW_TOP_RIGHT" title="Flecha superior derecha">
                <i class="fas fa-arrow-up-right"></i> Arriba Der.
            </button>
            <button type="button" id="ODONTOGRAM_MODE_ARROW_TOP_TURN_LEFT" title="Giro arriba izquierda">
                <i class="fas fa-undo-alt"></i> Giro Izq.
            </button>
            <button type="button" id="ODONTOGRAM_MODE_ARROW_TOP_TURN_RIGHT" title="Giro arriba derecha">
                <i class="fas fa-redo-alt"></i> Giro Der.
            </button>
            <button type="button" id="ODONTOGRAM_MODE_ARROW_BOTTOM_LEFT" title="Flecha inferior izquierda">
                <i class="fas fa-arrow-down-left"></i> Abajo Izq.
            </button>
            <button type="button" id="ODONTOGRAM_MODE_ARROW_BOTTOM_RIGHT" title="Flecha inferior derecha">
                <i class="fas fa-arrow-down-right"></i> Abajo Der.
            </button>
            <button type="button" id="ODONTOGRAM_MODE_ARROW_BOTTOM_TURN_LEFT" title="Giro abajo izquierda">
                <i class="fas fa-undo-alt"></i> Giro Izq.
            </button>
            <button type="button" id="ODONTOGRAM_MODE_ARROW_BOTTOM_TURN_RIGHT" title="Giro abajo derecha">
                <i class="fas fa-redo-alt"></i> Giro Der.
            </button>

        </div>
        <div x-bind:class="{ 'hidden-print': hideSection }">
            <button id="guardar-odontograma" class="guardar-cambios">Guardar</button>

        </div>
        <canvas id="odontogram" style="margin-top: 15px;">
            Browser anda tidak support canvas, silahkan update browser anda.
        </canvas>
        <br>
    </section>

<script type="text/javascript">
    $("#odontogram").odontogram('init', {
        width: "900px",
        height: "420px"
    });
    // Obtener el ID del paciente, puede ser dinámico o estático
    const urlParams = new URLSearchParams(window.location.search);
    const idpa = urlParams.get('id');
    async function obtenerOdontograma() {
        try {
            const response = await fetch(`../../backend/ajax/get_odontograma.php?idpa=${idpa}`);

            if (!response.ok) {
                throw new Error(`Error al obtener los datos del odontograma: ${response.statusText}`);
            }

            const data = await response.json();

            if (data.success && data.data.registros && Object.keys(data.data.registros).length > 0) {
                let datosDientes = data.data.registros;

                $("#odontogram").odontogram('setGeometry', datosDientes);
            } else {
                $("#odontogram").odontogram('setGeometryByPos', []);
            }
        } catch (error) {
            $("#odontogram").odontogram('setGeometryByPos', []);

        }
    }


    // Llamar a la función para obtener los datos
    obtenerOdontograma();


    // Llamar a la función para obtener los datos
    obtenerOdontograma();


    let result = {}; // Cambié a un objeto porque parece que 'geometry' es un objeto y no un array

    // Escuchar cambios en el odontograma
    $('#odontogram').on('change', function (_, geometry) {

        // Asignar el objeto 'geometry' a 'result'
        result = { ...geometry }; // Usamos spread para hacer una copia de 'geometry'

    });

    $('#guardar-odontograma').on('click', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const idpa = urlParams.get('id');
        if (Object.keys(result).length > 0) {  // Comprobar si 'result' tiene datos
            const fechaCliente = new Date().toISOString(); // Capturar la fecha del cliente en formato ISO

            $.ajax({
                url: '../../backend/ajax/update_odontograma.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    idpa: idpa,
                    datos: result,
                    fecha_modificacion: fechaCliente // Incluir la fecha en la solicitud
                }),
                success: function (data) {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Datos guardados correctamente.',
                            confirmButtonText: 'Aceptar'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al guardar los datos.',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    alert('Error al conectar con el servidor.');
                }
            });
        } else {
            alert('No hay datos para guardar.');
        }
    });



    $('#odontogram').odontogram();



    $("#ODONTOGRAM_MODE_HAPUS").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_HAPUS);
    });
    $("#ODONTOGRAM_MODE_DEFAULT").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_DEFAULT);
    });
    $("#ODONTOGRAM_MODE_AMF").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_AMF);
    });
    $("#ODONTOGRAM_MODE_COF").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_COF);
    });
    $("#ODONTOGRAM_MODE_FIS").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_FIS);
    });
    $("#ODONTOGRAM_MODE_NVT").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_NVT);
    });
    $("#ODONTOGRAM_MODE_RCT").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_RCT);
    });
    $("#ODONTOGRAM_MODE_NON").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_NON);
    });
    $("#ODONTOGRAM_MODE_UNE").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_UNE);
    });
    $("#ODONTOGRAM_MODE_PRE").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_PRE);
    });
    $("#ODONTOGRAM_MODE_ANO").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_ANO);
    });
    $("#ODONTOGRAM_MODE_CARIES").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_CARIES);
    });
    $("#ODONTOGRAM_MODE_CFR").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_CFR);
    });
    $("#ODONTOGRAM_MODE_FMC").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_FMC);
    });
    $("#ODONTOGRAM_MODE_POC").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_POC);
    });
    $("#ODONTOGRAM_MODE_RRX").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_RRX);
    });
    $("#ODONTOGRAM_MODE_MIS").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_MIS);
    });
    $("#ODONTOGRAM_MODE_IPX").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_IPX);
    });
    $("#ODONTOGRAM_MODE_FRM_ACR").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_FRM_ACR);
    });
    $("#ODONTOGRAM_MODE_BRIDGE").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_BRIDGE);
    });
    $("#ODONTOGRAM_MODE_ARROW_TOP_LEFT").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_ARROW_TOP_LEFT);
    })
    $("#ODONTOGRAM_MODE_ARROW_TOP_RIGHT").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_ARROW_TOP_RIGHT);
    })
    $("#ODONTOGRAM_MODE_ARROW_TOP_TURN_LEFT").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_ARROW_TOP_TURN_LEFT);
    })
    $("#ODONTOGRAM_MODE_ARROW_TOP_TURN_RIGHT").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_ARROW_TOP_TURN_RIGHT);
    })
    $("#ODONTOGRAM_MODE_ARROW_BOTTOM_LEFT").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_ARROW_BOTTOM_LEFT);
    })
    $("#ODONTOGRAM_MODE_ARROW_BOTTOM_RIGHT").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_ARROW_BOTTOM_RIGHT);
    })
    $("#ODONTOGRAM_MODE_ARROW_BOTTOM_TURN_LEFT").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_ARROW_BOTTOM_TURN_LEFT);
    })
    $("#ODONTOGRAM_MODE_ARROW_BOTTOM_TURN_RIGHT").click(function () {
        $("#odontogram").odontogram('setMode', ODONTOGRAM_MODE_ARROW_BOTTOM_TURN_RIGHT);
    })

    $("#download").click(function () {
        window.open($("#odontogram").odontogram('getDataURL'));
    })


</script>