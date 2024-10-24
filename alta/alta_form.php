<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alta de Usuario Administrativo</title>
</head>
<body>
    <h2>Alta de Usuario Administrativo</h2>
    
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form action="" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required><br><br>

        <label for="rol_id">Rol:</label>
        <select id="rol_id" name="rol_id" required>            
            <option value="1">Administrador</option>
            <option value="2">Recepcionista</option>
            <option value="3">Radiólogo</option>            
        </select><br><br>

        <input type="submit" value="Crear Usuario">
    </form>
    <a href="../login/login.php">LOGUEATE</a>
</body>
</html>
