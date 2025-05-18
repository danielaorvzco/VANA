<?php 
    // Iniciar sesión
    session_start();

    // Control de errores
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    try {
        require_once "conexion.php";

        // variables de contraseña enviadas por FORM
        $password =$_POST['password'];
        $confirm_password =$_POST['confirm_password'];

        // Si son distintas -> Mandar mensaje al usuario
        if ($password !== $confirm_password) {
            $origen = $_POST['origen'] ?? 'create.php';
            header("Location: $origen?error=2");
            exit;
        }

        // Verificar los campos obligatorios
        if (
            empty($_POST['nombre']) ||
            empty($_POST['apellido_paterno']) ||
            empty($_POST['correo']) ||
            empty($_POST['password'])
        ) {
            // Si los campos obligatorios llegan vacios -> Mandar mensaje al usuario
            $origen = $_POST['origen'] ?? 'create.php';
            header("Location: $origen?error=1");
            exit;
        }

        // Guardar los datos de FORM en varibles
        $nombre = $_POST['nombre'];
        $apellido_paterno = $_POST['apellido_paterno'];
        $apellido_materno = $_POST['apellido_materno'];
        $correo = $_POST['correo'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        // Todo registro nuevo sera 'USUARIO' por default
        $rol_id = 2;
        // Todo registro nuevo sera 'Activo' por default
        $estatus_id = 1;

        // Seleccionar todo los correos existentes en la db
        $verificar = $conn->prepare("SELECT id FROM usuario WHERE correo = :correo");
        $verificar->execute([':correo' => $correo]);

        // Si el rowCout es mayor a 0 -> El correo ya esta en uso - se manda mensaje al usuario
        if ($verificar->rowCount() > 0) {
            $origen = $_POST['origen'] ?? 'create.php';
            header("Location: $origen?error=3");
            exit;
        }

        // Preparar INSERT
        $sql = "INSERT INTO usuario (nombre, apellido_paterno, apellido_materno, correo, password, rol_id, estatus_id)
                VALUES (:nombre, :apellido_paterno, :apellido_materno, :correo, :password, :rol_id, :estatus_id)";

        // Ejecutar INSERT
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

        // Preparar datos de sesión del nuevo Usuario
        if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == 2 && $_SESSION['rol_id'] == 1) {
            header ("Location: ../home/index.php");
        } else {
            $usuario_id = $conn->lastInsertId();
            $_SESSION['usuario_id'] = $usuario_id;
            $_SESSION['nombre'] = $nombre;
            $_SESSION['nombre_completo'] = $nombre . " " . $apellido_paterno;
            $_SESSION['rol_id'] = $rol_id;
            
            header ("Location: ../home/home.php");
        }

    } catch (PDOException $e) {
        die("Error PDO: " . $e->getMessage());
    }
?>