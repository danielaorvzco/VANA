<?php
    // Sesión iniciada en archivo donde se incluye este archivo

    // Redirigir a Index
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: ../index.html");
        exit();
    }

    // Control de errores
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    try {
        require_once("../includes/conexion.php");
        $usuario_id = $_SESSION['usuario_id'];

        // Preparar consulta
        // ** Consulta -> Selección de nombre, meta y conteo de las veces que el ID del hábito aparece en historial_habito
        //                  de todos los hábitos que sigan incompletos, pues su progreso (meta) sigue en curso.
        //                  (LEFT JOIN -> asegurar que se tomen en cuenta los hábitos que no tienen entrada en historial_habito)
        $sql = "SELECT h.id, h.nombre, h.meta, COUNT(hh.id) AS total_registros
                FROM habito h
                LEFT JOIN historial_habito hh ON h.id = hh.habito_id
                WHERE h.usuario_id = :usuario_id AND h.estado = 'incompleto'
                GROUP BY h.id, h.nombre, h.meta";

        // Ejecutar consulta
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        $habitos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $contador = 0;

        // IPreparar impresión del progreso
        echo '<div class="card-por">';
            // Hacer cálculo para cada hábito
            foreach ($habitos as $habito) {
                $nombre = htmlspecialchars($habito['nombre']);
                $meta = (int)$habito['meta'];
                $total = (int)$habito['total_registros'];

                // Calcular % de progreso dividiendo el total de registro del hábito entre la meta establecida por el usuario
                $porcentaje = $meta > 0 ? round(($total / $meta) * 100) : 0;

                // Si el usuario supera la meta por arriba de su establecido, no se mostrara porcentaje arriba del 100%
                $porcentaje = min($porcentaje, 100);

                // Guardar comparación
                $comparacion = "$total/$meta";

                // Imprimir solo tres cards (bloques de código de la clase 'card-por') al mismo nivel
                if ($contador > 0 && $contador % 3 === 0) {
                    echo '</div><div class="card-por">';
                }

                // Impresión del progreso
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
    }
    catch (PDOException $e) {
        die ("Error PDO: " . $e->getMessage());
    }
?>