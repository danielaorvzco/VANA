<?php 
    session_start();

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    try {
        require_once "../../includes/conexion.php";

        if (
            empty($_POST['nombre']) ||
            empty($_POST['descripcion']) ||
            empty($_POST['frecuencia']) ||
            empty($_POST['meta'])
        ) {
            echo "Todos los campos obligatorios deben llenarse. <a href='registrar_usuario.html'>Volver</a>";
            exit;
        }

        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $frecuencia = $_POST['frecuencia'];
        $meta = $_POST['meta'];
        $usuario_id = $_SESSION['usuario_id'];

        $sql = "INSERT INTO habito (nombre, descripcion, frecuencia, meta, usuario_id)
                VALUES (:nombre, :descripcion, :frecuencia, :meta, :usuario_id)";

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