<!DOCTYPE html>
<html lang="es">

<?php
$pageTitle = 'Iniciar Sesión';
include '../utils/header_index_usuarios.php';
?>

<body>
    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="card shadow p-4 col-10 col-md-8 col-lg-6 col-xl-4">
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
                        }, 2000);  // El mensaje desaparecerá después de 2 segundos
                    </script>';
            }
            ?>
            <h2 class="text-center mb-4">Inicio de Sesión</h2>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="contraseña" class="form-label">Contraseña:</label>
                    <input type="password" id="contraseña" name="contraseña" class="form-control" required>
                    <a href="#" class="text-decoration-none" style="margin-top: 10px;">¿Olvidaste tu contraseña?</a>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3">Iniciar Sesión</button>
                <div class="text-center">
                    <span>¿No tienes cuenta?</span>
                    <a href="../alta/alta_paciente_form.php">Regístrate</a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
