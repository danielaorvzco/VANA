<?php 
    // Iniciar, borrar y eliminar sesión
    session_start();
    session_unset();
    session_destroy();
    header("Location: ./");
    exit();
?>