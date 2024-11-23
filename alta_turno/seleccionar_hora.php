<?php
session_start();
$mostrar_modal = !isset($_SESSION['usuario']);
$conexion = mysqli_connect("localhost", "root", "", "radiologia_db");
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}
$especializacion = isset($_SESSION['service']) ? $_SESSION['service'] : null;
$nombre_especializacion = isset($_SESSION['service_name']) ? $_SESSION['service_name'] : null;
$fecha_turno = isset($_SESSION['appointment_date']) ? $_SESSION['appointment_date'] : null;
$horarios_disponibles = [];

$consulta_horarios = "SELECT * FROM horarios_turno";
$resultado_horarios = mysqli_query($conexion, $consulta_horarios);
$consulta_ocupados = "
        SELECT t.hora
        FROM turnos_pacientes t
        WHERE t.id_especializacion = $especializacion AND t.fecha = '$fecha_turno'
    ";
$resultado_ocupados = mysqli_query($conexion, $consulta_ocupados);

$horarios_ocupados = [];
if ($resultado_ocupados) {
    while ($row = mysqli_fetch_assoc($resultado_ocupados)) {
        $horarios_ocupados[] = $row['hora'];
    }
}
if ($resultado_horarios) {
    while ($row = mysqli_fetch_assoc($resultado_horarios)) {
        if (!in_array($row['hora'], $horarios_ocupados)) {
            $horarios_disponibles[] = $row['hora'];
        }
    }
}
?>
<?php
$pageTitle = 'Pedir Turno - Seleccionar Hora';
include '../utils/header_index_usuarios.php';
?>
<body>
    <div id="mensaje"></div>
    <div class="container my-5 text-center" style="max-width: 400px; margin: auto;">
        <h2 class="mb-4">Seleccionar Hora</h2>
        <p>
            Turnos disponibles para <strong><?php echo $nombre_especializacion; ?></strong> en la fecha <strong><?php echo htmlspecialchars($fecha_turno); ?></strong>.
        </p>
        <form id="appointmentForm" action="procesar_turno.php" method="POST">
            <div class="mb-3">
                <select class="form-select" id="hora" name="hora" style="margin-bottom: 5px;" required>
                    <option value="">Seleccione un horario</option>
                    <?php
                    foreach ($horarios_disponibles as $hora) {
                        echo "<option value='$hora'>$hora</option>";
                    }
                    ?>
                </select>
                <div class="mb-3">
                    <select class="form-select" id="tecnico" name="tecnico" required>
                        <option value="">Seleccione un técnico disponible</option>
                        <?php
                            foreach ($tecnicos as $tecnico) {
                                echo "<option value='" . $tecnico['id_empleado'] . "'> Tec. " . $tecnico['nombre'] . " " . $tecnico['apellido'] . "</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Confirmar Turno</button>            
            <a href="alta_turno.php" class="btn btn-secondary w-25 mt-3">Volver</a>
        </form>
    </div>

    <?php include '../utils/footer.php'; ?>
</body>
</html>
<?php
mysqli_close($conexion);
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {        
        $('#tecnico').hide();        
        $('#hora').change(function() {
            var horaSeleccionada = $(this).val();

            if (horaSeleccionada) {                
                $.ajax({
                    url: 'consultar_tecnicos.php',
                    type: 'POST',
                    data: { hora: horaSeleccionada },
                    success: function(data) {
                        var tecnicosDisponibles = JSON.parse(data);
                        var tecnicoSelect = $('#tecnico');
                        var mensaje = $('#mensaje'); // Contenedor para el mensaje de error

                        // Limpiar el mensaje de error previo
                        mensaje.empty();

                        tecnicoSelect.empty();
                        tecnicoSelect.append('<option value="">Seleccione un técnico disponible</option>');
                        
                        if (tecnicosDisponibles.length > 0) {
                            tecnicosDisponibles.forEach(function(tecnico) {
                                tecnicoSelect.append('<option value="' + tecnico.id_empleado + '">Tec. ' + tecnico.nombre + ' ' + tecnico.apellido + '</option>');
                            });
                            tecnicoSelect.show();
                        } else {
                            // Mostrar un mensaje si no hay técnicos disponibles
                            mensaje.append('<div class="alert alert-warning" role="alert">No hay técnicos disponibles para el horario seleccionado.</div>');
                            tecnicoSelect.hide();  // Ocultar el select de técnicos
                        }
                    }
                });
            } else {            
                $('#tecnico').hide();
                $('#mensaje').empty();  // Limpiar el mensaje si no se seleccionó hora
            }
        });
    });
</script>


