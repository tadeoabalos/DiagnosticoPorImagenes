<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index/index.php');
    exit;
}

$conexion = mysqli_connect("localhost", "root", "", "radiologia_db");
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

$sql = "SELECT * FROM especializacion";
$resultado = mysqli_query($conexion, $sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $especializacion_id = $_POST['service'];
    $sql_especializacion = "SELECT nombre FROM especializacion WHERE id_especializacion = $especializacion_id";
    $resultado_especializacion = mysqli_query($conexion, $sql_especializacion);

    if ($resultado_especializacion && $row = mysqli_fetch_assoc($resultado_especializacion)) {
        $_SESSION['service'] = $especializacion_id;
        $_SESSION['service_name'] = $row['nombre'];
    }

    $_SESSION['appointment_date'] = $_POST['appointment_date'];
    header("Location: seleccionar_hora.php");
    exit();
}

$pageTitle = 'Pedir Turno';
include '../utils/header_index_usuarios.php';
?>

<body>
    <div class="container my-5">
        <h2 class="text-center mb-4">Reservar Turno</h2>
        <p class="text-center">Complete el formulario para reservar un turno en nuestra clínica.</p>

        <form id="appointmentForm" action="alta_turno.php" method="POST" class="mx-auto shadow p-4 rounded bg-white" style="max-width: 600px;">
            <h4 class="mb-4 text-primary">Datos del Paciente</h4>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nombre</label>
                    <input value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" type="text" class="form-control" id="name" name="name" disabled>
                </div>
                <div class="col-md-6">
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

            <h4 class="mt-4 mb-3 text-primary">Detalles de la Reserva</h4>
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

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Siguiente</button>
            </div>
        </form>
    </div>

    <?php include '../utils/footer.php'; ?>

    <script>
        function updateDisabledDates(especialidadId) {
            fetch('get_disabled_dates.php?especialidad_id=' + especialidadId)
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

        document.querySelector('#service').addEventListener('change', function() {
            const especialidadId = this.value;
            updateDisabledDates(especialidadId);
        });
    </script>
</body>

</html>

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

<?php
mysqli_close($conexion);
?>
