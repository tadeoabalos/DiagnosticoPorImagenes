<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<?php
$pageTitle = 'Radiologo';

include '../utils/header.php';
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

<div class="container py-5">
    <div class="table-responsive" id="impositivo-content">

        <h1 class="text-center mb-5 text-primary">Pacientes<i class="fas fa-user-alt ms-2"></i></h1>
        <table id="table_turnos_pacientes" class="table table-bordered table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th></th>
                    <th style="vertical-align: middle;" class="text-center"><strong>Paciente</strong></th>
                    <th style="vertical-align: middle;" class="text-center"><strong>Turno</strong></th>
                    <th style="vertical-align: middle;" class="text-center"><strong>Especialidad</strong></th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbody_pacientes">
                <?php
                // $stmt = $pdo->prepare("SELECT ..."); //
                // $stmt->execute();

                // if ($stmt->rowCount() > 0) {
                //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //         echo "<tr>";
                //         echo "<td class='text-center'>";
                //         echo "<button class='btn btn-sm btn-outline-primary' id='view_turno' title='Ver Turno' data-bs-toggle="modal" data-bs-target="#modal_turno" data-turno='" . htmlspecialchars($row['id']) . "'><i class='fas fa-eye'></i></button>";
                //         echo "</td>";
                //         echo "<td>" . htmlspecialchars($row['usuario_nombre']) . "</td>";
                //         echo "<td>" . htmlspecialchars($row['fecha_turno']) . "</td>";
                //         echo "<td>" . htmlspecialchars($row['especialidad']) . "</td>";
                //         echo <td style="vertical-align: middle;" class="text-center">
                //         echo       <button class="btn btn-sm btn-success" id="add_button" title="Subir datos" data-bs-toggle="modal" data-bs-target="#modal_add_rad">
                //         echo           <i class="fas fa-upload"></i> Subir
                //         echo      </button>
                //         echo </td>
                //         echo "</tr>";
                //     }
                // } else {
                echo "<tr><td colspan='5' class='text-center'>No hay turnos disponibles</td></tr>";
                //}
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modal_turno" tabindex="-1" aria-labelledby="modal_turnoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="modal-view_turno-label">
                    Informaci&oacute;n del paciente:
                    <!-- <?php //echo htmlspecialchars($idTurno); 
                            ?> -->
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
        </div>
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
                        <label for="description" class="form-label"><strong>Descripción</strong></label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Ingrese una descripción" required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" id="save_rad">Guardar</button>
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
