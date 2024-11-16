<!DOCTYPE html>
<html lang="es">

<?php
    $pageTitle = 'Iniciar Sesión';
    include '../utils/header.php';
?>

<div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card shadow p-4 col-10 col-md-8 col-lg-6 col-xl-4">
        <h2 class="text-center mb-4">Inicio de Sesion</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="../index/index.php" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="contraseña" class="form-label">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" class="form-control" required>
                <a href="#" class="text-decoration-none" style="margin-top: 50px;">¿Olvidaste tu contraseña?</a>        
            </div>
                <button type="submit" class="btn btn-primary w-100 mb-3">Iniciar Sesión</button>
            <div class="text-center">
                <span>¿No tenes cuenta?</span><a href="../alta/alta_paciente_form.php">Regístrate</a>
            </div>
        </form>
    </div>
</div>

</html>