<?php 
    // Credenciales para hacer conexión con la base de datos VANA
    $host = 'localhost';
    $dbname = 'vana';
    $usuario = 'root';
    $clave = ''; // contraseña db
    
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $clave);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
?>