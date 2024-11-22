<?php
session_start();
if (!isset($_SESSION['empleado_id'])) {
    header('Location: ../index/index.php');  // Redirigir si no está autenticado
    exit;
}
?>
<?php
$pageTitle = 'Administrativo';

include '../utils/header.php';
include '../conexion.php';
?>

<script>
    $(document).on('click', '#edit_turno', function(event) {
        var id_empleado = $(this).data('id');
        console.log("ID del empleado: " + id_empleado);
        var action = 'recepcion';
        $.ajax({
            url: "modal_info_empleado.php",
            type: 'POST',
            data: {
                empleado: id_empleado,
                action: action
            },
            cache: false,
            dataType: 'html',
            success: function(data) {
                $('#modal_empleado').remove();
                var html = data;
                $('body').append(html);
                $('#modal_empleado').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar el modal:", error);
                alert("Hubo un problema al cargar los datos. Por favor, intenta nuevamente.");
            }
        });
    });

    $(document).on('click', '#view_turno', function(event) {
        var id_empleado = $(this).data('id');
        console.log("ID del empleado: " + id_empleado);
        var action = 'recepcion';
        $.ajax({
            url: "modal_info_empleado_view.php",
            type: 'POST',
            data: {
                empleado: id_empleado,
                action: action
            },
            cache: false,
            dataType: 'html',
            success: function(data) {
                $('#modal_empleado').remove();
                var html = data;
                $('body').append(html);
                $('#modal_empleado').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar el modal:", error);
                alert("Hubo un problema al cargar los datos. Por favor, intenta nuevamente.");
            }
        });
    });

    // Confirmación antes de dar de baja al empleado
    $(document).on('click', '.btn-danger', function(event) {
        var id_empleado = $(this).data('id');
        if (confirm("¿Realmente desea dar de baja a este empleado?")) {
            // Redirigir a una página para dar de baja al empleado
            window.location.href = "dar_baja_empleado.php?id=" + id_empleado;
        }
    });
</script>

<body>
    <div class="container py-5">
        <div class="table-responsive" id="impositivo-content">
            <?php
            if (isset($_GET['mensaje'])) {
                $mensaje = $_GET['mensaje'];
                if ($mensaje == 'baja_exitosa') {
                    echo '<div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050;">
                <strong>¡Éxito!</strong> Empleado dado de baja exitosamente.
                </div>
                <script>
                    setTimeout(function() {
                        var successMessage = document.getElementById("successMessage");
                        successMessage.classList.remove("show");
                        successMessage.classList.add("fade");
                    }, 2000);  // El mensaje desaparecerá después de 2 segundos
                </script>';
                } elseif ($mensaje == 'error_baja') {
                    echo '<div id="errorMessage" class="alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050;">
                <strong>Error:</strong> Hubo un problema al dar de baja al empleado.
                </div>
                <script>
                    setTimeout(function() {
                        var errorMessage = document.getElementById("errorMessage");
                        errorMessage.classList.remove("show");
                        errorMessage.classList.add("fade");
                    }, 2000);  // El mensaje desaparecerá después de 2 segundos
                </script>';
                } elseif ($mensaje == 'error_id') {
                    echo '<div id="warningMessage" class="alert alert-warning alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050;">
                <strong>Advertencia:</strong> ID del empleado no válido.
                </div>
                <script>
                    setTimeout(function() {
                        var warningMessage = document.getElementById("warningMessage");
                        warningMessage.classList.remove("show");
                        warningMessage.classList.add("fade");
                    }, 2000);  // El mensaje desaparecerá después de 2 segundos
                </script>';
                }
            }
            ?>

            <?php
            if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'registro_exitoso') {
                echo '<div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050;">
            <strong>¡Éxito!</strong> Registro exitoso. Puede iniciar sesión ahora.
            </div>
            <script>
                setTimeout(function() {
                    var successMessage = document.getElementById("successMessage");
                    successMessage.classList.remove("show");
                    successMessage.classList.add("fade");
                }, 2000);
            </script>';
            } else if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'turno_actualizado') {
                echo '<div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050;">
            <strong>Turno Actualizado con éxito!</strong>
            </div>
            <script>
                setTimeout(function() {
                    var successMessage = document.getElementById("successMessage");
                    successMessage.classList.remove("show");
                    successMessage.classList.add("fade");
                }, 2000);
            </script>';
            } else if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'empleado_editado') {
                echo '<div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050;">
            <strong>¡Éxito!</strong> El empleado ha sido editado correctamente.
            </div>
            <script>
                setTimeout(function() {
                    var successMessage = document.getElementById("successMessage");
                    successMessage.classList.remove("show");
                    successMessage.classList.add("fade");
                }, 2000);
            </script>';
            }
            ?>

            <h1 class="text-center mb-5 text-primary">Administración Empleados</h1>
            <table id="table_turnos" class="table table-bordered table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th style="vertical-align: middle;" class="text-center">
                            <a href="../alta/alta_empleado_form.php" class="text-success"><i class="fas fa-user-plus"></i></a>
                        </th>
                        <th style="vertical-align: middle;" class="text-center"><strong>Empleado</strong></th>
                        <th style="vertical-align: middle;" class="text-center"><strong>Tipo de trabajo</strong></th>
                        <th style="vertical-align: middle;" class="text-center"><strong>Correo Electrónico</strong></th>
                        <th style="vertical-align: middle;" class="text-center"><strong>Turno</strong></th>
                        <th style="vertical-align: middle;" class="text-center"><strong>Fecha de Alta</strong></th>
                        <th style="vertical-align: middle;" class="text-center"><strong>Acciones</strong></th>
                    </tr>
                </thead>
                <tbody id="tbody_turnos">
                    <?php
                    // Modificamos la consulta para excluir empleados dados de baja
                    $stmt = $pdo->prepare("SELECT 
                                        e.id_empleado AS id,
                                        CONCAT(e.nombre, ' ', e.apellido) AS empleado, 
                                        e.correo, 
                                        e.fecha_alta, 
                                        te.descripcion AS tipo_empleado, 
                                        t.nombre AS nombre_turno
                                    FROM empleado e
                                    JOIN tipo_empleado te ON e.tipo_empleado = te.id
                                    LEFT JOIN turno t ON e.turno_id = t.id                                  
                                    WHERE e.tipo_empleado != 3
                                    AND e.fecha_baja IS NULL 
                                    ORDER BY e.fecha_alta");
                    $stmt->execute();


                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td class='text-center'><a class=\"btn btn-sm btn-outline-primary\" id=\"view_turno\" data-id=\"" . htmlspecialchars($row['id']) . "\">
                        <i class=\"fas fa-eye\"></i></a></td>";
                            echo "<td style='vertical-align: middle;' class='text-center'>" . htmlspecialchars($row['empleado']) . "</td>";
                            echo "<td style='vertical-align: middle;' class='text-center'>" . htmlspecialchars($row['tipo_empleado']) . "</td>";
                            echo "<td style='vertical-align: middle;' class='text-center'>" . htmlspecialchars($row['correo']) . "</td>";
                            echo "<td style='vertical-align: middle;' class='text-center'>" . htmlspecialchars($row['nombre_turno']) . "</td>";
                            echo "<td style='vertical-align: middle;' class='text-center'>" . htmlspecialchars($row['fecha_alta']) . "</td>";
                            echo "<td class='text-center'>
                                <a class=\"btn btn-sm btn-primary me-2\" id=\"edit_turno\" data-id=\"" . htmlspecialchars($row['id']) . "\">
                                    <i class='fas fa-pen'></i>
                                </a>
                                <a class=\"btn btn-sm btn-danger\" id=\"edit_turno\" data-id=\"" . htmlspecialchars($row['id']) . "\">
                                    <i class='fas fa-trash'></i>
                                </a>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No hay empleados disponibles</td></tr>";
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include '../utils/footer.php'; ?>
</body>

</html>
