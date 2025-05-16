<?php
    session_start();

    if (!isset($_SESSION['usuario_id'])) {
        echo "Sesión expirada.";
        exit();
    }
    
    require_once '../../includes/conexion.php'; 
    $usuario_id = $_SESSION['usuario_id'];

    $stmt = $conn->prepare("SELECT semana_inicio, semana_fin, total_habitos, habitos_checkk 
                            FROM reporte_semanal 
                            WHERE usuario_id = ?
                            ORDER BY semana_inicio DESC LIMIT 1");

    $stmt->execute([$usuario_id]);
    $reporte = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reporte) {
        echo "<p>No hay reportes semanales disponibles aún.</p>";
        exit();
    }

    $inicio = $reporte['semana_inicio'];
    $fin = $reporte['semana_fin'];

    $stmt = $conn->prepare("SELECT id, nombre FROM habito WHERE usuario_id = ?");
    $stmt->execute([$usuario_id]);
    $habitos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $habitos_con_registro = [];
    $habitos_sin_registro = [];

    foreach ($habitos as $habito) {
        $stmtCheck = $conn->prepare("SELECT 1 FROM historial_habito 
                                    WHERE habito_id = ? 
                                    AND fecha BETWEEN ? AND ? 
                                    LIMIT 1");

    $stmtCheck->execute([$habito['id'], $inicio, $fin]);

    if ($stmtCheck->fetch()) {
        $habitos_con_registro[] = $habito['nombre'];
    } else {
        $habitos_sin_registro[] = $habito['nombre'];
    }
}

    echo "
    <img src='../includes/assets/imgs/calendario.svg' class='icn-cale'>
    <article class='repo-sub'>Tu semana pasada</article>
    <article class='repo-fecha'>" . date('d/m/Y', strtotime($inicio)) . " - " . date('d/m/Y', strtotime($fin)) . "</article>
    <div class='cont-habitos'>
        <img src='../includes/assets/imgs/goal.svg' class='icn-goal'>
        <article class='repo-text'>Total de hábitos realizados: {$reporte['habitos_checkk']}</article>
    </div>
    <img src='../includes/assets/imgs/star-out.svg' class='icn-estrella'>
    <article class='repo-text'>Tus hábitos estrella</article>";

    foreach ($habitos_con_registro as $nombre) {
        echo "<article class='habi-reporte'>" . htmlspecialchars($nombre) . "</article>";
    }

    echo "
    <img src='../includes/assets/imgs/star-out.svg' class='icn-estrella'>
    <div class='repo-row'>
        <article class='repo-text'>Tus hábitos</article>
        <article class='repo-text italic'>no</article>
        <article class='repo-text'>tan estrellas</article>
    </div>";

    foreach ($habitos_sin_registro as $nombre) {
        echo "<article class='habi-reporte'>" . htmlspecialchars($nombre) . "</article>";
    }

    echo "<br><br>";
