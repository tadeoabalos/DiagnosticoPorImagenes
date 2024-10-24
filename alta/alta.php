<?php
require '../conexion.php'; 
session_start();
$error = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {    
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];
    $rol_id = $_POST['rol_id']; 
    
    $contraseñaHash = password_hash($contraseña, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO usuarios (nombre, email, contraseña, rol_id) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$nombre, $email, $contraseñaHash, $rol_id])) {
        echo "Usuario creado exitosamente.";
    } else {
        $error = "Error al crear el usuario.";
    }
}

include 'alta_form.php';
?>
