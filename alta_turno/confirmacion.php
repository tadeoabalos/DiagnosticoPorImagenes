<?php
session_start();

if (!isset($_SESSION['name'])) {
    echo "No hay detalles del turno disponibles.";
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
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($_SESSION['name']); ?></p>
            <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($_SESSION['phone']); ?></p>
            <p><strong>Especialidad:</strong> <?php echo htmlspecialchars($_SESSION['service']); ?></p>
            <p><strong>Fecha:</strong> <?php echo htmlspecialchars($_SESSION['date']); ?></p>
            <p><strong>Hora:</strong> <?php echo htmlspecialchars($_SESSION['time']); ?></p>
        </div>
        <p>¡Gracias por reservar su turno!</p>
        <a href="../index/index.php" class="button">Volver al inicio</a>
    </div>
</body>
</html>
