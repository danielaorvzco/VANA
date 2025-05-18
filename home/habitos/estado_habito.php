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

        // Comprobar que re recibe el ID del hábito a modificar
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];
            // Si el nuevo_estado es COMPLETO -> se guarda 'completo', si es falso 'incompleto'
            $nuevo_estado = isset($_POST['completo']) ? 'completo' : 'incompleto';

            try {
                // Preparar y ejecutar UPDATE
                $sql = "UPDATE habito SET estado = :estado WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':estado', $nuevo_estado);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();

                header("Location: ../habitoindex.php");
                exit();
            } catch (PDOException $e) {
                // El nuevo_estado es incompleto y no sucede el UPDATE, pues no hay nada que actualizar en la db
                echo "Error al actualizar estado: " . $e->getMessage();
            }
        }
    } catch (PDOException $e) {
        die ("Error PDO: " . $e->getMessage());
    }
?>