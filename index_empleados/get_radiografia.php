<?php
require '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_paciente'])) {
    $id_paciente = intval($_POST['id_paciente']);

    try {
        $stmt = $pdo->prepare("
            SELECT id, fecha_subida AS fecha, nota, archivo
            FROM radiografias
            WHERE id_paciente = :id_paciente
            ORDER BY fecha DESC
        ");
        $stmt->execute(['id_paciente' => $id_paciente]);
        $radiografias = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($radiografias) {
            echo json_encode([
                'status' => 'success',
                'data' => $radiografias
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No se encontraron radiografías para este paciente.'
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error al consultar las radiografías: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Solicitud inválida.'
    ]);
}
