<?php
session_start();
$mostrar_modal = !isset($_SESSION['usuario']);    
$conexion = mysqli_connect("localhost", "root", "", "radiologia_db");
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

$sql = "SELECT * FROM especializacion";
$resultado = mysqli_query($conexion, $sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos de la especialidad seleccionada
    $especializacion_id = $_POST['service'];
    $sql_especializacion = "SELECT nombre FROM especializacion WHERE id_especializacion = $especializacion_id";
    $resultado_especializacion = mysqli_query($conexion, $sql_especializacion);
    
    if ($resultado_especializacion && $row = mysqli_fetch_assoc($resultado_especializacion)) {
        $_SESSION['service'] = $especializacion_id;
        $_SESSION['service_name'] = $row['nombre']; // Guardar el nombre de la especialidad
    }

    $_SESSION['appointment_date'] = $_POST['appointment_date'];
    header("Location: seleccionar_hora.php"); 
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedir Turno</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body>
    <?php include '../utils/header_index_usuarios.php'; ?>
    <div class="container my-5">
        <h2 class="text-center mb-4">Reservar Turno</h2>
        <p class="text-center">Complete el formulario para reservar un turno en nuestra clínica.</p>
    </div>
    <form id="appointmentForm" action="alta_turno.php" method="POST" class="mx-auto" style="max-width: 600px;">
        <div class="flex-input">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" type="text" class="form-control" id="name" name="name" disabled>
            </div>
            <div class="mb-3">
                <label for="surname" class="form-label">Apellido</label>
                <input value="<?php echo htmlspecialchars($_SESSION['user_surname']); ?>" type="text" class="form-control" id="surname" name="surname" disabled>
            </div>
        </div>    
        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input value="<?php echo htmlspecialchars($_SESSION['user_tel']); ?>" type="number" class="form-control" id="phone" name="phone" disabled>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo</label>
            <input value="<?php echo htmlspecialchars($_SESSION['user_email']); ?>" type="email" class="form-control" id="email" name="email" disabled>
        </div>
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

        <div class="mb-3">
            <label for="appointment_date" class="form-label">Fecha de Turno</label>
            <input type="text" id="appointment_date" name="appointment_date" class="form-control" placeholder="Seleccione una fecha" required>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Siguiente</button>
        </div>
    </form>

    <footer>
        <?php include '../utils/footer.php'; ?>
    </footer>

    <script>
        flatpickr("#appointment_date", {
            minDate: "today",
            maxDate: new Date().fp_incr(15),
            disable: [
                function(date) { 
                    return (date.getDay() === 0 || date.getDay() === 6); 
                }
            ],
            dateFormat: "Y-m-d",
        });
    </script>
</body>
</html>
<style>
    .flex-input {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        gap: 5px;
    }
</style>
<?php
    mysqli_close($conexion);
?>
