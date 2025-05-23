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

    // Variables 
    $mensaje = "";
    $roles = [];
    $estatuses = [];

    try {
        require_once("../../includes/conexion.php");

        // Verificar que los datos no esten incompletos
        if (!isset($_POST['campo'], $_POST['valor'])) {
            header("Location: ../index.php?id=$usuario_id&error=2");
            exit;
        }

        // Consultar el rol y estatus del usuario
        $roles = $conn->query("SELECT id, nombre FROM rol")->fetchAll(PDO::FETCH_ASSOC);
        $estatuses = $conn->query("SELECT id, descripcion FROM estatus")->fetchAll(PDO::FETCH_ASSOC);

        // Guardar valores en variables 
        $usuario_id = $_POST['usuario_id'];
        $campo = $_POST['campo'];
        $valor = $_POST['valor'];

        // Verificar que los campos no llaron vacios
        if (empty($campo) || $valor === '') {
            header("Location: ../editar-usuario.php?id=$usuario_id&error=2");
            exit;
        }

        // Indicar los 'campo (opciones del SELECT)' aceptables
        $campos_validos = ['nombre', 'apellido_paterno', 'apellido_materno', 'correo', 'fecha_registro', 'rol_id', 'estatus_id'];

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
                header("Location: ../editar-usuario.php?id=$usuario_id&error=1");
                exit;
            }
        } 

        // Preparar y ejecutar UPDATE
        $sql = "UPDATE usuario SET $campo = :valor WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':valor' => $valor,
            ':id' => $usuario_id
        ]);

        header("Location: ../index.php");
        exit;
    } catch (PDOException $e) {
        die ("Error PDO: " . $e->getMessage());
    }

?>