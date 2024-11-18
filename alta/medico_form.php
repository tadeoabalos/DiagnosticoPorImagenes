<?php 
    $conexion = mysqli_connect("localhost", "root", "", "radiologia_db");
    if (!$conexion) {
        die("Error al conectar con la base de datos: " . mysqli_connect_error());
    }
    $sql = "SELECT * FROM turno";
    $resultado = mysqli_query($conexion, $sql);
?>
<hr/>
<h5 class="text-primary">Datos del Médico</h5>
<div class="row g-3 mb-3">
        <div class="col-md-6">
            <label for="num_matricula" class="form-label">Número de Matricula</label>
            <input type="text" class="form-control" id="num_matricula" name="num_matricula" placeholder="Ingrese su número de matricula" required>
        </div>
        <div class="col-md-4">    
        <label for="turno" class="form-label">Seleccione el turno</label>
            <select class="form-select" id="turno" name="turno" required>                
                <?php 
                if ($resultado && mysqli_num_rows($resultado) > 0) {
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Error al cargar turnos</option>";
                }
                ?>
            </select>
        </div>
    
</div>