<?php
session_start();
$mostrar_modal = !isset($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html lang="es">
<?php
$pageTitle = 'Reservar Turno';
include '../utils/header.php';
$fechasOcupadas = ['2024-11-01', '2024-11-05', '2024-11-10'];
?>

<div class="container my-5">
    <h2 class="text-center mb-4">Reservar Turno</h2>
    <p class="text-center">Complete el formulario para reservar un turno en nuestra clínica.</p>

    <form id="appointmentForm" action="procesar_turno.php" method="POST" class="mx-auto" style="max-width: 600px;">
        <div class="mb-3">
            <label for="name" class="form-label">Nombre Completo</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input type="tel" class="form-control" id="phone" name="phone" required>
        </div>
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

<footer>
    <?php include '../utils/footer.php'; ?>
</footer>

<script>
    const fechasOcupadas = <?php echo json_encode($fechasOcupadas); ?>;

    function generarHoras() {
        const timeSelect = document.getElementById("time");
        timeSelect.innerHTML = '<option hidden selected value="">Seleccione una hora</option>';

        for (let hour = 8; hour < 17; hour++) {
            ["00", "30"].forEach(minute => {
                const option = document.createElement("option");
                option.value = `${hour.toString().padStart(2, '0')}:${minute}`;
                option.textContent = `${hour.toString().padStart(2, '0')}:${minute}`;
                timeSelect.appendChild(option);
            });
        }
    }

    flatpickr("#date", {
        dateFormat: "d-m-Y",
        minDate: "today",
        maxDate: new Date().fp_incr(30),
        disable: [
            ...fechasOcupadas,
            function(date) {
                return date.getDay() === 0;
            }
        ],
        locale: {
            firstDayOfWeek: 1
        },
        onChange: function(selectedDates, dateStr, instance) {
            document.getElementById('time').disabled = false;
            generarHoras();
        }
    });
</script>
</body>

</html>