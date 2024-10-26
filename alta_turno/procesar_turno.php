<?php
session_start(); // Inicia la sesión

$servername = "localhost";   
$username = "root";    
$password = ""; 
$dbname = "radiologia_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$nombre_completo = $_POST['name'];
$email = $_POST['email'];
$telefono = $_POST['phone'];
$especialidad = $_POST['service'];
$fecha = $_POST['date'];
$hora = $_POST['time'];

$sql = "INSERT INTO turnos_pacientes (nombre_completo, email, telefono, especialidad, fecha, hora)
VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $nombre_completo, $email, $telefono, $especialidad, $fecha, $hora);

if ($stmt->execute()) {
    // Guardar datos en variables de sesión
    $_SESSION['name'] = $nombre_completo;
    $_SESSION['email'] = $email;
    $_SESSION['phone'] = $telefono;
    $_SESSION['service'] = $especialidad;
    $_SESSION['date'] = $fecha;
    $_SESSION['time'] = $hora;
    
    header("Location: confirmacion.php"); // Redirige a confirmacion.php
    exit();
} else {
    echo "Error al reservar el turno: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
