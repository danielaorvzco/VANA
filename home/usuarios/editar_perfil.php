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

        // Verificar que los datos no esten incompletos
        if (!isset($_POST['usuario_id'], $_POST['campo'], $_POST['valor'])) {
            header("Location: ../index.php?error=2");
            exit;
        }

        // Guardar valores en variables
        $usuario_id = $_POST['usuario_id'];
        $campo = $_POST['campo'];
        $valor = $_POST['valor'];

        // Verificar que los campos no llaron vacios
        if (empty($campo) || $valor === '') {
            header("Location: ../perfilindex.php?id=$usuario_id&error=2");
            exit;
        }

        // Indicar los 'campo (opciones del SELECT)' aceptables
        $campos_validos = ['nombre', 'apellido_paterno', 'apellido_materno', 'correo', 'password'];

        // Si el campo que llego desde el SELECT no coincide con alguno de los campos aceptables, no se hace el UPDATE
        if (!in_array($campo, $campos_validos)) {
            die("Campo no válido.");
        }

        // Si el campo recibio fue 'correo' se debe verificar que este no este en la db
        if ($campo == 'correo') {
            $check = $conn->prepare("SELECT id FROM usuario WHERE correo = :correo AND id != :id");
            $check->execute([':correo' => $valor, ':id' => $usuario_id]);

            // Si se encuntra un registro -> el correo ya esta en uso
            if ($check->rowCount() > 0) {
                header("Location: ../perfilindex.php?id=$usuario_id&error=1");
                exit;
            }
        }

        // HASH de la nueva contraseña si ese es el campo que se envío
        if ($campo == 'password') {
            $valor = password_hash($valor, PASSWORD_DEFAULT);
        }

        // Preparar y ejecutar UPDATE
        $sql = "UPDATE usuario SET $campo = :valor WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':valor' => $valor,
            ':id' => $usuario_id
        ]);

        // Preparar los nuevo datos de sesión
        if (in_array($campo, ['nombre', 'apellido_paterno'])) {
            $query = $conn->prepare("SELECT nombre, apellido_paterno, apellido_materno FROM usuario WHERE id = :id");
            $query->execute([':id' => $usuario_id]);
            $datos = $query->fetch(PDO::FETCH_ASSOC);

            if ($datos) {
            $_SESSION['nombre_completo'] = $datos['nombre'] . ' ' . $datos['apellido_paterno'];
            }
        }

        header("Location: ../perfilindex.php");
        exit;
    } catch (PDOException $e) {
        die ("Error PDO: " . $e->getMessage());
    }
?>