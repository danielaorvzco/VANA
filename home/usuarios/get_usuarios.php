<?php
    // Sesión ya inicida en la página en la que se incluyo este archivo

    // Redirigir a Index
    if (!isset($_SESSION['usuario_id'])) {
        http_response_code(403);
        echo "No autorizado";
        exit();
    }

    // Control de errores
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    try {
        include '../includes/conexion.php';

        // Preparar consulta
        $sql = "SELECT * FROM usuario";
        $stmt = $conn->prepare($sql);
        // $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die ("Error PDO: " . $e->getMessage());
    }
?>