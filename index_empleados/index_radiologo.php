<?php
session_start();
if (!isset($_SESSION['empleado_id'])) {
    header('Location: ../index/index.php');  // Redirigir si no está autenticado
    exit;
}

$id_empleado = $_SESSION['empleado_id'];

$pageTitle = 'Radiologo';

include '../utils/header.php';
require '../conexion.php';
?>


<script>
    $(document).on('click', '#view_turno', function(event) {
        $('#modal_turno').remove();
        var id_paciente_turno = $(this).data('id_paciente');
        var id_turno = $(this).data('id');
        var action = 'radiologo';

        $.ajax({
            url: "modal_info_pacientes.php",
            type: 'POST',
            data: {
                paciente: id_paciente_turno,
                id_turno: id_turno,
                action: action
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

<body>
    <div class="container py-5">
        <?php
        if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'subida_exitosa') {
            echo '<div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050;">
                <strong>¡Éxito!</strong> El envio de los datos se realizo correctamente.
                </div>
                <script>
                    setTimeout(function() {
                        var successMessage = document.getElementById("successMessage");
                        successMessage.classList.remove("show");
                        successMessage.classList.add("fade");
                        window.location.replace("index_radiologo.php"); 
                    }, 2000);  // El mensaje desaparecerá después de 2 segundos
                </script>';
        } else if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'subida_erronea') {
            echo '<div id="successMessage" class="alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050;">
                    <strong>Error al enviar los datos</strong> No se pudieron enviar los datos correctamente.
                </div>
                <script>
                    setTimeout(function() {
                        var successMessage = document.getElementById("successMessage");
                        successMessage.classList.remove("show");
                        successMessage.classList.add("fade");
                        window.location.replace("index_radiologo.php"); 
                    }, 2000);  // El mensaje desaparecerá después de 2 segundos
                </script>';
        }
        ?>
        <div class="table-responsive" id="impositivo-content">
            <h4 class="text-center mb-2 text-primary">Pacientes<i class="fas fa-user-alt ms-2"></i></h4>
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

                    $sql = "SELECT tp.id, tp.fecha, tp.hora, p.nombre, p.apellido, p.id_paciente, e.nombre AS especialidad 
FROM turnos_pacientes tp 
JOIN paciente p ON p.id_paciente = tp.id_paciente 
JOIN especializacion e ON e.id_especializacion = tp.id_especializacion 
WHERE tp.id_tecnico = :id_tecnico 
ORDER BY tp.fecha";

                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':id_tecnico', $id_empleado, PDO::PARAM_INT);

                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td class='text-center'><a class='btn btn-sm btn-outline-primary' id='view_turno' data-id_paciente='" . $row['id_paciente'] . "' data-id='" . $row['id'] . "'>
                <i class='fas fa-eye'></i></a></td>";
                            echo "<td style='vertical-align: middle;' class='text-center'>" . htmlspecialchars($row['nombre'] . ' ' . $row['apellido']) . "</td>";
                            echo "<td style='vertical-align: middle;' class='text-center'>" . htmlspecialchars($row['especialidad']) . "</td>";
                            echo "<td style='vertical-align: middle;' class='text-center'>" . htmlspecialchars($row['hora'] . ' ' . $row['fecha']) . "</td>";
                            echo "<td style='vertical-align: middle;' class='text-center'>";
                            // Asignamos el data-id al botón para cada paciente
                            echo "<button class='btn btn-sm btn-success' id='add_button' data-id='" . $row['id_paciente'] . "' title='Enviar datos' data-bs-toggle='modal' data-bs-target='#modal_add_est'>";
                            echo "<i class='fas fa-upload'></i> Enviar Datos";
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

    <div class="modal fade" id="modal_add_est" tabindex="-1" aria-labelledby="modal_add" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center" id="modal-add-label">
                        Enviar Estudio:
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_upload" method="POST" action="../utils/./send_email.php?&action=mail_subida_estudio" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="id_paciente" name="id_paciente">
                        <div class="mb-3">
                            <label for="file" class="form-label"><strong>Archivo del Estudio</strong></label>
                            <small id="fileHelp" class="form-text text-muted">Acepta formatos: JPG, PNG, PDF.</small>
                            <input type="file" class="form-control" id="file" name="file" accept=".jpg,.jpeg,.png,.pdf" aria-describedby="fileHelp" required>
                        </div>

                        <div class="mb-3">
                            <label for="nota" class="form-label"><strong>Nota:</strong></label>
                            <input type="text" class="form-control" id="nota" name="nota" placeholder="Ingrese una nota" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-lg me-3" id="save_rad">Enviar</button>
                            <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '#add_button', function() {
            var id_paciente = $(this).data('id');
            $('#id_paciente').val(id_paciente);
        });
        const modal = document.getElementById('modal_add_est');
        modal.addEventListener('hidden.bs.modal', function() {
            const form = document.getElementById('form_upload');
            form.reset();
            form.querySelector('#id_paciente').value = '';
        });
        $(document).ready(function() {
            $('#table_turnos_pacientes').DataTable({
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sSearch": "Buscar:",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sPrevious": "Anterior",
                        "sNext": "Siguiente",
                        "sLast": "Último"
                    }
                },
                "paging": true,
                "ordering": true,
                "info": true
            });
        });
    </script>
    <?php include '../utils/footer.php'; ?>
</body>

</html>
