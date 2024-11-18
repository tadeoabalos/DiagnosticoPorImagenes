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
    $turno = $_POST['turno'];  
    
    $passwordHash = password_hash($dni, PASSWORD_DEFAULT); // Genera un hash seguro de la contraseña.
    
    $sqlEmpleado = "INSERT INTO empleado (nombre, apellido, correo, dni, num_telefonico, fecha_nacimiento, direccion, num_matricula, tipo_empleado) 
                    VALUES (:nombre, :apellido, :correo, :dni, :telefono, :fecha_nacimiento, :direccion, :num_matricula, :tipo_empleado)";
    
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
        $stmtEmpleado->bindParam(':num_matricula', $matricula, PDO::PARAM_NULL); // Aquí asignamos el valor nulo si es necesario
        $stmtEmpleado->bindParam(':tipo_empleado', $empleado);
        $stmtEmpleado->execute();
        
        $empleadoId = $pdo->lastInsertId();
        
        $sqlTurnoEmpleado = "INSERT INTO turno_empleado (empleado_id, turno_id) VALUES (:empleado_id, :turno_id)";
        $stmtTurnoEmpleado = $pdo->prepare($sqlTurnoEmpleado);
        $stmtTurnoEmpleado->bindParam(':empleado_id', $empleadoId);
        $stmtTurnoEmpleado->bindParam(':turno_id', $turno);
        $stmtTurnoEmpleado->execute();

        $sqlPwEmpleado = "INSERT INTO password_empleados (id_empleado, password_hash) VALUES (:empleado_id, :password_hash)";
        $stmtPwEmpleado = $pdo->prepare($sqlPwEmpleado);
        $stmtPwEmpleado->bindParam(':empleado_id', $empleadoId);
        $stmtPwEmpleado->bindParam(':password_hash', $passwordHash); 
        $stmtPwEmpleado->execute();
                
        $pdo->commit();

        echo "Registro guardado exitosamente.";
    } catch(PDOException $e) {        
        $pdo->rollBack();
        echo "Error al guardar el registro: " . $e->getMessage();
    }

    $conn = null;
}
?>
