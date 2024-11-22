<?php
include '../conexion.php';
if (isset($_POST['empleado'])) {
    $id_empleado = $_POST['empleado'];

    $stmt = $pdo->prepare("SELECT e.id_empleado, e.nombre, e.apellido, e.dni, e.correo, e.num_telefonico, e.direccion, e.tipo_empleado,
                                   e.fecha_alta, e.turno_id
                           FROM empleado e                                                      
                           WHERE e.id_empleado = :id_empleado");

    $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_empleado = $row['id_empleado'];
        $dni = $row['dni'];
        $nombre = $row['nombre'];
        $apellido = $row['apellido'];
        $correo = $row['correo'];
        $num_telefonico = $row['num_telefonico'];
        $direccion = $row['direccion'];
        $tipo_empleado = $row['tipo_empleado'];
        $fecha_alta = $row['fecha_alta'];
        $turno = $row['turno_id'];        
    } else {        
        $dni = $nombre = $apellido = $correo = $num_telefonico = $direccion = $tipo_empleado = $fecha_alta = $nombre_turno = '';
    }
}
?>
<?php 
    $conexion = mysqli_connect("localhost", "root", "", "radiologia_db");
    if (!$conexion) {
        die("Error al conectar con la base de datos: " . mysqli_connect_error());
    }
    $sql = "SELECT * FROM turno";
    $resultado = mysqli_query($conexion, $sql);
?>
<div class="modal fade" id="modal_empleado" tabindex="-1" aria-labelledby="modal_empleadoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-light">
                <h5 class="modal-title w-100 text-center" id="modal-empleado-label">
                    Información del Empleado: <?php echo htmlspecialchars($nombre) . ' ' . htmlspecialchars($apellido); ?>                    
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-empleado-form" action="procesar_empleado.php?action=edit" method="POST">
                    <input type="hidden" name="id_empleado" value="<?php echo htmlspecialchars($id_empleado); ?>">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" class="form-control" id="dni" name="dni" value="<?php echo htmlspecialchars($dni); ?>" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo htmlspecialchars($apellido); ?>" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($correo); ?>" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="num_telefonico" class="form-label">Número Telefónico</label>
                            <input type="text" class="form-control" id="num_telefonico" name="num_telefonico" value="<?php echo htmlspecialchars($num_telefonico); ?>" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($direccion); ?>" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tipo_empleado" class="form-label">Tipo de Empleado</label>
                            <select class="form-select" id="tipo-empleado" name="tipo_empleado" disabled>
                                <option value="" disabled selected>Selecciona un tipo de empleado</option>
                                <option value="1" <?php echo ($tipo_empleado == 1) ? 'selected' : ''; ?>>Técnico</option>
                                <option value="2" <?php echo ($tipo_empleado == 2) ? 'selected' : ''; ?>>Recepcionista</option>
                                <option value="3" <?php echo ($tipo_empleado == 3) ? 'selected' : ''; ?>>Admin</option>                        
                            </select>                             
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nombre_turno" class="form-label">Turno</label>
                            <select class="form-select" id="turno" name="turno" disabled>                
                            <?php                                                                                               
                                if ($resultado && mysqli_num_rows($resultado) > 0) {
                                    while ($row = mysqli_fetch_assoc($resultado)) {                                        
                                        $selected = ($row['id'] == $turno) ? 'selected' : ''; 
                                        echo "<option value='" . $row['id'] . "' $selected>" . $row['nombre'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>Error al cargar turnos</option>";
                                }
                            ?>
                            </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fecha_alta" class="form-label">Fecha de Alta</label>
                            <input type="text" class="form-control" id="fecha_alta" name="fecha_alta" value="<?php echo htmlspecialchars($fecha_alta); ?>" readonly>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
