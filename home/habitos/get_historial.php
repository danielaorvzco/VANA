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

        // Recibir filtro ('día', 'semana', 'mes') mandado por el BTN
        $filtro = $_GET['filtro'] ?? 'dia';
        $usuario_id = $_SESSION['usuario_id'];

        // Guardar la fecha del día
        $hoy = date('Y-m-d');

        // Guardar la fecha como parametro de inicio y fin PARA HISTORIAL DE HOY
        $inicio = $fin = $hoy;

        // Guardar parametros para inicio y fin de semana o mes
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

        // Preparara consulta
        // *** Consulta -> Seleccionar nombre, descripción, frecuencia, estado y fecha
        //                  de los hábitos que tengan registro en historia_habito dentro
        //                  de las fechas guardadas en las variables e fecha.
        $sql = "SELECT h.nombre, h.descripcion, h.frecuencia, h.estado, hh.fecha
                FROM habito h
                JOIN historial_habito hh ON h.id = hh.habito_id
                WHERE h.usuario_id = :usuario_id AND hh.fecha BETWEEN :inicio AND :fin
                ORDER BY hh.fecha ASC";

        // Ejecutar consulta
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':inicio', $inicio);
        $stmt->bindParam(':fin', $fin);
        $stmt->execute();

        // Guardar todos los registros que cumplen con las condiciones
        $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Si no se encontraron registros que cumplen con las condiciones -> Imprimir en contenedor
        if (empty($registros)) {
            echo "<article class='hobbie'>No hay hábitos registrados para este periodo.</article>";
            exit;
        }

        // Impresión de los registros guardados en la varible
        foreach ($registros as $row) {
            ?>
            <div class="list-hobbiess">
                <img src="/vana/includes/assets/imgs/historial.svg" alt="icono-historial" class="icn-hobbie">
                <article class="hobbie"><?= htmlspecialchars($row['nombre']) ?> -</article>
                <article class="descripcion"><?= htmlspecialchars($row['descripcion']) ?> -</article>
                <article class="otro-hobbie"><?= htmlspecialchars($row['frecuencia']) ?> -</article>
                <article class="otro-hobbie"><?= htmlspecialchars($row['estado']) ?> -</article>
                <article class="otro-hobbie"><?= htmlspecialchars($row['fecha']) ?></article>
            </div>
            <?php
        }
    } catch (PDOException $e) {
        die ("Error PDO: " . $e->getMessage()); 
    }
?>

