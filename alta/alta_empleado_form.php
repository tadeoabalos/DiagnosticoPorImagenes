<?php 
$pageTitle = 'Registro de Empleados';
include '../utils/header.php'; 
?>

<body class="d-flex flex-column min-vh-100">
    <div class="container mt-5 mb-5 flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="card shadow-lg w-75">
            <div class="card-header bg-dark text-white text-center">
                <h3>Registro de Empleado</h3>
            </div>
            <div class="card-body">
                <form id="formulario-empleado" action="alta_empleado.php" method="POST">
                    <h5 class="text-primary">Datos del Empleado</h5>
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
                        <label for="tipo-empleado" class="form-label">Tipo de empleado</label>
                        <select class="form-select" id="tipo-empleado" name="tipo_empleado">
                            <option hidden value="0">Seleccione un tipo de empleado</option>
                            <option value="1">Técnico</option>
                            <option value="2">Recepcionista</option>
                            <option value="4">Medico</option>
                            <option value="3">Admin</option>
                        </select>
                    </div>

                    <div id="formulario-especifico"></div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include '../utils/footer.php' ?>

    <script>
        $('#tipo-empleado').change(function() {
            const tipoEmpleado = $(this).val();

            if (tipoEmpleado != '0' && tipoEmpleado != '4') {
                $.ajax({
                    url: './obtener_formulario.php',
                    type: 'POST',
                    data: {
                        tipo_empleado: tipoEmpleado
                    },
                    success: function(response) {
                        $('#formulario-especifico').html(response);
                    },
                    error: function() {
                        alert('Error al cargar el formulario');
                    }
                });
            } else {
                $('#formulario-especifico').empty();
            }
        });
    </script>
    
</body>

</html>
