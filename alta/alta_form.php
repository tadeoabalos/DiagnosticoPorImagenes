<!DOCTYPE html>
<html lang="es">

<?php
$pageTitle = 'Alta de Usuario Administrativo';
include '../utils/header.php';
?>

<div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card shadow p-4 col-10 col-md-8 col-lg-6 col-xl-4">
        <h2 class="text-center mb-4">Alta de Usuario</h2>

        <!-- Mostrar mensaje de exito encima del formulario -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <!-- Mostrar mensaje de error -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="./alta.php" method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label required">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label required">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="contraseña" class="form-label required">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="rol_id" class="form-label required">Rol:</label>
                <select id="rol_id" name="rol_id" class="form-select" required>
                    <option value="1">Administrador</option>
                    <option value="2">Recepcionista</option>
                    <option value="3">Radiólogo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Crear Usuario</button>
        </form>
        <a href="../login/login.php" class="d-block text-center mt-3 text-primary">Logueate</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</div>

</html>