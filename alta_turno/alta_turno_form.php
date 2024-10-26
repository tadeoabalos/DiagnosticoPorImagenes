<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Turno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>    
    <?php 
      include '../utils/header.php'
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
                    <option value="">Selecciona una opción</option>
                    <option value="radiologia">Radiología</option>
                    <option value="cardiologia">Cardiología</option>
                    <option value="pediatria">Pediatría</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="date" required>
            </div>
            <div class="mb-3">
                <label for="time" class="form-label">Hora</label>
                <input type="time" class="form-control" id="time" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Confirmar Turno</button>
        </form>
    </div>    
    <footer>
        <?php 
          include '../utils/footer.php'
        ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>        
        document.getElementById('appointmentForm').addEventListener('submit', function(event) {
            event.preventDefault();            
            alert('Su turno ha sido reservado con éxito.');            
            window.location.href = "../index/index.php"; 
        });
    </script>
</body>
</html>
