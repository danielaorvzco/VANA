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

        // Guardar ID del usuario desde la sesión y ID del hábito desde el FORM
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuario_id = $_SESSION['usuario_id'];
            $habito_id = $_POST['habito_id'];

            try {
                // Preparar y ejecutar DELETE
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
    } catch (PDOException $e) {
        die ("Error PDO: " . $e->getMessage());
    }
?>
