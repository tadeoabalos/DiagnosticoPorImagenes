<?php
session_start();
if (!isset($_SESSION['empleado_id'])) {
    header('Location: ../index/index.php');  // Redirigir si no está autenticado
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<?php
$pageTitle = 'Administrativo';

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

<script>
    $(document).on('click', '#view_turno', function(event) {
        var id_paciente_turno = $(this).data('id');
        var action = 'recepcion';

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
                }, 2000);  // El mensaje desaparecerá después de 2 segundos
            </script>';
                } else if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'turno_actualizado') {
                    echo '<div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050;">
                <strong>Turno Actualizado con exito!</strong> Registro exitoso.
            </div>
            <script>
                setTimeout(function() {
                    var successMessage = document.getElementById("successMessage");
                    successMessage.classList.remove("show");
                    successMessage.classList.add("fade");
                }, 2000);  // El mensaje desaparecerá después de 2 segundos
            </script>';
        }
        ?>
        <h1 class="text-center mb-5 text-primary">Turnos<i class="fas fa-calendar-alt ms-2"></i></h1>
        <table id="table_turnos" class="table table-bordered table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th style="vertical-align: middle;" class="text-center">
                        <button id="add_turno" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#iframeModal">
                            <i class="fas fa-plus"></i>
                        </button>
                    </th>
                    <th style="vertical-align: middle;" class="text-center"><strong>Paciente</strong></th>
                    <th style="vertical-align: middle;" class="text-center"><strong>Especialidad</strong></th>
                    <th style="vertical-align: middle;" class="text-center"><strong>Fecha</strong></th>
                    <th style="vertical-align: middle;" class="text-center"><strong>Hora</strong></th>
                </tr>
            </thead>
            <tbody id="tbody_turnos">
                <?php
                $stmt = $pdo->prepare("SELECT tp.id, tp.fecha, tp.hora, p.*, e.nombre AS especialidad 
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
                        echo "<td  style='vertical-align: middle;' class='text-center'>" . htmlspecialchars($row['especialidad']) . "</td>";
                        echo "<td  style='vertical-align: middle;' class='text-center'>" . htmlspecialchars($row['fecha']) . "</td>";
                        echo "<td  style='vertical-align: middle;' class='text-center'>" . htmlspecialchars($row['hora']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No hay turnos disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="iframeModal" tabindex="-1" aria-labelledby="iframeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="iframeModalLabel">Registro de Paciente / Turno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="text-center mb-4">
                        <button type="button" id="btnYaTieneUsuario" class="btn btn-outline-primary me-2">Ya tiene usuario</button>
                        <button type="button" id="btnNoTieneUsuario" class="btn btn-outline-secondary">No tiene usuario</button>
                    </div>

                    <form id="formYaTieneUsuario" action="procesar_turno.php" method="POST" class="d-none">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="service" class="form-label">Especialidad</label>
                                <select class="form-select" id="service" name="service" required>
                                    <option hidden selected value="">Selecciona una opción</option>
                                    <option value="radiologia">Radiología</option>
                                    <option value="ecografia">Ecografía</option>
                                    <option value="doppler">Ecografía Doppler</option>
                                    <option value="mamografia">Mamografía</option>
                                    <option value="resonancia_magnetica">Resonancia Magnética</option>
                                    <option value="estudios_cardiologicos">Estudios Cardiológicos</option>
                                    <option value="imagenes_dentales">Imágenes Dentales</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date" class="form-label">Fecha</label>
                                <input type="text" class="form-control" id="date" name="date" placeholder="Seleccione Fecha" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="time" class="form-label">Hora</label>
                                <select class="form-select" id="time" name="time" required>
                                    <option hidden selected value="">Seleccione una hora</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Confirmar Turno</button>
                    </form>

                    <form id="formNoTieneUsuario" action="../alta/alta_paciente.php?&site=recepcionista" method="POST" class="d-none">
                        <h5 class="text-primary">Datos del Paciente</h5>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ingrese su apellido" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="correo" name="correo" placeholder="nombre@ejemplo.com" required>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="text" class="form-control" id="dni" name="dni" placeholder="Ingrese su DNI" required>
                            </div>
                            <div class="col-md-4">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingrese su número telefónico">
                            </div>
                            <div class="col-md-4">
                                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Calle, Número, Ciudad">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese una contraseña" required>
                        </div>

                        <hr>
                        <h5 class="text-primary">Contacto de Emergencia</h5>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="contacto_nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="contacto_nombre" name="contacto_nombre" placeholder="Nombre del contacto" required>
                            </div>
                            <div class="col-md-6">
                                <label for="contacto_apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="contacto_apellido" name="contacto_apellido" placeholder="Apellido del contacto" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="contacto_telefonico" class="form-label">Número Telefónico</label>
                            <input type="text" class="form-control" id="contacto_telefonico" name="contacto_telefonico" placeholder="Teléfono del contacto" required>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const btnYaTieneUsuario = document.getElementById('btnYaTieneUsuario');
    const btnNoTieneUsuario = document.getElementById('btnNoTieneUsuario');
    const formYaTieneUsuario = document.getElementById('formYaTieneUsuario');
    const formNoTieneUsuario = document.getElementById('formNoTieneUsuario');

    btnYaTieneUsuario.addEventListener('click', () => {
        formYaTieneUsuario.classList.remove('d-none');
        formNoTieneUsuario.classList.add('d-none');
    });

    btnNoTieneUsuario.addEventListener('click', () => {
        formNoTieneUsuario.classList.remove('d-none');
        formYaTieneUsuario.classList.add('d-none');
    });
</script>

<footer>
    <?php include '../utils/footer.php'; ?>
</footer>

</body>

</html>
