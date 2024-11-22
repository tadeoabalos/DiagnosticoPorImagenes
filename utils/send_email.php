<?php

require '../conexion.php'; // Conexión a la base de datos

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);


if ($action == 'mail_alta_paciente') {
    try {
        // Consulta el correo del paciente
        $stmt = $pdo->prepare("SELECT correo, nombre, apellido FROM paciente WHERE id_paciente = ?");
        $stmt->execute([$id_paciente]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            throw new Exception('No se encontró un paciente con ese ID.');
        }

        // Obtiene el nombre y apellido del paciente
        $nombre_completo = $row['nombre'] . ' ' . $row['apellido'];
        $correo_paciente = $row['correo']; // Correo del paciente

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'kevinaeze@gmail.com'; // Tu correo
        $mail->Password   = 'wquy abtp zxqf ojaz'; // Tu contraseña o contraseña de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Usar STARTTLS
        $mail->Port       = 587; // Puerto para STARTTLS

        // Remitente y destinatario
        $mail->setFrom('kevinaeze@gmail.com', 'Consultorio Radiologico ');
        $mail->addAddress($correo_paciente, 'Paciente'); // Correo del paciente

        // Contenido del correo
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Bienvenido!!!';
        $mail->Body = '
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #ddd;
        }
        .email-header {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
        }
        .email-body {
            padding: 20px;
            color: #333333;
            line-height: 1.6;
        }
        .email-body p {
            margin: 0 0 10px;
        }
        .email-footer {
            background-color: #f8f9fa;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #6c757d;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            ¡Bienvenido a Consultorio Radiológico!
        </div>
        <div class="email-body">
            <p>Hola <strong>' . htmlspecialchars($nombre_completo) . '</strong>,</p>
            <p>Es un placer darte la bienvenida a nuestro consultorio. Nos alegra que confíes en nosotros para el cuidado de tu salud radiológica.</p>
            <p>Hemos recibido tus datos correctamente y ya formas parte de nuestra red de pacientes.</p>
            <p>Te mantendremos informado de cualquier novedad o actualización relacionada con tus estudios a través de este correo.</p>
            <a href="https://www.consultorioradiologico.com/inicio" class="button">Visitar nuestro sitio web</a>
            <p>Si tienes alguna consulta, no dudes en contactarnos. Estamos aquí para ayudarte.</p>
            <p>Saludos cordiales,<br>El equipo de Consultorio Radiológico</p>
        </div>
        <div class="email-footer">
            <p>Consultorio Radiológico | Todos los derechos reservados</p>
            <p>Tel: +54 9 1234-567890 | Email: info@consultorioradiologico.com</p>
        </div>
    </div>
</body>
</html>
';

        $mail->AltBody = "Hola $nombre_completo,\n\nEs un placer darte la bienvenida a nuestro consultorio. Nos alegra que confíes en nosotros para el cuidado de tu salud radiológica.\n\nTe mantendremos informado de cualquier novedad o actualización relacionada con tus estudios a través de este correo.\n\nSaludos cordiales,\nEl equipo de Consultorio Radiológico.";

        $mail->send();
    } catch (Exception $e) {
        exit;
    }
} else if ($action == 'mail_alta_turno') {

    try {

        $id_paciente = $_POST['id_paciente'];

        // Consulta los datos del paciente
        $stmt = $pdo->prepare("SELECT correo, nombre, apellido FROM paciente WHERE id_paciente = ?");
        $stmt->execute([$id_paciente]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            throw new Exception('No se encontró un paciente con ese ID.');
        }

        // Obtiene el nombre completo y correo del paciente
        $nombre_completo = $row['nombre'] . ' ' . $row['apellido'];
        $correo_paciente = $row['correo']; // Correo del paciente

        // Configuración de PHPMailer
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'kevinaeze@gmail.com'; // Tu correo
        $mail->Password   = 'wquy abtp zxqf ojaz'; // Tu contraseña o contraseña de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Usar STARTTLS
        $mail->Port       = 587; // Puerto para STARTTLS

        // Remitente y destinatario
        $mail->setFrom('kevinaeze@gmail.com', 'Consultorio Radiológico');
        $mail->addAddress($correo_paciente, $nombre_completo); // Correo del paciente

        // Contenido del correo
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Confirmación de Turno Reservado';
        $mail->Body = '
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #212529;
            padding: 20px;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: auto;
            max-width: 600px;
            border: 2px solid #007bff;
        }
        .email-header {
            color: #007bff;
            text-align: center;
        }
        .email-footer {
            font-size: 12px;
            text-align: center;
            color: #6c757d;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1 class="email-header">Confirmación de Turno</h1>
        <p>Estimado/a <strong>' . $nombre_completo . '</strong>,</p>
        <p>Le confirmamos que su turno ha sido reservado con éxito. Los detalles son los siguientes:</p>
        <ul>
            <li><strong>Especialización:</strong> ' . htmlspecialchars($id_especializacion) . '</li>
            <li><strong>Fecha:</strong> ' . htmlspecialchars($fecha) . '</li>
            <li><strong>Hora:</strong> ' . htmlspecialchars($hora) . '</li>
        </ul>
        <p>Si tiene alguna consulta adicional, no dude en ponerse en contacto con nosotros.</p>
        <p>Gracias por confiar en nuestros servicios.</p>
        <div class="email-footer">
            <p>Consultorio Radiológico | Todos los derechos reservados</p>
        </div>
    </div>
</body>
</html>';

        $mail->AltBody = "Estimado/a $nombre_completo,\n\nLe confirmamos que su turno ha sido reservado con éxito. Los detalles son:\n\n" .
            "Especialización: $id_especializacion\n" .
            "Fecha: $fecha\n" .
            "Hora: $hora\n\n" .
            "Gracias por confiar en nuestros servicios.";

        // Envía el correo
        $mail->send();
    } catch (Exception $e) {
        exit;
    }
} else if ($action == 'mail_subida_estudio') {


    if (empty($_POST['id_paciente']) || empty($_FILES['file'])) {
        throw new Exception('Faltan datos del formulario o archivo.');
    }

    try {
        // Recupera el ID del paciente del formulario
        $id_paciente = $_POST['id_paciente'];

        // Consulta el correo del paciente
        $stmt = $pdo->prepare("SELECT correo, nombre, apellido FROM paciente WHERE id_paciente = ?");
        $stmt->execute([$id_paciente]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            throw new Exception('No se encontró un paciente con ese ID.');
        }

        // Obtiene el nombre y apellido del paciente
        $nombre_completo = $row['nombre'] . ' ' . $row['apellido'];
        $correo_paciente = $row['correo']; // Correo del paciente

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'kevinaeze@gmail.com'; // Tu correo
        $mail->Password   = 'wquy abtp zxqf ojaz'; // Tu contraseña o contraseña de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Usar STARTTLS
        $mail->Port       = 587; // Puerto para STARTTLS

        // Remitente y destinatario
        $mail->setFrom('kevinaeze@gmail.com', 'Consultorio Radiologico ');
        $mail->addAddress($correo_paciente, 'Paciente'); // Correo del paciente

        // Datos del formulario
        $nota = htmlspecialchars($_POST['nota']);

        // Verificar si el archivo se ha cargado correctamente
        if ($_FILES['file']['error'] != UPLOAD_ERR_OK) {
            throw new Exception('Error al cargar el archivo.');
        }

        // Validar el tipo de archivo (JPG, JPEG, PNG, PDF)
        $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
        if (!in_array($_FILES['file']['type'], $allowed_types)) {
            throw new Exception('El archivo debe ser JPG, PNG o PDF.');
        }

        // Adjuntar el archivo
        $upload_file = $_FILES['file']['tmp_name'];
        $file_name = $_FILES['file']['name'];
        $mail->addAttachment($upload_file, $file_name);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Nuevo archivo de radiología';
        $mail->Body = '
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #212529;
            padding: 20px;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: auto;
            max-width: 600px;
            border: 2px solid #007bff;
        }
        .email-header {
            color: #007bff;
            text-align: center;
        }
        .email-note {
            background-color: #e9f7ff;
            border-left: 5px solid #007bff;
            padding: 15px;
            margin: 20px 0;
            font-style: italic;
        }
        .email-footer {
            font-size: 12px;
            text-align: center;
            color: #6c757d;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1 class="email-header">Confirmación de subida de su estudio</h1>
        <p>Estimado/a <strong>' . $nombre_completo . '</strong>,</p>
        <p>Nos complace informarle el envío de su estudio. Adjunto a este correo encontrará el archivo correspondiente.</p>';

        if (!empty($nota)) {
            $mail->Body .= '
            <div class="email-note">
                <strong>Nota importante:</strong> ' . $nota . '
            </div>';
        }

        $mail->Body .= '
            <p>Para cualquier consulta adicional, no dude en ponerse en contacto con nosotros. Estamos a su disposición para ayudarle con cualquier duda que pueda tener.</p>
            <p>Gracias por confiar en nuestros servicios.</p>
            <div class="email-footer">
                <p>Consultorio Radiológico | Todos los derechos reservados</p>
            </div>
        </div>
    </body>
</html>
';

        $mail->AltBody = "Estimado/a $nombre_completo,\n\nNos complace informarle que su estudio ha sido recibido correctamente. El archivo correspondiente se encuentra adjunto.\n\n" . (empty($nota) ? '' : "Nota: $nota") . "\n\nGracias por utilizar nuestros servicios.";


        // Enviar correo
        $mail->send();
        echo 'Correo enviado correctamente.';
        header('Location: ../index_empleados/index_radiologo.php?mensaje=subida_exitosa');
        exit;
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
        header('Location: ../index_empleados/index_radiologo.php?mensaje=subida_erronea');
        exit;
    }
}
