<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<?php
$pageTitle = 'Administrativo';

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

        <h1 class="text-center mb-5 text-primary">Turnos<i class="fas fa-calendar-alt ms-2"></i></h1>
        <table id="table_turnos" class="table table-bordered table-hover table-striped">
            <thead class="table-dark">
                <tr>

                    <th style="vertical-align: middle;" class="text-center">
                        <button id="add_turno" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#iframeModal">
                            <i class="fas fa-plus"></i>
                        </button>
                    </th>
                    <th style="vertical-align: middle;" class="text-center"><strong></strong></th>
                    <th style="vertical-align: middle;" class="text-center"><strong>Paciente</strong></th>
                    <th style="vertical-align: middle;" class="text-center"><strong>Radiologo</strong></th>
                    <th style="vertical-align: middle;" class="text-center"><strong>Fecha</strong></th>
                </tr>
            </thead>
            <tbody id="tbody_turnos">
                <tr>
                    <td style="vertical-align: middle;" class="text-center">
                        <button class="btn btn-sm btn-outline-primary" id="view_turno" title="Ver Turno" data-bs-toggle="modal" data-bs-target="#modal_turno" data-turno="1">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">#1</td>
                    <td style="vertical-align: middle;" class="text-center">Juan Pérez</td>
                    <td style="vertical-align: middle;" class="text-center">Dr. Martín Rodríguez</td>
                    <td style="vertical-align: middle;" class="text-center">2024-11-21 10:00</td>
                </tr>
                
                <tr>
                    <td style="vertical-align: middle;" class="text-center">
                        <button class="btn btn-sm btn-outline-primary" id="view_turno" title="Ver Turno" data-bs-toggle="modal" data-bs-target="#modal_turno" data-turno="2">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">#2</td>
                    <td style="vertical-align: middle;" class="text-center">Ana Gómez</td>
                    <td style="vertical-align: middle;" class="text-center">Dr. Laura Fernández</td>
                    <td style="vertical-align: middle;" class="text-center">2024-11-22 09:30</td>
                </tr>

                <tr>
                    <td style="vertical-align: middle;" class="text-center">
                        <button class="btn btn-sm btn-outline-primary" id="view_turno" title="Ver Turno" data-bs-toggle="modal" data-bs-target="#modal_turno" data-turno="3">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">#3</td>
                    <td style="vertical-align: middle;" class="text-center">Carlos Ruiz</td>
                    <td style="vertical-align: middle;" class="text-center">Dr. Pedro Sánchez</td>
                    <td style="vertical-align: middle;" class="text-center">2024-11-23 11:15</td>
                </tr>

                <tr>
                    <td style="vertical-align: middle;" class="text-center">
                        <button class="btn btn-sm btn-outline-primary" id="view_turno" title="Ver Turno" data-bs-toggle="modal" data-bs-target="#modal_turno" data-turno="4">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">#4</td>
                    <td style="vertical-align: middle;" class="text-center">María López</td>
                    <td style="vertical-align: middle;" class="text-center">Dr. José Martínez</td>
                    <td style="vertical-align: middle;" class="text-center">2024-11-24 14:00</td>
                </tr>

                <tr>
                    <td style="vertical-align: middle;" class="text-center">
                        <button class="btn btn-sm btn-outline-primary" id="view_turno" title="Ver Turno" data-bs-toggle="modal" data-bs-target="#modal_turno" data-turno="5">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">#5</td>
                    <td style="vertical-align: middle;" class="text-center">Luis Pérez</td>
                    <td style="vertical-align: middle;" class="text-center">Dr. Andrés García</td>
                    <td style="vertical-align: middle;" class="text-center">2024-11-25 16:30</td>
                </tr>

                <tr>
                    <td style="vertical-align: middle;" class="text-center">
                        <button class="btn btn-sm btn-outline-primary" id="view_turno" title="Ver Turno" data-bs-toggle="modal" data-bs-target="#modal_turno" data-turno="6">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">#6</td>
                    <td style="vertical-align: middle;" class="text-center">Elena Martínez</td>
                    <td style="vertical-align: middle;" class="text-center">Dr. Javier López</td>
                    <td style="vertical-align: middle;" class="text-center">2024-11-26 12:45</td>
                </tr>
                <?php
                // $stmt = $pdo->prepare("SELECT ..."); // Seleccionar los datos a mostrar en la tabla generada dinamicamente ['']
                // $stmt->execute();

                // if ($stmt->rowCount() > 0) {
                //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //         echo "<tr>";
                //         echo "<td class='text-center'>";
                //         echo "<button class='btn btn-sm btn-outline-primary' id='view_turno' title='Ver Turno' data-bs-toggle="modal" data-bs-target="#modal_turno" data-turno='" . htmlspecialchars($row['id']) . "'><i class='fas fa-eye'></i></button>";
                //         echo "</td>";
                //         echo "<td>" . htmlspecialchars($row['usuario_nombre']) . "</td>";
                //         echo "<td>" . htmlspecialchars($row['id_radiologo']) . "</td>";
                //         echo "<td>" . htmlspecialchars($row['fecha_turno']) . "</td>";
                //         echo "<td>" . htmlspecialchars($row['estado']) . "</td>";
                //         echo "</tr>";
                //     }
                // } else {
                //echo "<tr><td colspan='5' class='text-center'>No hay turnos disponibles</td></tr>";
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
                    Turno del paciente:
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

<div class="modal fade" id="iframeModal" tabindex="-1" aria-labelledby="iframeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="iframeModalLabel">Alta de Turno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="container my-5">
                    <h2 class="text-center mb-4">Reservar Turno</h2>

                    <form id="appointmentForm" action="procesar_turno.php" method="POST" class="mx-auto" style="max-width: 600px;">
                        <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($id_usuario); ?>">
                        <div class="mb-3">
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
                        <div class="mb-3">
                            <label for="date" class="form-label">Fecha</label>
                            <input type="text" class="form-control" id="date" name="date" placeholder="Seleccione Fecha" required>
                        </div>
                        <div class="mb-3">
                            <label for="time" class="form-label">Hora</label>
                            <select class="form-select" id="time" name="time" required>
                                <option hidden selected value="">Seleccione una hora</option>
                            </select>
                        </div>
                        <button type="submit" id="appointmentForm" class="btn btn-primary w-100">Confirmar Turno</button>
                    </form>

                    <!-- Modal de sesión -->
                    <div class="modal fade" id="sessionModal" tabindex="-1" aria-labelledby="sessionModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header justify-content-center">
                                    <h5 class="modal-title" id="sessionModalLabel">Iniciar Sesión</h5>
                                    <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Debes iniciar sesión para reservar un turno.
                                </div>
                                <div class="modal-footer">
                                    <a href="../login/login.php" class="btn btn-primary">Iniciar Sesión</a>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {

                            var sessionModal = new bootstrap.Modal(document.getElementById('sessionModal'));

                            <?php if ($mostrar_modal): ?>
                                sessionModal.show();
                            <?php endif; ?>

                            document.getElementById('appointmentForm').addEventListener('submit', function(event) {
                                <?php if ($mostrar_modal): ?>
                                    event.preventDefault();
                                    sessionModal.show();
                                <?php endif; ?>
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <?php include '../utils/footer.php'; ?>
</footer>

</body>

</html>