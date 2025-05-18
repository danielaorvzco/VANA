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

    try {
        require_once("../../includes/conexion.php");

        // Verificar que los campos recibidos por FORM no estén vacios
        if (
            empty($_POST['nombre']) ||
            empty($_POST['descripcion']) ||
            empty($_POST['frecuencia']) ||
            empty($_POST['meta'])
        ) {
            // Mnesaje de error
            header("Location: ../habitoindex.php?error=1");
            exit;
        }

        // Guarda datos recibidos en varibales
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $frecuencia = $_POST['frecuencia'];
        $meta = $_POST['meta'];
        $usuario_id = $_SESSION['usuario_id'];

        // Preparar INSERT
        $sql = "INSERT INTO habito (nombre, descripcion, frecuencia, meta, usuario_id)
                VALUES (:nombre, :descripcion, :frecuencia, :meta, :usuario_id)";

        // Ejecutar
        $stmt = $conn->prepare($sql);
        $stmt = $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':frecuencia' => $frecuencia,
            ':meta' => $meta,
            ':usuario_id' => $usuario_id
        ]);

        header("Location: ../habitoindex.php");
        exit;

    } catch (PDOException $e) {
        die("Error PDO: " . $e->getMessage());
    }
?>