<?php
session_start();
//var_dump($_SESSION); // Verifica los datos en la sesión

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "radiologia_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_POST['fecha_turno']) && isset($_POST['hora_turno'])) {

    $id_turno = $_SESSION['id_turno'];
    $id_paciente = $_SESSION['user_id'];
    $fecha_turno = $_POST['fecha_turno'];
    $hora_turno = $_POST['hora_turno']; 

    if (empty($fecha_turno) || empty($hora_turno)) {
        die("Error: uno o más campos están vacíos.");
    }

    $sql = "UPDATE turnos_pacientes SET fecha = ?, hora = ? WHERE id_paciente = ? AND ID = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ssii", $fecha_turno, $hora_turno, $id_paciente, $id_turno); 

    if ($stmt->execute()) {
        header('Location: ../index_empleados/index_recepcionista.php?mensaje=turno_actualizado');
        exit();
    } else {
        echo "Error al actualizar el turno: " . $conn->error;
    }

    $stmt->close();
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
        $id_turno = $conn->insert_id;
        $_SESSION['id_turno'] = $id_turno;
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

