<?php
    //Sesión ya iniciada en el página donde se incluye este archivo

    // Redirigir a index
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
        $hoy = date('Y-m-d');

        // Preparar consulta
        // *** Consulta -> Selección del nombre, descripción y frecuencias de los hábitos incompletos
        //                 que no han tenido un registro en la tabla historial_habito en la fecha guardada en la variable
        //                 (Completado -> TRUE: 1[El hábito tiene un registro hoy] FALSE:0 [El hábito ya tiene un registro hoy])
        //                 (LEFT JOIN -> Tomar en cuenta TODOS los hábitos, los que tuvieron y los que no tuvieron registro en historial)
        $sql = "SELECT ha.id, ha.nombre, ha.descripcion, ha.frecuencia,
                    CASE WHEN hh.id IS NOT NULL THEN 1 ELSE 0 END AS completado
                    FROM habito ha
                    LEFT JOIN historial_habito hh 
                    ON ha.id = hh.habito_id AND hh.fecha = :hoy
                    WHERE ha.usuario_id = :usuario_id
                    AND ha.estado = 'incompleto'";

        // Ejecutar
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':hoy', $hoy);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();

        // Envíar los habítos que cumplieron las condiciones
        $habitos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die ("Error PDO: " . $e->getMessage());
    }
?>