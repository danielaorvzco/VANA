<?php
    session_start();
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: ../index.html");
        exit();
    }

    require '../../includes/conexion.php'; 

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $id = $_POST['id'];
        $nuevo_estado = isset($_POST['completo']) ? 'completo' : 'incompleto';

        try {
            $sql = "UPDATE habito SET estado = :estado WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':estado', $nuevo_estado);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            header("Location: ../habitoindex.php");
            exit();
        } catch (PDOException $e) {
            echo "Error al actualizar estado: " . $e->getMessage();
        }
    }
?>