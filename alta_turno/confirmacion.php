<?php
session_start();

if (!isset($_SESSION['id_turno'])) {
    echo "No se encontraron detalles del turno.";
    exit();
}

$id_turno = $_SESSION['id_turno'];

include '../conexion.php';

$stmt = $pdo->prepare("SELECT p.nombre, p.apellido, p.correo, p.num_telefonico, e.nombre AS especialidad, tp.fecha, tp.hora
                       FROM turnos_pacientes tp
                       JOIN paciente p ON tp.id_paciente = p.id_paciente
                       JOIN especializacion e ON e.id_especializacion = tp.id_especializacion
                       WHERE tp.id = :id_turno");

$stmt->bindParam(':id_turno', $id_turno, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $nombre_completo = $row['nombre'] . ' ' . $row['apellido'];
    $correo = $row['correo'];
    $telefono = $row['num_telefonico'];
    $especialidad = $row['especialidad'];
    $fecha_turno = $row['fecha'];
    $hora_turno = $row['hora'];
} else {
    echo "No se encontraron detalles del turno.";
    exit();
}



?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Turno</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            text-align: center;
        }

        h1 {
            color: #4CAF50;
        }

        p {
            font-size: 16px;
            color: #333;
            line-height: 1.5;
        }

        .details {
            margin: 10px 0;
        }

        .details strong {
            color: #4CAF50;
        }

        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            color: #fff;
            background-color: #4CAF50;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Detalles del Turno</h1>
        <div class="details">
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre_completo); ?></p>
            <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($correo); ?></p>
            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($telefono); ?></p>
            <p><strong>Especialidad:</strong> <?php echo htmlspecialchars($especialidad); ?></p>
            <p><strong>Fecha:</strong> <?php echo htmlspecialchars($fecha_turno); ?></p>
            <p><strong>Hora:</strong> <?php echo htmlspecialchars($hora_turno); ?></p>
        </div>
        <p>¡Gracias por reservar su turno!</p>
        <a href="../index/index.php" class="button">Volver al inicio</a>
    </div>
</body>

</html>
