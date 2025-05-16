<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../includes/assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quattrocento:wght@400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comme:wght<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="encabezado">
            <a href="../home/home.php"><img src="../includes/assets/imgs/logo.png" alt="logo-vana" class="logo-header"></a>
            <a href="../home/home.php"><article class="nombre">nava</article></a>
            <div class="header-opciones">
                <a href="../home/habitoindex.php"><article class="opciones">Mis hábitos</article></a>
                <a href="../home/progreindex.php"><article class="opciones">Mi progreso</article></a>
            </div>
            <div class="header-usuario">
                <article class="usuario-nombre"><?=$_SESSION['nombre_completo'];?></article>
                <div class="linea-vertical"></div>
                <a href=""><img src="../includes/assets/imgs/profile.svg" alt="icono-perfil" class="perfil"></a>
            </div>
        </div>
    </header>
