<?php
session_start();
require '../conexion.php'; 

$error = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    $sql = "SELECT id, nombre, contraseña, rol_id FROM usuarios WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {      
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_name'] = $usuario['nombre'];
        $_SESSION['rol_id'] = $usuario['rol_id'];
        
        header("Location: index_profesionales.php");
        exit();
    } else {
        $error = "Email o contraseña incorrectos.";
    }
}
include 'login_form.php';
?>
