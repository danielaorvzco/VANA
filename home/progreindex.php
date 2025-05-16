<?php 
    session_start();
    
    if(!isset($_SESSION['usuario_id'])){
        header ("Location: ../index.html");
        exit();
    }

    $rol = $_SESSION['rol_id'];
    if($rol == 1){
        $rol = "Administrador";
    } else if ($rol == 2){
        $rol = "Estudiante";
    } else if ($rol == 3){
        $rol = "Profesor";
    } else {
        $rol = "Invitado";
    }

    include '../includes/header.php';
?>

    <main>
        <div class="fondo-estacion">
            <br><br>
            <div class="barra-select">
                <button class="btn-pro" data-filtro="dia">Día</button>
                <button class="btn-pro" data-filtro="semana">Semana</button>
                <button class="btn-pro" data-filtro="mes">Mes</button>
            </div>
            <article class="his-title1">Veamos el historial de tu actividad</article>
            <article class="his-title2" id="titulo-historial">Día de hoy</article>
            <div class="historial" id="contenedor-historial">
            </div>
            <br><br>
            </div>
        </div>
        <div class="pro-linea1">
            <article class="bienvenidoo">Pero quieres ver algo más divertido...?</article>
            <img src="../includes/assets/imgs/personaje6" alt="incono-personaje6" class="icn-per6">
        </div>
        <div class="card-por">
            <?php include 'habitos/progreso_habito.php'; ?>
        </div>
        <div class="box-train">
            <img src="../includes/assets/imgs/train.svg" alt="icono-tren" class="icn-tren">
        </div>
        <article class="repo-titulo">Oh, llegando hacia ti, es el reporte semanal</article>
        <div class="box-reporte" id="contenedor-reporte">
        </div>
    </main>

    <script>
    document.querySelectorAll('.btn-pro').forEach(btn => {
        btn.addEventListener('click', () => {
            const filtro = btn.getAttribute('data-filtro');
            document.getElementById('titulo-historial').textContent = 
                filtro === 'dia' ? 'Día de hoy' :
                filtro === 'semana' ? 'Esta semana' :
                'Este mes';

            fetch(`habitos/get_historial.php?filtro=${filtro}`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('contenedor-historial').innerHTML = html;
                });
        });
    });

    window.addEventListener('DOMContentLoaded', () => {
        const titulo = document.getElementById('titulo-historial');
        if (titulo) {
            titulo.textContent = 'Día de hoy';
        }

        fetch('habitos/get_historial.php?filtro=dia')
            .then(res => res.text())
            .then(html => {
                document.getElementById('contenedor-historial').innerHTML = html;
            });

        fetch('habitos/reporte_habito.php') 
            .then(res => res.text())
            .then(html => {
                document.getElementById('contenedor-reporte').innerHTML = html;
            });
    });
</script>

<?php include '../includes/footer.php'; ?>