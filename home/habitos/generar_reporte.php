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

        // 
        function getSemanaPasada() {
            // Día de hot
            $hoy = new DateTime();
            // Lunes de esta semana
            $hoy->modify('last monday');
            $fin = clone $hoy;
            // Lunes de la semana pasada
            $hoy->modify('-7 days');
            // Lunes - 1 día = DOMINGO
            $fin->modify('-1 day');
            return [$hoy->format('Y-m-d'), $fin->format('Y-m-d')];
        }

        // Desempaquetar array en dos variables
        list($inicio, $fin) = getSemanaPasada();

        // Ids de los usuarios
        $stmtUsuarios = $conn->query("SELECT id FROM usuario");
        $usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);

        // Para cada usuario se hace el registro de la su semana pasada
        foreach ($usuarios as $usuario) {
            $uid = $usuario['id'];

            // Guardar todos lod hábitos del usuario
            $stmtHabitos = $conn->prepare("SELECT id FROM habito WHERE usuario_id = ?");
            $stmtHabitos->execute([$uid]);
            $habito_ids = $stmtHabitos->fetchAll(PDO::FETCH_COLUMN);

            if (empty($habito_ids)) continue;

            // Generar lista según la cantidad de hábitos que tiene el usuario
            $placeholders = implode(',', array_fill(0, count($habito_ids), '?'));

            // Buscar si el hábito tuvo una entrada en historial_habito dentro de las fechas en las variables
            $stmtCheckeados = $conn->prepare("SELECT DISTINCT habito_id 
                                                FROM historial_habito 
                                                WHERE habito_id IN ($placeholders) 
                                                AND fecha BETWEEN ? AND ?");

            $stmtCheckeados->execute([...$habito_ids, $inicio, $fin]);
            $habitos_con_check = $stmtCheckeados->fetchAll(PDO::FETCH_COLUMN);

            // Contar cuantos registros tuvo el hábito en historial_habito
            $stmtTotal = $conn->prepare("SELECT COUNT(*) as total 
                                            FROM historial_habito 
                                            WHERE habito_id IN ($placeholders) 
                                            AND fecha BETWEEN ? AND ?");

            $stmtTotal->execute([...$habito_ids, $inicio, $fin]);
            $total_checkeos = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

            // Preparar INSERT
            // Inicio de semana, fin de semana, TOTAL de hábitos que tuvieron al menos UNA entrada por el usuario,
            // Total de completación de hábitos durante la semana por el usuario e ID del usuario.
            $stmtInsert = $conn->prepare("INSERT INTO reporte_semanal (semana_inicio, semana_fin, total_habitos, habitos_checkk, usuario_id)
                                            VALUES (?, ?, ?, ?, ?)
                                            ON DUPLICATE KEY UPDATE 
                                            total_habitos = VALUES(total_habitos),
                                            habitos_checkk = VALUES(habitos_checkk)");

            $stmtInsert->execute([$inicio, $fin, count($habitos_con_check), $total_checkeos, $uid]);
        }
        echo "Reporte generado correctamente para la semana $inicio a $fin.";
    } catch (PDOException $e) {
        die ("Error PDO: " . $e->getMessage());
    }
?>