<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['empleado_id'])) {
    header('Location: ../index/index.php');  // Redirigir si no está autenticado
    exit;
}

include '../conexion.php';  // Incluir archivo de conexión

// Verificar si se ha recibido el ID del empleado
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_empleado = $_GET['id'];

    try {
        // Preparar la consulta para actualizar la fecha de baja
        $stmt = $pdo->prepare("UPDATE empleado SET fecha_baja = NOW() WHERE id_empleado = :id_empleado");
        $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir a la página de administración con un mensaje de éxito
            header('Location: ../index_empleados/index_admin.php?mensaje=baja_exitosa');
        } else {
            // Si hay un error al ejecutar la consulta
            header('Location: ../index_empleados/index_admin.php?mensaje=error_baja');
        }
    } catch (PDOException $e) {
        // Manejo de errores de la base de datos
        echo "Error: " . $e->getMessage();
    }
} else {
    // Si no se recibe un ID válido
    header('Location: ../index_empleados/index_admin.php?mensaje=error_id');
}
exit;
?>
