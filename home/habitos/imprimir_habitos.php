<?php
    require_once "../includes/conexion.php";

    $usuario_id = $_SESSION['usuario_id'];
    $hoy = date('Y-m-d');

    $sql = "SELECT ha.id, ha.nombre, ha.descripcion, ha.frecuencia,
                CASE WHEN hh.id IS NOT NULL THEN 1 ELSE 0 END AS completado
                FROM habito ha
                LEFT JOIN historial_habito hh 
                ON ha.id = hh.habito_id AND hh.fecha = :hoy
                WHERE ha.usuario_id = :usuario_id
                AND ha.estado = 'incompleto'";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':hoy', $hoy);
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->execute();

    $habitos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>