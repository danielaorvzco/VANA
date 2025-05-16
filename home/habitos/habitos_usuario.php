<?php
    include '../includes/conexion.php';

    $usuario_id = $_SESSION['usuario_id'];
    $sql = "SELECT * FROM habito WHERE usuario_id = :usuario_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->execute();
    $habitos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>