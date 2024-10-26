<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>    
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
        .login-container {
            max-width: 400px;
            padding: 30px;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .login-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .btn-login {
            background-color: #007bff;
            color: white;
        }
        .btn-login:hover {
            background-color: #0056b3;
        }
        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007bff;
        }
        .forgot-password:hover {
            text-decoration: underline;
            color: #0056b3;
        }
    </style>
</head>
<body>
    
    <div class="login-container">
        <h2>Acceso Profesional</h2>        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="contraseña" class="form-label">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
            <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
