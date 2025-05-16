<?php
session_start();
require '../../includes/conexion.php';

if (!isset($_POST['habito_id'], $_POST['campo'], $_POST['valor'])) {
    die("Datos incompletos.");
}

$habito_id = $_POST['habito_id'];
$campo = $_POST['campo'];
$valor = $_POST['valor'];

// Lista blanca de campos editables
$campos_validos = ['nombre', 'descripcion', 'frecuencia', 'meta', 'fecha_creacion', 'estado'];

if (!in_array($campo, $campos_validos)) {
    die("Campo no válido.");
}

try {
    $sql = "UPDATE habito SET $campo = :valor WHERE id = :habito_id AND usuario_id = :usuario_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':valor' => $valor,
        ':habito_id' => $habito_id,
        ':usuario_id' => $_SESSION['usuario_id']
    ]);

    header('Location: ../habitoindex.php'); // redirige después de actualizar
    exit;
} catch (PDOException $e) {
    die("Error al actualizar: " . $e->getMessage());
}