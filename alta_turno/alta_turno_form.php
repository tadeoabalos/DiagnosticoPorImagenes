<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Turno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <?php 
        include '../utils/header.php';                
        $fechasOcupadas = ['2024-11-01', '2024-11-05', '2024-11-10'];
    ?>    

    <div class="container my-5">
        <h2 class="text-center mb-4">Reservar Turno</h2>
        <p class="text-center">Complete el formulario para reservar un turno en nuestra clínica.</p>

        <form id="appointmentForm" class="mx-auto" style="max-width: 600px;">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre Completo</label>
                <input type="text" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Teléfono</label>
                <input type="tel" class="form-control" id="phone" required>
            </div>
            <div class="mb-3">
                <label for="service" class="form-label">Especialidad</label>
                <select class="form-select" id="service" required>
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
                <input type="text" class="form-control" id="date" placeholder="Seleccione una fecha" required>
            </div>
            <div class="mb-3">
                <label for="time" class="form-label">Hora</label>
                <input type="time" class="form-control" id="time" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Confirmar Turno</button>
        </form>
    </div>    

    <footer>
        <?php include '../utils/footer.php'; ?>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>        
        const fechasOcupadas = <?php echo json_encode($fechasOcupadas); ?>;
        
        flatpickr("#date", {
            dateFormat: "Y-m-d",
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
            }
        });        
        document.getElementById('appointmentForm').addEventListener('submit', function(event) {
            event.preventDefault();
            alert('Su turno ha sido reservado con éxito.');
            window.location.href = "../index/index.php"; 
        });
    </script>
</body>
</html>
