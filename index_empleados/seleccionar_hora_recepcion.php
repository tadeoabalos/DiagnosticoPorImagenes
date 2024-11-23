<?php
session_start();
$conexion = mysqli_connect("localhost", "root", "", "radiologia_db");
if (!$conexion) {
    echo json_encode(['status' => 'error', 'message' => 'Error al conectar con la base de datos.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni_turno = isset($_POST['dni_turno']) ? trim($_POST['dni_turno']) : null;

    if ($dni_turno) {
        $sql = "SELECT id_paciente FROM paciente WHERE dni = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $dni_turno);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            echo json_encode(['status' => 'error', 'message' => 'DNI no encontrado en nuestros registros, intentelo denuevo: ' . htmlspecialchars($dni_turno)]);
        } else {
            $stmt->bind_result($id_paciente);
            $stmt->fetch();
            $_SESSION['id_paciente'] = $id_paciente;

            $especializacion_id = mysqli_real_escape_string($conexion, $_POST['service']);
            $sql_especializacion = "SELECT nombre FROM especializacion WHERE id_especializacion = $especializacion_id";
            $resultado_especializacion = mysqli_query($conexion, $sql_especializacion);

            if ($resultado_especializacion && $row = mysqli_fetch_assoc($resultado_especializacion)) {
                $_SESSION['service'] = $especializacion_id;
                $_SESSION['service_name'] = $row['nombre'];
            }

            $_SESSION['appointment_date'] = $_POST['appointment_date'];
            $fecha_turno = $_SESSION['appointment_date'] ?? null;

            // Obtener horarios disponibles
            $consulta_horarios = "SELECT hora FROM horarios_turno";
            $resultado_horarios = mysqli_query($conexion, $consulta_horarios);

            $consulta_ocupados = "
                SELECT t.hora FROM turnos_pacientes t
                WHERE t.id_especializacion = '$especializacion_id' AND t.fecha = '$fecha_turno'
            ";
            $resultado_ocupados = mysqli_query($conexion, $consulta_ocupados);

            $horarios_ocupados = [];
            while ($row = mysqli_fetch_assoc($resultado_ocupados)) {
                $horarios_ocupados[] = $row['hora'];
            }

            $horarios_disponibles = [];
            while ($row = mysqli_fetch_assoc($resultado_horarios)) {
                if (!in_array($row['hora'], $horarios_ocupados)) {
                    $horarios_disponibles[] = $row['hora'];
                }
            }

            // Generar HTML
            ob_start();
            ?>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tecnico').hide();
        $('#hora').change(function() {
            var horaSeleccionada = $(this).val();

            if (horaSeleccionada) {
                $.ajax({
                    url: '../alta_turno/consultar_tecnicos.php',
                    type: 'POST',
                    data: {
                        hora: horaSeleccionada
                    },
                    success: function(data) {
                        try {
                            var tecnicosDisponibles = JSON.parse(data);
                            var tecnicoSelect = $('#tecnico');
                            var mensaje = $('#mensaje');

                            mensaje.empty(); // Limpiar mensajes previos
                            tecnicoSelect.empty().append('<option value="">Seleccione un técnico disponible</option>');

                            if (Array.isArray(tecnicosDisponibles) && tecnicosDisponibles.length > 0) {
                                tecnicosDisponibles.forEach(function(tecnico) {
                                    tecnicoSelect.append('<option value="' + tecnico.id_empleado + '">Tec. ' + tecnico.nombre + ' ' + tecnico.apellido + '</option>');
                                });
                                tecnicoSelect.show();
                            } else {
                                mensaje.append('<div class="alert alert-warning" role="alert">No hay técnicos disponibles para el horario seleccionado.</div>');
                                tecnicoSelect.hide();
                            }
                        } catch (error) {
                            console.error("Error procesando la respuesta:", error);
                        }
                    },
                    error: function() {
                        alert("Error al consultar técnicos. Por favor, inténtalo nuevamente.");
                    }
                });
            } else {
                $('#tecnico').hide();
                $('#mensaje').empty();
            }
        });
    });
</script>
            <div>
                <h2 class="text-center mb-4">Seleccionar Hora</h2>
                <p>Turnos disponibles para <strong><?= htmlspecialchars($_SESSION['service_name']) ?></strong> en la fecha <strong><?= htmlspecialchars($fecha_turno) ?></strong>.</p>
                <form id="appointmentForm" action="../alta_turno/procesar_turno.php" method="POST">
                    <div class="mb-3">
                        <select class="form-select" id="hora" name="hora" required>
                            <option value="">Seleccione un horario</option>
                            <?php foreach ($horarios_disponibles as $hora) { ?>
                                <option value="<?= htmlspecialchars($hora) ?>"><?= htmlspecialchars($hora) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <select class="form-select" id="tecnico" name="tecnico" required>
                            <option value="">Seleccione un técnico disponible</option>
                        </select>
                    </div>
                    <div id="mensaje" class="mt-3"></div>
                    <a href="../index_empleados/index_recepcionista.php" class="btn btn-secondary w-100">Volver</a>
                    <button type="submit" class="btn btn-primary w-100">Confirmar Turno</button>
                </form>
            </div>
            <?php
            $html = ob_get_clean();
            echo json_encode(['status' => 'success', 'html' => $html]);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: DNI no proporcionado.']);
    }
    mysqli_close($conexion);
    exit;
}
?>
