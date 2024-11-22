<?php
include '../conexion.php';

if (isset($_POST['paciente'])) {

    $id_paciente = $_POST['paciente'];
    $id_turno = $_POST['id_turno'];
    $action = $_POST['action'];

    $stmt = $pdo->prepare("SELECT tp.fecha, tp.hora, p.*, e.nombre AS especialidad 
                           FROM turnos_pacientes tp 
                           JOIN paciente p ON p.id_paciente = tp.id_paciente 
                           JOIN especializacion e ON e.id_especializacion = tp.id_especializacion 
                           WHERE p.id_paciente = :id_paciente AND tp.id = :id_turno");

    $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
    $stmt->bindParam(':id_turno', $id_turno, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $dni = $row['dni'];
        $nombre = $row['nombre'];
        $apellido = $row['apellido'];
        $fecha_nacimiento = $row['fecha_nacimiento'];
        $correo = $row['correo'];
        $num_telefonico = $row['num_telefonico'];
        $direccion = $row['direccion'];
        $especialidad = $row['especialidad'];
        $fecha_turno = $row['fecha'];
        $hora_turno = $row['hora'];
    } else {
        $dni = $nombre = $apellido = $fecha_nacimiento = $correo = $num_telefonico = $direccion = $especialidad = $fecha_turno = $hora_turno = '';
    }
}
?>

<style>
    input[readonly] {
    background-color: #e9ecef;
    color: #495057;
    border: 1px solid #ced4da;
    cursor: not-allowed;
    opacity: 0.9;
}

input[readonly]:focus {
    outline: none;
    box-shadow: none;
}
</style>


<div class="modal fade" id="modal_turno" tabindex="-1" aria-labelledby="modal_turnoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-light">
                <h5 class="modal-title w-100 text-center" id="modal-view_turno-label">
                    Turno del paciente: <?php echo htmlspecialchars($nombre) . ' ' . htmlspecialchars($apellido); ?>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-turno-form" action="../alta_turno/procesar_turno.php?&action=edit" method="POST">
                <input type="hidden" class="form-control" id="id_turno" name="id_turno" value="<?php echo htmlspecialchars($id_turno); ?>">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" class="form-control" id="dni" value="<?php echo htmlspecialchars($dni); ?>" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" value="<?php echo htmlspecialchars($nombre); ?>" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" value="<?php echo htmlspecialchars($apellido); ?>" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                            <input type="text" class="form-control" id="fecha_nacimiento" value="<?php echo htmlspecialchars($fecha_nacimiento); ?>" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="correo" value="<?php echo htmlspecialchars($correo); ?>" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="num_telefonico" class="form-label">Número Telefónico</label>
                            <input type="text" class="form-control" id="num_telefonico" value="<?php echo htmlspecialchars($num_telefonico); ?>" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" value="<?php echo htmlspecialchars($direccion); ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="especialidad" class="form-label">Especialidad</label>
                            <input type="text" class="form-control" id="especialidad" value="<?php echo htmlspecialchars($especialidad); ?>" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fecha_turno" class="form-label">Fecha del Turno</label>
                            <input type="text" class="form-control" id="fecha_turno" name="fecha_turno" value="<?php echo htmlspecialchars($fecha_turno); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="hora_turno" class="form-label">Hora del Turno</label>
                            <input type="text" class="form-control" id="hora_turno" name="hora_turno" value="<?php echo htmlspecialchars($hora_turno); ?>">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <?php if($action === 'recepcion'): ?>
                <button type="submit" class="btn btn-primary" id="saveTurnoBtn" form="edit-turno-form">Guardar</button>
                <button type="button" class="btn btn-danger" id="deleteTurnoBtn" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">Eliminar</button>
                <?php endif; ?>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este turno?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

