<?php
session_start();  

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../conexion.php';  

if ($_SERVER["REQUEST_METHOD"] == "POST") {    
    $dni = $_POST['dni'];
    $password = $_POST['password'];
    
    var_dump($dni, $password); 
    
    $sql = "SELECT pe.id_empleado, pe.password_hash 
            FROM password_empleados pe
            JOIN empleado e ON pe.id_empleado = e.id_empleado  
            WHERE e.dni = :dni;";

    echo $sql;
    try {       
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':dni', $dni);
        
        $stmt->execute();
        echo "0";  

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $storedHash = $row['password_hash'];
            echo "1";  
            if (password_verify($password, $storedHash)) {                
                $_SESSION['empleado_id'] = $row['id_empleado'];
                $_SESSION['dni'] = $dni;
                echo "2";  
                header('Location: ../index_empleados/index.php');  
                exit;
            } else {
                $error = "Contraseña incorrecta.";
                echo "3";  
            }
        } else {
            $error = "Empleado no encontrado.";
            echo "4";  
        }
    } catch (PDOException $e) {
        $error = "Error al conectar con la base de datos: " . $e->getMessage();
    }
}

?>