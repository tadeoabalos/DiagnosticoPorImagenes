<?php
session_start();
require '../conexion.php'; 

$error = ''; // Variable para almacenar el mensaje de error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    // Consulta para verificar el usuario
    $sql = "SELECT id, nombre, contraseña, rol_id FROM usuarios WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si el usuario existe y la contraseña es correcta
    if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {      
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_name'] = $usuario['nombre'];
        $_SESSION['rol_id'] = $usuario['rol_id'];
        
        header("Location: ../alta/alta.php");
        exit();
    } else {
        $error = "Email o contraseña incorrectos.";
    }
}

// Incluimos el formulario de inicio de sesión
include 'login_form.php';
?>
