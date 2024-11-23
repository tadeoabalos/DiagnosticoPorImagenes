<?php
session_start();
if (!isset($_SESSION['empleado_id'])) {
    header('Location: ../index/index.php');  // Redirigir si no está autenticado
    exit;
}

$pageTitle = 'Mis Turnos';

include '../utils/header.php';
require '../conexion.php';

// Obtener el empleado_id desde la sesión
$empleado_id = $_SESSION['empleado_id'];

// Consulta SQL para obtener solo los turnos de este empleado
$stmt = $pdo->prepare("SELECT tp.id, tp.fecha, tp.hora, p.*, e.nombre AS especialidad 
                       FROM turnos_pacientes tp 
                       JOIN paciente p ON p.id_paciente = tp.id_paciente 
                       JOIN especializacion e ON e.id_especializacion = tp.id_especializacion 
                       WHERE CONCAT(tp.fecha, ' ', tp.hora) >= NOW() 
                       AND tp.id_tecnico = :empleado_id  
                       ORDER BY tp.fecha, tp.hora");
$stmt->bindParam(':empleado_id', $empleado_id, PDO::PARAM_INT);
$stmt->execute();
?>

<div class="container py-5">
    <h4 class="text-center mb-2 text-primary">Mis Turnos<i class="fas fa-calendar-check ms-2"></i></h4>
                <div class="container" style="margin-bottom: 5px;">
                    <a href="index_radiologo.php" class="btn btn-primary">Volver a lista</a>
                </div>
    <table id="table_turnos_pacientes" class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th></th>
                <th class="text-center"><strong>Paciente</strong></th>
                <th class="text-center"><strong>Especialidad</strong></th>
                <th class="text-center"><strong>Turno</strong></th>                
            </tr>
        </thead>
        <tbody id="tbody_pacientes">
            <?php
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td class='text-center'><a class='btn btn-sm btn-outline-primary' id='view_turno' data-id_paciente='" . $row['id_paciente'] . "' data-id='" . $row['id'] . "'>
                    <i class='fas fa-eye'></i></a></td>";
                    echo "<td class='text-center'>" . htmlspecialchars($row['nombre'] . ' ' . $row['apellido']) . "</td>";
                    echo "<td class='text-center'>" . htmlspecialchars($row['especialidad']) . "</td>";
                    echo "<td class='text-center'>" . htmlspecialchars($row['hora'] . ' ' . $row['fecha']) . "</td>";                                                      
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No tienes turnos disponibles</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
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
<?php include '../utils/footer.php'; ?>
