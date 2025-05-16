<?php
    if (!isset($_SESSION['usuario_id'])) {
        http_response_code(401);
        exit("No autorizado");
    }

    include '../includes/conexion.php';
    $usuario_id = $_SESSION['usuario_id'];

    $sql = "SELECT h.id, h.nombre, h.meta, COUNT(hh.id) AS total_registros
            FROM habito h
            LEFT JOIN historial_habito hh ON h.id = hh.habito_id
            WHERE h.usuario_id = :usuario_id AND h.estado = 'incompleto'
            GROUP BY h.id, h.nombre, h.meta";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->execute();
    $habitos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $contador = 0;
    echo '<div class="card-por">';
        foreach ($habitos as $habito) {
            $nombre = htmlspecialchars($habito['nombre']);
            $meta = (int)$habito['meta'];
            $total = (int)$habito['total_registros'];
            $porcentaje = $meta > 0 ? round(($total / $meta) * 100) : 0;
            $porcentaje = min($porcentaje, 100);
            $comparacion = "$total/$meta";

            if ($contador > 0 && $contador % 3 === 0) {
                echo '</div><div class="card-por">';
            }

            echo '
                <div class="card-individual">
                    <article class="porcentaje">' . $porcentaje . '%</article>
                    <img src="/vana/includes/assets/imgs/estrella.svg" alt="icono-estrella" class="icn-por">
                    <article class="text-card">' . $nombre . '</article>
                    <article class="sub-card">' . $comparacion . '</article>
                </div>';
    $contador++;
    }
    echo '</div>';
?>