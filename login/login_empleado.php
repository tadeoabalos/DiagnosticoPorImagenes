<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST['dni'];
    $password = $_POST['password'];

    $sql = "SELECT pe.id_empleado, pe.password_hash, e.tipo_empleado, e.nombre, e.apellido, t.id
            FROM password_empleados pe
            JOIN empleado e ON pe.id_empleado = e.id_empleado 
            JOIN tipo_empleado t ON t.id = e.tipo_empleado 
            WHERE e.dni = :dni;";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $storedHash = $row['password_hash'];
            $id_tipoempleado = $row['id'];
            $user = $row['nombre'] . ' ' . $row['apellido'];

            if (password_verify($password, $storedHash)) {
                $_SESSION['empleado_id'] = $row['id_empleado'];
                $_SESSION['dni'] = $dni;
                $_SESSION['user'] = $user;
                $_SESSION['id_empleado'] = $row['id_empleado'];

                switch ($id_tipoempleado) {
                    case 1:
                        $_SESSION['id_tipoempleado'] = 1;
                        header('Location: ../index_empleados/index_radiologo.php');
                        break;
                    case 2:
                        $_SESSION['id_tipoempleado'] = 2;
                        header('Location: ../index_empleados/index_recepcionista.php');
                        break;
                    case 3:
                        $_SESSION['id_tipoempleado'] = 3;
                        header('Location: ../index_empleados/index_admin.php');
                        break;
                    case 4:
                        $_SESSION['id_tipoempleado'] = 4;
                        header('Location: ../index_empleados/index_medico.php');
                        break;
                    default:
                        $_SESSION['error'] = "Tipo de empleado no reconocido.";
                        header('Location: login_empleados_form.php'); // Redirigir al formulario
                        break;
                }
                exit;
            } else {
                $_SESSION['error'] = "Contraseña incorrecta.";
            }
        } else {
            $_SESSION['error'] = "Empleado no encontrado.";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al conectar con la base de datos: " . $e->getMessage();
    }

    // Redirigir al formulario en caso de error
    header('Location: login_empleados_form.php');
    exit;
}