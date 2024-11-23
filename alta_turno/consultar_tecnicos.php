<?php
    session_start(); 
    $conexion = mysqli_connect("localhost", "root", "", "radiologia_db");

    if (!$conexion) {
        die("Error al conectar con la base de datos: " . mysqli_connect_error());
    }

    $horaSeleccionada = isset($_POST['hora']) ? $_POST['hora'] : '';
    $fechaTurno = isset($_SESSION['appointment_date']) ? $_SESSION['appointment_date'] : '';
    $fechaTurno = trim($fechaTurno);  

    $tecnicosDisponibles = [];
    
    $consulta_tecnicos = "
    SELECT e.id_empleado, e.nombre, e.apellido 
    FROM empleado e
    JOIN turno t ON e.turno_id = t.id
    WHERE e.tipo_empleado = 1
    AND ? BETWEEN t.hora_inicio AND t.hora_fin
    AND e.id_empleado NOT IN (
        SELECT tp.id_tecnico
        FROM turnos_pacientes tp
        WHERE tp.fecha = ?
        AND tp.hora = ?
    );
    ";

    $stmt = mysqli_prepare($conexion, $consulta_tecnicos);
    
    if ($stmt) {        
        mysqli_stmt_bind_param($stmt, 'sss', $horaSeleccionada, $fechaTurno, $horaSeleccionada);
        
        mysqli_stmt_execute($stmt);
        
        $resultado_tecnicos = mysqli_stmt_get_result($stmt);
        
        while ($row = mysqli_fetch_assoc($resultado_tecnicos)) {
            $tecnicosDisponibles[] = $row;
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error en la consulta: " . mysqli_error($conexion);
    }
    
    echo json_encode($tecnicosDisponibles);
    
    mysqli_close($conexion);
?>
