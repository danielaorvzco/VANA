<?php
    require_once '../includes/conexion.php';

    function getSemanaPasada() {
        $hoy = new DateTime();
        $hoy->modify('last monday');
        $fin = clone $hoy;
        $hoy->modify('-7 days');
        $fin->modify('-1 day');
        return [$hoy->format('Y-m-d'), $fin->format('Y-m-d')];
    }

    list($inicio, $fin) = getSemanaPasada();

    $stmtUsuarios = $conn->query("SELECT id FROM usuario");
    $usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);

    foreach ($usuarios as $usuario) {
        $uid = $usuario['id'];

        $stmtHabitos = $conn->prepare("SELECT id FROM habito WHERE usuario_id = ?");
        $stmtHabitos->execute([$uid]);
        $habito_ids = $stmtHabitos->fetchAll(PDO::FETCH_COLUMN);

        if (empty($habito_ids)) continue;

        $placeholders = implode(',', array_fill(0, count($habito_ids), '?'));

        $stmtCheckeados = $conn->prepare("SELECT DISTINCT habito_id 
                                            FROM historial_habito 
                                            WHERE habito_id IN ($placeholders) 
                                            AND fecha BETWEEN ? AND ?");

        $stmtCheckeados->execute([...$habito_ids, $inicio, $fin]);
        $habitos_con_check = $stmtCheckeados->fetchAll(PDO::FETCH_COLUMN);

        $stmtTotal = $conn->prepare("SELECT COUNT(*) as total 
                                        FROM historial_habito 
                                        WHERE habito_id IN ($placeholders) 
                                        AND fecha BETWEEN ? AND ?");

        $stmtTotal->execute([...$habito_ids, $inicio, $fin]);
        $total_checkeos = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

        $stmtInsert = $conn->prepare("INSERT INTO reporte_semanal (semana_inicio, semana_fin, total_habitos, habitos_checkk, usuario_id)
                                        VALUES (?, ?, ?, ?, ?)
                                        ON DUPLICATE KEY UPDATE 
                                        total_habitos = VALUES(total_habitos),
                                        habitos_checkk = VALUES(habitos_checkk)");

        $stmtInsert->execute([$inicio, $fin, count($habitos_con_check), $total_checkeos, $uid]);
}

echo "Reporte generado correctamente para la semana $inicio a $fin.";