<?php
    session_start();
    require '../../includes/conexion.php';

    if (!isset($_SESSION['usuario_id'])) {
        http_response_code(403);
        echo "No autorizado";
        exit();
    }

    if (!isset($_POST['id'])) {
        http_response_code(400);
        echo "Falta el ID del hábito";
        exit();
    }

    $usuario_id = $_SESSION['usuario_id'];
    $habito_id = intval($_POST['id']);
    $fecha = date('Y-m-d');

    $checkStmt = $conn->prepare("SELECT id FROM historial_habito WHERE habito_id = :habito_id AND fecha = :fecha");
    $checkStmt->bindParam(':habito_id', $habito_id, PDO::PARAM_INT);
    $checkStmt->bindParam(':fecha', $fecha);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        echo "ya_registrado";
        exit();
    }

    try {
        $stmt = $conn->prepare("INSERT INTO historial_habito (fecha, checkk, habito_id) VALUES (:fecha, 1, :habito_id)");
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':habito_id', $habito_id, PDO::PARAM_INT);
        $stmt->execute();
        echo "ok";
    } catch (PDOException $e) {
        error_log("Error al insertar hábito: " . $e->getMessage());
        http_response_code(500);
        echo "Error al guardar";
    }

?>
