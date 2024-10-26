<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Usuario Administrativo</title>    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>        
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            margin: 0;
        }
        .form-container {
            max-width: 500px;
            padding: 30px;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .btn-submit, .btn-login {
            width: 100%;
        }
        .btn-login {
            margin-top: 10px;
            text-align: center;
            display: block;
            color: #007bff;
            text-decoration: none;
        }
        .btn-login:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Alta de Usuario</h2>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form action="" method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="contraseña" class="form-label">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="rol_id" class="form-label">Rol:</label>
                <select id="rol_id" name="rol_id" class="form-select" required>
                    <option value="1">Administrador</option>
                    <option value="2">Recepcionista</option>
                    <option value="3">Radiólogo</option>  
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-submit">Crear Usuario</button>
        </form>
        <a href="../login/login.php" class="btn-login">Logueate</a>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
