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
    <div class="container my-5 text-center" style="max-width: 400px; margin: auto;">
        <h2 class="mb-4">Seleccionar Hora</h2>
        <p>
            Turnos disponibles para <strong><?php echo $nombre_especializacion; ?></strong> en la fecha <strong><?php echo htmlspecialchars($fecha_turno); ?></strong>.
        </p>
        <form id="appointmentForm" action="procesar_turno.php" method="POST">
            <div class="mb-3">
                <select class="form-select" id="hora" name="hora" required>
                    <option value="">Seleccione un horario</option>
                    <?php
                    foreach ($horarios_disponibles as $hora) {
                        echo "<option value='$hora'>$hora</option>";
                    }
                    ?>
                </select>
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
