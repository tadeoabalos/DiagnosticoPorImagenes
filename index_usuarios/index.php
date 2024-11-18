<?php
session_start(); 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../utils/header_index_usuarios.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <title>Panel de Usuarios</title>
</head>
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
</body>
</html>
<footer>
    <?php include '../utils/footer.php'; ?>
</footer>
