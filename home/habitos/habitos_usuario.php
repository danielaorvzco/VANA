<?php
    // La sesión ya esta iniciada pues el archivo es includido en la página HABITOINDEX.PHP

    // Redirigir a Index
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: ../index.html");
        exit();
    }

    // Control de errores
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    try{
        require_once("../includes/conexion.php");

        // Guardar ID del usuario
        $usuario_id = $_SESSION['usuario_id'];

        // Preparar consulta ** Selección de todos los hábitos de usuario
        $sql = "SELECT * FROM habito WHERE usuario_id = :usuario_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Envíar hábitos a página donde incluya este archivo
        $habitos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die ("Error PDO: " . $e->getMessage());
    }
?>