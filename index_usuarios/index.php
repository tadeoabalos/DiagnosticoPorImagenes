<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$pageTitle = 'Panel de Usuarios';
include '../utils/header_index_usuarios.php';
?>

<body>
    <div class="content">
        <div class="main-container">
            <div class="turno-list">
                <h4 class="header-turnos">Lista de Turnos</h4>
                <div class="turno">
                    <div class="turno-content">
                        <span>Fecha: </span>
                        <span>Hora: </span>
                        <span>Estudio: </span>
                    </div>
                    <div class="button-section">
                        <a href="#">Cancelar Turno</a>
                        <a href="#">Ver detalles</a>
                    </div>
                </div>
            </div>
            <a href="../alta_turno/alta_turno.php" style="color: black;">Pedir Turno</a>
        </div>
    </div>

    <?php include '../utils/footer.php'; ?>

</body>

</html>
