<?php
if (isset($_POST['tipo_empleado'])) {
    $tipoEmpleado = $_POST['tipo_empleado'];
    
    switch ($tipoEmpleado) {
        case '1': 
            include './tecnico_form.php';
            break;
        case '2': 
            include './medico_form.php';
            break;        
        default:
            include './default_form.php';     
            break;
    }
}
?>