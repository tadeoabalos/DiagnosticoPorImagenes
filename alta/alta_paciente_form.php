<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Pacientes</title>    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<?php include '../utils/header.php' ?>
<body>
<div class="container mt-5 w-75">
    <div class="card shadow-lg">
        <div class="card-header bg-dark text-white text-center">
            <h3>Registro de Paciente</h3>
        </div>
        <div class="card-body">
            <form action="alta_paciente.php" method="POST">                  
                
                <!-- Sección de Datos del Paciente -->
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
                
                <!-- Sección de Contacto de Emergencia -->
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

                <!-- Botón de Envío -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include '../utils/footer.php' ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
