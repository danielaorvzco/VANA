<?php
    session_start();
    
    if (!isset($_SESSION['usuario_id'])) {
        http_response_code(401);
        exit("No autorizado");
    }

    require '../../includes/conexion.php'; 

    $filtro = $_GET['filtro'] ?? 'dia';
    $usuario_id = $_SESSION['usuario_id'];

    $hoy = date('Y-m-d');
    $inicio = $fin = $hoy;

    switch ($filtro) {
        case 'semana':
            $inicio = date('Y-m-d', strtotime('monday this week'));
            $fin = date('Y-m-d', strtotime('sunday this week'));
        break;
        case 'mes':
            $inicio = date('Y-m-01');
            $fin = date('Y-m-t');
        break;
        default: 
            $inicio = $fin = $hoy;
        break;
    }

    $sql = "SELECT h.nombre, h.descripcion, h.frecuencia, h.estado, hh.fecha
            FROM habito h
            JOIN historial_habito hh ON h.id = hh.habito_id
            WHERE h.usuario_id = :usuario_id AND hh.fecha BETWEEN :inicio AND :fin
            ORDER BY hh.fecha ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->bindParam(':inicio', $inicio);
    $stmt->bindParam(':fin', $fin);
    $stmt->execute();

    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($registros)) {
        echo "<p>No hay hábitos registrados para este periodo.</p>";
        exit;
    }

    foreach ($registros as $row): ?>
        <div class="list-hobbiess">
            <img src="/vana/includes/assets/imgs/historial.svg" alt="icono-historial" class="icn-hobbie">
            <article class="hobbie"><?= htmlspecialchars($row['nombre']) ?> -</article>
            <article class="descripcion"><?= htmlspecialchars($row['descripcion']) ?> -</article>
            <article class="otro-hobbie"><?= htmlspecialchars($row['frecuencia']) ?> -</article>
            <article class="otro-hobbie"><?= htmlspecialchars($row['estado']) ?> -</article>
            <article class="otro-hobbie"><?= htmlspecialchars($row['fecha']) ?></article>
        </div>
<?php endforeach; ?>