<?php
session_start();
if (!isset($_SESSION['empleado_id'])) {
    header('Location: ../index/index.php');
    exit;
}

$pageTitle = 'Administrativo';

include '../utils/header.php';
include '../conexion.php';

$conexion = mysqli_connect("localhost", "root", "", "radiologia_db");
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}
$sql = "SELECT * FROM especializacion";
$resultado = mysqli_query($conexion, $sql);
?>

<script>
    $(document).ready(function() {
        $('#table_turnos').DataTable({
            "responsive": true, // Diseño adaptable a pantallas pequeñas
            "language": {
                "sProcessing": "<i class='fas fa-spinner fa-spin'></i> Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
                "sSearch": "<i class='fas fa-search'></i> Buscar:",
                "oPaginate": {
                    "sFirst": "<i class='fas fa-angle-double-left'></i>",
                    "sPrevious": "<i class='fas fa-angle-left'></i>",
                    "sNext": "<i class='fas fa-angle-right'></i>",
                    "sLast": "<i class='fas fa-angle-double-right'></i>"
                }
            },
            "pagingType": "full_numbers", // Paginación completa con botones
            "lengthMenu": [5, 10, 25, 50], // Opciones de registros por página
            "pageLength": 10 // Número predeterminado de registros por página
        });
    });
</script>
<script>
    function updateDisabledDates(especialidadId) {
        fetch('../alta_turno/get_disabled_dates.php?especialidad_id=' + especialidadId)
            .then(response => response.json())
            .then(disabledDates => {
                flatpickr("#appointment_date", {
                    minDate: new Date().setDate(new Date().getDate() + 1),
                    maxDate: new Date().setDate(new Date().getDate() + 30),
                    disable: [
                        ...disabledDates,
                        function(date) {
                            return (date.getDay() === 0 || date.getDay() === 6);
                        }
                    ],
                });
            });
    }

    $(document).on('change', '#service', function(event) {
        const especialidadId = $(this).val();
        updateDisabledDates(especialidadId);
    });

    $(document).on('click', '#view_turno', function(event) {
        $('#modal_turno').remove();
        var id_paciente_turno = $(this).data('id_paciente');
        var id_turno = $(this).data('id');
        var action = 'recepcion';

        $.ajax({
            url: "modal_info_pacientes.php",
            type: 'POST',
            data: {
                paciente: id_paciente_turno,
                id_turno: id_turno,
                action: action
            },
            cache: false,
            dataType: 'html',
            success: function(data) {
                $('#modal_turno').remove();
                var html = data;
                $('body').append(html);
                $('#modal_turno').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar el modal:", error);
                alert("Hubo un problema al cargar los datos. Por favor, intenta nuevamente.");
            }
        });
    });
</script>

<body>
    <div class="container py-5">
        <div class="table-responsive" id="impositivo-content">
            <?php
            if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'registro_exitoso') {
                echo '<div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050;">
            <strong>¡Éxito!</strong> Registro exitoso. Puede iniciar sesión ahora.
            </div>
            <script>
                setTimeout(function() {
                    var successMessage = document.getElementById("successMessage");
                    successMessage.classList.remove("show");
                    successMessage.classList.add("fade");
                    window.location.replace("index_recepcionista.php"); 
                }, 2000);  // El mensaje desaparecerá después de 2 segundos
            </script>';
            } else if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'turno_actualizado') {
                echo '<div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050;">
                <strong>Turno Actualizado con exito!</strong> Registro exitoso.
            </div>
            <script>
                setTimeout(function() {
                    var successMessage = document.getElementById("successMessage");
                    successMessage.classList.remove("show");
                    successMessage.classList.add("fade");
                    window.location.replace("index_recepcionista.php"); 
                }, 2000);  // El mensaje desaparecerá después de 2 segundos
            </script>';
            }
            ?>
            <h1 class="text-center mb-5 text-primary">Turnos<i class="fas fa-calendar-alt ms-2"></i></h1>
            <table id="table_turnos" class="table table-bordered table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th style="vertical-align: middle;" class="text-center">
                            <button id="add_turno" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#iframeModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </th>
                        <th style="vertical-align: middle;" class="text-center"><strong>Paciente</strong></th>
                        <th style="vertical-align: middle;" class="text-center"><strong>Especialidad</strong></th>
                        <th style="vertical-align: middle;" class="text-center"><strong>Fecha</strong></th>
                        <th style="vertical-align: middle;" class="text-center"><strong>Hora</strong></th>
                    </tr>
                </thead>
                <tbody id="tbody_turnos">
                    <?php
                    $stmt = $pdo->prepare("SELECT tp.id, tp.fecha, tp.hora, p.*, e.nombre AS especialidad 
                           FROM turnos_pacientes tp 
                           JOIN paciente p ON p.id_paciente = tp.id_paciente 
                           JOIN especializacion e ON e.id_especializacion = tp.id_especializacion 
                           WHERE 1=1 ORDER BY fecha");
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td class='text-center'><a class='btn btn-sm btn-outline-primary' id='view_turno' data-id_paciente='" . $row['id_paciente'] . "' data-id='" . $row['id'] . "'>
                            <i class='fas fa-eye'></i></a></td>";
                            echo "<td style='vertical-align: middle;' class='text-center'>" . htmlspecialchars($row['nombre'] . ' ' . $row['apellido']) . "</td>";
                            echo "<td  style='vertical-align: middle;' class='text-center'>" . htmlspecialchars($row['especialidad']) . "</td>";
                            echo "<td  style='vertical-align: middle;' class='text-center'>" . htmlspecialchars($row['fecha']) . "</td>";
                            echo "<td  style='vertical-align: middle;' class='text-center'>" . htmlspecialchars($row['hora']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No hay turnos disponibles</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="iframeModal" tabindex="-1" aria-labelledby="iframeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="iframeModalLabel">Registro de Paciente / Turno</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="text-center mb-4">
                            <button type="button" id="btnYaTieneUsuario" class="btn btn-outline-primary me-2">Ya tiene usuario</button>
                            <button type="button" id="btnNoTieneUsuario" class="btn btn-outline-secondary">No tiene usuario</button>
                        </div>
                        <div id="mensaje"></div>
                        <form id="formYaTieneUsuario" method="POST" class="d-none">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="dni_turno" class="form-label">DNI</label>
                                    <input type="number" class="form-control" id="dni_turno" name="dni_turno" required>
                                </div>
                            </div>
                            <div class="row">
                                <h4 class="mt-1 mb-3 text-primary">Detalles de la Reserva</h4>
                                <div class="mb-3">
                                    <label for="service" class="form-label">Especialidad</label>
                                    <select class="form-select" id="service" name="service" required>
                                        <option value="">Seleccione una especialidad</option>
                                        <?php
                                        if ($resultado && mysqli_num_rows($resultado) > 0) {
                                            while ($row = mysqli_fetch_assoc($resultado)) {
                                                echo "<option value='" . $row['id_especializacion'] . "'>" . $row['nombre'] . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>No hay especialidades disponibles</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="appointment_date" class="form-label">Fecha de Turno</label>
                                <input type="text" id="appointment_date" name="appointment_date" class="form-control" placeholder="Seleccione una fecha" required>
                            </div>
                            <div class="d-grid">
                                <button type="button" id="siguiente" class="btn btn-primary">Siguiente</button>
                            </div>
                        </form>

                        <script>
                            $(document).on('click', '#siguiente', function(event) {
                                event.preventDefault();

                                var form = $('#formYaTieneUsuario');
                                if (!form[0].checkValidity()) {
                                    form.addClass('was-validated');
                                    return;
                                }

                                $.ajax({
                                    url: "seleccionar_hora_recepcion.php",
                                    type: 'POST',
                                    data: form.serialize(),
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.status === 'success') {
                                            $('#mensaje').html('');
                                            $('#formYaTieneUsuario').html(response.html);
                                        } else if (response.status === 'error') {
                                            $('#mensaje').html('<div class="alert alert-warning" role="alert">' + response.message + '</div>');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error("Error en la solicitud AJAX:", error);
                                        $('#mensaje').html('<div class="alert alert-danger" role="alert">Hubo un problema al procesar tu solicitud. Intenta nuevamente.</div>');
                                    }
                                });
                            });
                        </script>

                        <form id="formNoTieneUsuario" action="../alta/alta_paciente.php?&site=recepcionista" method="POST" class="d-none">
                            <h5 class="text-primary">Datos del Paciente</h5>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su nombre" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="apellido" class="form-label">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ingrese su apellido" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="correo" name="correo" placeholder="nombre@ejemplo.com" required>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="dni" class="form-label">DNI</label>
                                    <input type="text" class="form-control" id="dni" name="dni" placeholder="Ingrese su DNI" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingrese su número telefónico">
                                </div>
                                <div class="col-md-4">
                                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Calle, Número, Ciudad">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese una contraseña" required>
                            </div>

                            <hr>
                            <h5 class="text-primary">Contacto de Emergencia</h5>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="contacto_nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="contacto_nombre" name="contacto_nombre" placeholder="Nombre del contacto" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="contacto_apellido" class="form-label">Apellido</label>
                                    <input type="text" class="form-control" id="contacto_apellido" name="contacto_apellido" placeholder="Apellido del contacto" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="contacto_telefonico" class="form-label">Número Telefónico</label>
                                <input type="text" class="form-control" id="contacto_telefonico" name="contacto_telefonico" placeholder="Teléfono del contacto" required>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">Registrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .shadow {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .text-primary {
            color: #007bff !important;
        }

        .bg-white {
            background-color: #ffffff !important;
        }
    </style>
    <script>
        $(document).ready(function() {
            // Inicializar el estado por defecto
            function initializeModal() {
                // Mostrar 'Ya tiene Usuario' por defecto y aplicar el estilo al botón correspondiente
                $('#formYaTieneUsuario').removeClass('d-none');
                $('#formNoTieneUsuario').addClass('d-none');
                $('#btnYaTieneUsuario').removeClass('btn-outline-primary').addClass('btn-primary'); // Resaltar el botón "Ya tiene usuario"

                // Restablecer los formularios y botones cuando el modal se muestra
                $('#iframeModal').on('show.bs.modal', function() {
                    initializeModal();
                });

                // Al hacer clic en el botón "Ya tiene usuario"
                $('#btnYaTieneUsuario').click(function() {
                    $('#formYaTieneUsuario').removeClass('d-none');
                    $('#formNoTieneUsuario').addClass('d-none');
                    // Cambiar el estilo de los botones
                    $('#btnYaTieneUsuario').removeClass('btn-outline-primary').addClass('btn-primary');
                    $('#btnNoTieneUsuario').removeClass('btn-secondary').addClass('btn-outline-secondary'); // Volver el otro botón a su estado normal
                });

                // Al hacer clic en el botón "No tiene usuario"
                $('#btnNoTieneUsuario').click(function() {
                    $('#formYaTieneUsuario').addClass('d-none');
                    $('#formNoTieneUsuario').removeClass('d-none');
                    // Cambiar el estilo de los botones
                    $('#btnYaTieneUsuario').removeClass('btn-primary').addClass('btn-outline-primary'); // Volver el otro botón a su estado normal
                    $('#btnNoTieneUsuario').removeClass('btn-outline-secondary').addClass('btn-secondary'); // Resaltar el botón "No tiene usuario"
                });
            }

            // Inicializar al cargar la página
            initializeModal();

            // Resetear formularios y botones cuando se cierra el modal
            $('#iframeModal').on('hidden.bs.modal', function() {
                $('#formYaTieneUsuario')[0].reset();
                $('#formNoTieneUsuario')[0].reset();

                $('#formYaTieneUsuario').addClass('d-none');
                $('#formNoTieneUsuario').addClass('d-none');

                $('#btnYaTieneUsuario').removeClass('btn-primary').addClass('btn-outline-primary');
                $('#btnNoTieneUsuario').removeClass('btn-secondary').addClass('btn-outline-secondary');
            });

            $(document).on('click', '.btn-close', function(event) {
                $('#formYaTieneUsuario')[0].reset();
                $('#formNoTieneUsuario')[0].reset();
            });
        });
    </script>

    <?php include '../utils/footer.php'; ?>

</body>

</html>
<?php
mysqli_close($conexion);
?>