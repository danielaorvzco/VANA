<?php
    // Iniciar sesión
    session_start();

    // Redirigir a Index
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: ../index.html");
        exit();
    }

    // Control de errores
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    // Si el ID no es numerico o no esta definida o nula, no se genera el DELETE
    if (!isset($_POST['usuario_id']) || !is_numeric($_POST['usuario_id'])) {
        die("ID de usuario inválido.");
    }

    $id = ($_POST['usuario_id']);

    try {
        require_once("../../includes/conexion.php");

        // Verificar que el usuario exista en la db
        $verificar = $conn->prepare("SELECT id FROM usuario WHERE id = :usuario_id");
        $verificar->execute([':usuario_id' => $id]);

        // Si la variable no tiene registros, no existe el usuario
        if ($verificar->rowCount() === 0) {
            echo ("Usuario no encontrado.");
            exit;
        }

        // Preparar y ejecutar DELETE
        $eliminar = $conn->prepare("DELETE FROM usuario WHERE id = :usuario_id");
        $eliminar->execute([':usuario_id' => $id]);

        header("Location: ../index.php");
        exit;

    } catch (PDOException $e) {
        die ("Error PDO: " . $e->getMessage());
    }
?>
