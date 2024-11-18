<?php
session_start();
$mostrar_modal = !isset($_SESSION['usuario']);    
$conexion = mysqli_connect("localhost", "root", "", "radiologia_db");
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}
$sql = "SELECT * FROM especializacion";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedir Turno</title>
</head>
<body>
    <?php include '../utils/header_index_usuarios.php'; ?>
    <div class="container my-5">
        <h2 class="text-center mb-4">Reservar Turno</h2>
        <p class="text-center">Complete el formulario para reservar un turno en nuestra clínica.</p>
    </div>
    <form id="appointmentForm" action="procesar_turno.php" method="POST" class="mx-auto" style="max-width: 600px;">
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
                        echo "<option value='" . $row['nombre'] . "'>" . $row['nombre'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay especialidades disponibles</option>";
                }
                ?>
            </select>
        </div>
    </form>
    <footer>
        <?php include '../utils/footer.php'; ?>
    </footer>
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
