<?php
session_start();
if (!isset($_SESSION['empleado_id'])) {
    header('Location: login_empleado.php');  // Redirigir si no está autenticado
    exit;
}

$empleado_id = $_SESSION['empleado_id'];
$dni = $_SESSION['dni'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Bienvenido, empleado <?php echo $dni; ?>!</h2>
        <p class="text-center">Has iniciado sesión correctamente.</p>
        <div class="text-center">
            <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
        </div>
    </div>
</body>
</html>
