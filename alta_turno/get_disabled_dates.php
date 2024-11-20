<?php
    $conexion = mysqli_connect("localhost", "root", "", "radiologia_db");
    if (!$conexion) {
        die("Error al conectar con la base de datos: " . mysqli_connect_error());
    }

    $especialidad_id = $_GET['especialidad_id']; // ID de la especialidad recibido vía GET

    $query = "
        SELECT fecha 
        FROM turnos_pacientes 
        WHERE id_especializacion = $especialidad_id 
        GROUP BY fecha 
        HAVING COUNT(*) >= 9
    ";

    $resultado = mysqli_query($conexion, $query);

    $fechas_deshabilitadas = [];
    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $fechas_deshabilitadas[] = $row['fecha'];
        }
    }

    echo json_encode($fechas_deshabilitadas);
?>
