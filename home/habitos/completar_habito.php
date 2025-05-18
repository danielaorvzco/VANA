<?php
    // Iniciar sesión
    session_start();

    // Redirigir a Index
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: ../index.html");
        exit();
    }

    // Verificar que se tenga Id del usuario
    if (!isset($_POST['id'])) {
        http_response_code(400);
        echo "Falta el ID del hábito";
        exit();
    }

    // Control de errores
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    try {
        require_once("../../includes/conexion.php");

        // Variables
        $usuario_id = $_SESSION['usuario_id'];
        $habito_id = intval($_POST['id']);
        $fecha = date('Y-m-d');

        // Preparar consulta
        $checkStmt = $conn->prepare("SELECT id FROM historial_habito WHERE habito_id = :habito_id AND fecha = :fecha");
        $checkStmt->bindParam(':habito_id', $habito_id, PDO::PARAM_INT);
        $checkStmt->bindParam(':fecha', $fecha);
        $checkStmt->execute();

        // Si el hábito ya tuvo registro en el día no se hace el INSERT
        if ($checkStmt->rowCount() > 0) {
            echo "ya_registrado";
            exit();
        }

        try {
            // Preparar y ejecutaar INSERT
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
    } catch (PDOException $e) {
        die ("Error PDO: " . $e->getMessage());
    }
?>
