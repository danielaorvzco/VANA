<?php 
    session_start();
    require_once "conexion.php";

    // Desde el formulario
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Conexión a la base de datos
    $sql = "SELECT * FROM usuario WHERE correo = :correo";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['correo' => $usuario]);
    
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['password'])){
        echo "Bienvenido, " . $usuario['nombre'];
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['nombre_completo'] = $usuario['nombre'] . " " . $usuario['apellido_paterno'];
        $_SESSION['rol_id'] = $usuario['rol_id'];

        header("Location: ../home/home.php");
    } else {
        echo "Usuario o contraseña incorrecta";
    }
?>