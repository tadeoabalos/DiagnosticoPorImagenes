<?php
session_start();
if (!isset($_SESSION['empleado_id'])) {
    header('Location: ../index/index.php');  // Redirigir si no está autenticado
    exit;
}

$pageTitle = 'Radiologo';

include '../utils/header.php';
include '../conexion.php';
?>

<style>
    html,
    body {
        height: 100%;
    }

    body {
        display: flex;
        flex-direction: column;
    }

    .container {
        flex: 1;
    }
</style>
<!DOCTYPE html>
<html lang="es">

<script>
    $(document).on('click', '#view_turno', function(event) {
        var id_paciente_turno = $(this).data('id');
        var action = 'radiologo';

        $.ajax({
            url: "modal_info_pacientes.php",
            type: 'POST',
            data: {
                paciente: id_paciente_turno,
                action : action
            },
            cache: false,
            dataType: 'html',
            success: function(data) {
                $('#modal_turno').remove();
                var html = data;
                $('body').append(html);
                $('#modal_turno').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar el modal:", error);
                alert("Hubo un problema al cargar los datos. Por favor, intenta nuevamente.");
            }
        });
    });
</script>
<div class="container py-5">
    <div class="table-responsive" id="impositivo-content">

        <h1 class="text-center mb-5 text-primary">Pacientes<i class="fas fa-user-alt ms-2"></i></h1>
        <table id="table_turnos_pacientes" class="table table-bordered table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th></th>
                    <th style="vertical-align: middle;" class="text-center"><strong>Paciente</strong></th>
                    <th style="vertical-align: middle;" class="text-center"><strong>Especialidad</strong></th>
                    <th style="vertical-align: middle;" class="text-center"><strong>Turno</strong></th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbody_pacientes">
                <?php
                 $stmt = $pdo->prepare("SELECT tp.fecha, tp.hora, p.*, e.nombre AS especialidad 
                 FROM turnos_pacientes tp 
                 JOIN paciente p ON p.id_paciente = tp.id_paciente 
                 JOIN especializacion e ON e.id_especializacion = tp.id_especializacion 
                 WHERE 1=1 ORDER BY fecha");
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td class='text-center'><a class=\"btn btn-sm btn-outline-primary\" id=\"view_turno\" data-id=\"" . $row['id_paciente'] . "\">
                            <i class=\"fas fa-eye\"></i></a></td>";
                        echo "<td style='vertical-align: middle;' class='text-center'>" . htmlspecialchars($row['nombre'] . ' ' . $row['apellido']) . "</td>";
                        echo "<td style='vertical-align: middle;' class='text-center'>" . htmlspecialchars($row['especialidad']) . "</td>";
                        echo "<td style='vertical-align: middle;' class='text-center'>" . htmlspecialchars($row['hora'] . ' ' . $row['fecha']) . "</td>";
                        echo "<td style='vertical-align: middle;' class='text-center'>";
                        echo "<button class='btn btn-sm btn-success' id='add_button' title='Subir datos' data-bs-toggle='modal' data-bs-target='#modal_add_rad'>";
                        echo "<i class='fas fa-upload'></i> Subir";
                        echo "</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No hay turnos disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modal_add_rad" tabindex="-1" aria-labelledby="modal_add" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="modal-add-label">
                    Subir Radiolog&iacute;a:
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_upload_rad">

                    <div class="mb-3">
                        <label for="file_rad" class="form-label"><strong>Archivo de Radiología</strong></label>
                        <input type="file" class="form-control" id="file_rad" name="file_rad" accept=".jpg,.jpeg,.png,.pdf" required>
                        <small class="form-text text-muted">Acepta formatos: JPG, PNG, PDF.</small>
                    </div>

                    <div class="mb-3">
                        <label for="nota" class="form-label"><strong>Nota:</strong></label>
                        <input type="text" class="form-control" id="nota" name="nota" placeholder="Ingrese una nota" required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" id="save_rad">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<footer>
    <?php include '../utils/footer.php'; ?>
</footer>

</body>

</html>
