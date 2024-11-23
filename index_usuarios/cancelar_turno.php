<?php
include '../conexion.php';

if (isset($_POST['id_turno'])) {
    $id_turno = $_POST['id_turno'];    
    $stmt = $pdo->prepare("UPDATE turnos_pacientes SET estado = 'Cancelado', id_tecnico = NULL, fecha_baja = NOW() WHERE ID = :id_turno");
    $stmt->bindParam(':id_turno', $id_turno);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
