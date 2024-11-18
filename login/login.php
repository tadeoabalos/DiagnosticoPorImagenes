<?php
session_start();
require '../conexion.php'; 

$error = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];
    
    $sql = "SELECT p.id_paciente, p.nombre, p.apellido, p.num_telefonico ,p.correo, pw.password_hash 
            FROM paciente p
            JOIN password pw ON p.id_paciente = pw.id_paciente
            WHERE p.correo = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
   
    if ($usuario && password_verify($contraseña, $usuario['password_hash'])) {              
        $_SESSION['user_id'] = $usuario['id_paciente'];
        $_SESSION['user_name'] = $usuario['nombre'];
        $_SESSION['user_surname'] = $usuario['apellido'];
        $_SESSION['user_tel'] = $usuario['num_telefonico'];
        $_SESSION['user_email'] = $usuario['correo'];
                
        header("Location: ../index_usuarios/index.php");
        exit();
    } else {
        $error = "Email o contraseña incorrectos.";
    }
}
include 'login_form.php';
?>
