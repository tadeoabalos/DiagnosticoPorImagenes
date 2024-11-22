<?php
include '../conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $dni = $_POST['dni']; 
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $direccion = $_POST['direccion'];    
    $matricula = isset($_POST['num_matricula']) && $_POST['num_matricula'] !== '' ? $_POST['num_matricula'] : null;
    $empleado = $_POST['tipo_empleado'];
    $turno = isset($_POST['turno']) && $_POST['turno'] !== '' ? $_POST['turno'] : null;
    
    $passwordHash = password_hash($dni, PASSWORD_DEFAULT);

    // Generar el número de legajo según el tipo de empleado
    if ($empleado == 1) {
        // Empezar desde 100 para tipo 1 (Técnico)
        $sqlLegajo = "SELECT COALESCE(MAX(legajo), 99) + 1 AS nuevo_legajo FROM empleado WHERE tipo_empleado = 1";
    } else if ($empleado == 2) {
        // Empezar desde 200 para tipo 2 (Recepcionista)
        $sqlLegajo = "SELECT COALESCE(MAX(legajo), 199) + 1 AS nuevo_legajo FROM empleado WHERE tipo_empleado = 2";
    }

    $stmtLegajo = $pdo->query($sqlLegajo);
    $nuevoLegajo = $stmtLegajo->fetchColumn();

    // Insertar nuevo empleado con el número de legajo calculado
    $sqlEmpleado = "INSERT INTO empleado (nombre, apellido, correo, dni, num_telefonico, fecha_nacimiento, direccion, num_matricula, tipo_empleado, turno_id, legajo) 
                    VALUES (:nombre, :apellido, :correo, :dni, :telefono, :fecha_nacimiento, :direccion, :num_matricula, :tipo_empleado, :turno, :legajo)";
    
    try {        
        $pdo->beginTransaction();
        
        $stmtEmpleado = $pdo->prepare($sqlEmpleado);
        $stmtEmpleado->bindParam(':nombre', $nombre);
        $stmtEmpleado->bindParam(':apellido', $apellido);
        $stmtEmpleado->bindParam(':correo', $correo);
        $stmtEmpleado->bindParam(':dni', $dni);
        $stmtEmpleado->bindParam(':telefono', $telefono);
        $stmtEmpleado->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmtEmpleado->bindParam(':direccion', $direccion);
        
        if ($matricula !== null) {
            $stmtEmpleado->bindParam(':num_matricula', $matricula);
        } else {
            $stmtEmpleado->bindValue(':num_matricula', null, PDO::PARAM_NULL);
        }

        $stmtEmpleado->bindParam(':tipo_empleado', $empleado);
        $stmtEmpleado->bindParam(':turno', $turno);
        $stmtEmpleado->bindParam(':legajo', $nuevoLegajo);
        $stmtEmpleado->execute();
        
        $empleadoId = $pdo->lastInsertId();

        $sqlPwEmpleado = "INSERT INTO password_empleados (id_empleado, password_hash) VALUES (:empleado_id, :password_hash)";
        $stmtPwEmpleado = $pdo->prepare($sqlPwEmpleado);
        $stmtPwEmpleado->bindParam(':empleado_id', $empleadoId);
        $stmtPwEmpleado->bindParam(':password_hash', $passwordHash);
        $stmtPwEmpleado->execute();
                
        $pdo->commit();

        echo "Registro guardado exitosamente con legajo: " . $nuevoLegajo;
    } catch(PDOException $e) {        
        $pdo->rollBack();
        echo "Error al guardar el registro: " . $e->getMessage();
    }

    $conn = null;
}
?>
