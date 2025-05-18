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
        require_once ('../../includes/conexion.php');

        // Verificar que los campos necesitados noo esten vacios
        if (!isset($_POST['habito_id'], $_POST['campo'], $_POST['valor'])) {
            die("Datos incompletos.");
        }

        // Guardar datos en variables
        $habito_id = $_POST['habito_id'];
        $campo = $_POST['campo'];
        $valor = $_POST['valor'];


        // Indicar los 'campo (opciones del SELECT)' aceptables
        $campos_validos = ['nombre', 'descripcion', 'frecuencia', 'meta', 'fecha_creacion', 'estado'];

        // Si el campo que llego desde el SELECT no coincide con alguno de los campos aceptables, no se hace el UPDATE
        if (!in_array($campo, $campos_validos)) {
            die("Campo no válido.");
        }

        try {
            // Preparar y ejecutar UPDATE
            $sql = "UPDATE habito SET $campo = :valor WHERE id = :habito_id AND usuario_id = :usuario_id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':valor' => $valor,
                ':habito_id' => $habito_id,
                ':usuario_id' => $_SESSION['usuario_id']
        ]);

        header('Location: ../habitoindex.php');
        exit;
        } catch (PDOException $e) {
            die("Error al actualizar: " . $e->getMessage());
        }
    } catch (PDOException $e) {
        die ("Error PDO: " . $e->getMessage());
    }
?>