<?php 
    $conexion = mysqli_connect("localhost", "root", "", "radiologia_db");
    if (!$conexion) {
        die("Error al conectar con la base de datos: " . mysqli_connect_error());
    }
    $sql = "SELECT * FROM turno";
    $resultado = mysqli_query($conexion, $sql);
?>
<div class="row g-3 mb-3">       
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