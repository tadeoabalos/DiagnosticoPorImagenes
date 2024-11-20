<?php
session_start();
var_dump($_SESSION); // Verifica los datos en la sesión

$servername = "localhost";   
$username = "root";    
$password = ""; 
$dbname = "radiologia_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (isset($_SESSION['user_id'], $_SESSION['service'], $_SESSION['appointment_date'], $_POST['hora'])) {
    $id_paciente = $_SESSION['user_id']; 
    $id_especializacion = $_SESSION['service']; 
    $fecha = $_SESSION['appointment_date']; 
    $hora = $_POST['hora']; 
    
    if (empty($id_especializacion) || empty($fecha) || empty($hora)) {
        die("Error: uno o más campos están vacíos.");
    }

    $sql = "INSERT INTO turnos_pacientes (id_paciente, id_especializacion, fecha, hora)
    VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $id_paciente, $id_especializacion, $fecha, $hora); 

    if ($stmt->execute()) {
        header("Location: confirmacion.php"); 
        exit();
    } else {
        echo "Error al reservar el turno: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Error: los datos del formulario no se han enviado correctamente.";
}

$conn->close();
?>
