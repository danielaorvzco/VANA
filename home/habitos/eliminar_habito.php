<?php
    session_start();
    require '../../includes/conexion.php';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $usuario_id = $_SESSION['usuario_id'];
        $habito_id = $_POST['habito_id'];

        try {
            $sql = "DELETE FROM habito WHERE id = :id AND usuario_id = :usuario_id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':id' => $habito_id,
                ':usuario_id' => $usuario_id
            ]);

            header("Location: ../habitoindex.php"); 
            exit();
        } catch (PDOException $e) {
            echo "Error al eliminar hábito: " . $e->getMessage();
        }
    }
?>