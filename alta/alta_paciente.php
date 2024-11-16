<?php
require '../conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {    
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $dni = $_POST['dni'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $password = $_POST['password'];

    $contactoNombre = $_POST['contacto_nombre'];
    $contactoApellido = $_POST['contacto_apellido'];
    $contactoTelefono = $_POST['contacto_telefonico'];
    
    if (empty($nombre) || empty($apellido) || empty($correo) || empty($dni) || empty($password) ||
        empty($contactoNombre) || empty($contactoApellido) || empty($contactoTelefono)) {
        echo "Por favor, complete todos los campos obligatorios.";
        exit();
    }

    try {
        $pdo->beginTransaction();
               
        $checkEmailQuery = "SELECT * FROM paciente WHERE correo = ?";
        $stmt = $pdo->prepare($checkEmailQuery);
        $stmt->execute([$correo]);

        if ($stmt->rowCount() > 0) {
            echo "El correo ya está registrado. Intente con otro.";
            exit();
        }
                
        $queryPaciente = "INSERT INTO paciente (nombre, apellido, correo, dni, direccion, num_telefonico, fecha_nacimiento) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtPaciente = $pdo->prepare($queryPaciente);
        $stmtPaciente->execute([$nombre, $apellido, $correo, $dni, $direccion, $telefono, $fecha_nacimiento]);
                
        $id_paciente = $pdo->lastInsertId();
                
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $queryPassword = "INSERT INTO password (id_paciente, password_hash, fecha_alta) 
                          VALUES (?, ?, NOW())";
        $stmtPassword = $pdo->prepare($queryPassword);
        $stmtPassword->execute([$id_paciente, $passwordHash]);
        
        $queryContactoEmergencia = "INSERT INTO contactosemergencia (PacienteID, Nombre, Apellido, Numtelefonico) 
                                    VALUES (?, ?, ?, ?)";
        $stmtContacto = $pdo->prepare($queryContactoEmergencia);
        $stmtContacto->execute([$id_paciente, $contactoNombre, $contactoApellido, $contactoTelefono]);

        $pdo->commit();
        echo "Registro exitoso. Puede iniciar sesión ahora.";
    } catch (Exception $e) {        
        $pdo->rollBack();
        echo "Error al registrar el paciente: " . $e->getMessage();
    }
}
?>
