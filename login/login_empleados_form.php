<?php
session_start();
$pageTitle = 'Login Empleado';
include '../utils/header.php';
?>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Ingreso de Empleado</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                <?php 
                echo $_SESSION['error']; 
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <form action="login_empleado.php" method="POST">
            <div class="mb-3">
                <label for="dni" class="form-label">DNI</label>
                <input type="text" class="form-control" id="dni" name="dni" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Ingresar</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const alertElement = document.getElementById("error-alert");
            if (alertElement) {
                setTimeout(() => {
                    alertElement.classList.remove("show");
                    alertElement.classList.add("fade");
                    setTimeout(() => alertElement.remove(), 500);
                }, 2000); // 5 segundos
            }
        });
    </script>
</body>
</html>