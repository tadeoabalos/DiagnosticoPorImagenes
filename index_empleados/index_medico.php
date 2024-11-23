<?php
session_start();
if (!isset($_SESSION['empleado_id'])) {
    header('Location: ../index/index.php'); // Redirigir si no está autenticado
    exit;
}

$id_empleado = $_SESSION['empleado_id'];

$pageTitle = 'Medico';

include '../utils/header.php';
require '../conexion.php';
?>

<script>
    $(document).on('change', '#selectPaciente', function() {
        var id_paciente = $(this).val();

        if (id_paciente) {
            $.ajax({
                url: "get_radiografia.php",
                type: 'POST',
                data: {
                    id_paciente: id_paciente
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        const radiografias = response.data;
                        let radiografiasHtml = '';

                        radiografias.forEach((rad) => {
                            radiografiasHtml += `
                                <tr>
                                    <td>${rad.fecha}</td>
                                    <td>${rad.nota || 'Sin nota'}</td>
                                    <td class="text-center">
                                        <button class="btn btn-primary btn-sm view-image" data-image="${rad.archivo}">
                                            Ver Imagen
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });

                        $('#radiografias_table tbody').html(radiografiasHtml);
                    } else {
                        let radiografiasHtml = '';
                        radiografiasHtml += `
                                <tr>
                                    <td>No se encontraron radiografías.</td>
                                    
                                </tr>
                            `;
                        $('#radiografias_table tbody').html(radiografiasHtml);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error al cargar las radiografías:", error);
                    alert("Hubo un problema al cargar los datos. Por favor, intenta nuevamente.");
                }
            });
        } else {
            $('#radiografias_table tbody').html('');
        }
    });

    $(document).on('click', '.view-image', function() {
        const imageUrl = $(this).data('image');
        $('#modal_view_rad .modal-body').html(`
        <div class="image-container">
            <img src="${imageUrl}" alt="Radiografía" class="img-fluid img-thumbnail" id="zoomImage">
        </div>
    `);
        $('#modal_view_rad').modal('show');

        $('#zoomImage').css('cursor', 'zoom-in').on('click', function() {
            var scale = $(this).hasClass('zoomed') ? 1 : 2; // Toggle zoom between 1x and 2x
            $(this).toggleClass('zoomed');
            $(this).css('transform', `scale(${scale})`);
        });
    });

    $(document).on('click', '#back-to-list', function() {
        $('#selectPaciente').trigger('change');
    });
</script>

<body>
    <div class="container py-5">
        <h1 class="text-center mb-5 text-primary">
            Médico <i class="fas fa-user-md ms-2"></i>
        </h1>

        <div class="mb-4">
            <label for="selectPaciente" class="form-label">Seleccionar Paciente</label>
            <select class="form-select" id="selectPaciente">
                <option value="">Seleccione un paciente</option>
                <?php
                $stmt = $pdo->prepare("SELECT id_paciente, nombre, apellido FROM paciente");
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row['id_paciente'] . "'>" . htmlspecialchars($row['nombre'] . ' ' . $row['apellido']) . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="radiografias_table">
                <thead class="table-dark">
                    <tr>
                        <th>Fecha</th>
                        <th>Nota</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Las radiografías se cargarán aquí -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para visualizar radiografía -->
    <div class="modal fade" id="modal_view_rad" tabindex="-1" aria-labelledby="modalViewRadLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalViewRadLabel">Visualización de Radiografías</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <?php include '../utils/footer.php'; ?>
</body>

</html>