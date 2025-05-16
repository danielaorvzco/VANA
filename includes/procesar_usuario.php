<?php 
    session_start();

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    try {
        require_once "conexion.php";

        $password =$_POST['password'];
        $confirm_password =$_POST['confirm_password'];

        if ($password !== $confirm_password) {
            echo ("Error: Las contraseñas no coinciden");
            exit;
        }

        if (
            empty($_POST['nombre']) ||
            empty($_POST['apellido_paterno']) ||
            empty($_POST['correo']) ||
            empty($_POST['password'])
        ) {
            echo "Todos los campos obligatorios deben llenarse. <a href='registrar_usuario.html'>Volver</a>";
            exit;
        }

        $nombre = $_POST['nombre'];
        $apellido_paterno = $_POST['apellido_paterno'];
        $apellido_materno = $_POST['apellido_materno'];
        $correo = $_POST['correo'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        $rol_id = 2;
        $estatus_id = 1;

        $verificar = $conn->prepare("SELECT id FROM usuario WHERE correo = :correo");
        $verificar->execute([':correo' => $correo]);

        if ($verificar->rowCount() > 0) {
            echo "El correo ya está registrado. <a href='../create.php'>Intentar con otro</a>";
            exit;
        }

        $sql = "INSERT INTO usuario (nombre, apellido_paterno, apellido_materno, correo, password, rol_id, estatus_id)
                VALUES (:nombre, :apellido_paterno, :apellido_materno, :correo, :password, :rol_id, :estatus_id)";

        $stmt = $conn->prepare($sql);
        $stmt = $stmt->execute([
            ':nombre' => $nombre,
            ':apellido_paterno' => $apellido_paterno,
            ':apellido_materno' => $apellido_materno,
            ':correo' => $correo,
            ':password' => $password,
            ':rol_id' => $rol_id,
            ':estatus_id' => $estatus_id
        ]);

        $usuario_id = $conn->lastInsertId();
        $_SESSION['usuario_id'] = $usuario_id;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['nombre_completo'] = $nombre . " " . $apellido_paterno;
        $_SESSION['rol_id'] = $rol_id;

        header("Location: ../home/home.php");
        exit;

    } catch (PDOException $e) {
        die("Error PDO: " . $e->getMessage());
    }
?>