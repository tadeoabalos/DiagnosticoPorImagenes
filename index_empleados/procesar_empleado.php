<?php
include '../conexion.php'; 

if (isset($_POST['id_empleado'])) {
    $id_empleado = $_POST['id_empleado'];
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $num_telefonico = $_POST['num_telefonico'];
    $direccion = $_POST['direccion'];
    $tipo_empleado = $_POST['tipo_empleado'];
    $turno = $_POST['turno'];

    
    if (empty($id_empleado) || empty($dni) || empty($nombre) || empty($apellido) || empty($correo) || empty($num_telefonico) || empty($direccion) || empty($tipo_empleado) || empty($turno)) {
        die("Todos los campos son obligatorios");
    }

    $stmt = $pdo->prepare("UPDATE empleado
                           SET dni = :dni,
                               nombre = :nombre,
                               apellido = :apellido,
                               correo = :correo,
                               num_telefonico = :num_telefonico,
                               direccion = :direccion,
                               tipo_empleado = :tipo_empleado,
                               turno_id = :turno
                           WHERE id_empleado = :id_empleado");

    $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
    $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    $stmt->bindParam(':num_telefonico', $num_telefonico, PDO::PARAM_STR);
    $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
    $stmt->bindParam(':tipo_empleado', $tipo_empleado, PDO::PARAM_INT);
    $stmt->bindParam(':turno', $turno, PDO::PARAM_INT);
    $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);

    if ($stmt->execute()) {        
        header("Location: ../index_empleados/index_admin.php?mensaje=empleado_editado");        
        exit; 
    } else {
        echo "Error al actualizar el empleado.";
    }
} else {
    echo "ID de empleado no recibido.";
}
?>

