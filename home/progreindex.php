<?php 
    // Iniciar sesión
    session_start();

    // Redirigir a Index
    if(!isset($_SESSION['usuario_id'])){
        header ("Location: ../index.html");
        exit();
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
                <!-- Impresión del historial -->
            </div>
            <br><br>
            </div>
        </div>
        <div class="pro-linea1">
            <article class="bienvenidoo">Pero quieres ver algo más divertido...?</article>
            <img src="../includes/assets/imgs/personaje6.png" alt="incono-personaje6" class="icn-per6">
        </div>
        <div class="card-por">
            <!-- Archivo donde se hace cálculo e  impresión del progreso visual -->
            <?php include 'habitos/progreso_habito.php'; ?>
        </div>
        <div class="box-train">
            <img src="../includes/assets/imgs/train.svg" alt="icono-tren" class="icn-tren">
        </div>
        <article class="repo-titulo">Oh, llegando hacia ti, es el reporte semanal</article>
        <div class="box-reporte" id="contenedor-reporte">
            <!-- Impresión del reporte semanal -->
        </div>
    </main>

    <script>
        // Sub-titulo de cada vista según su DATA-FILTRO
    document.querySelectorAll('.btn-pro').forEach(btn => {
        btn.addEventListener('click', () => {
            const filtro = btn.getAttribute('data-filtro');
            document.getElementById('titulo-historial').textContent = 
                filtro === 'dia' ? 'Día de hoy' :
                filtro === 'semana' ? 'Esta semana' :
                'Este mes';

            // Archivo donde se imprime el historial de hábitos realizados por día, semana o mes
            fetch(`habitos/get_historial.php?filtro=${filtro}`)
                .then(res => res.text())
                .then(html => {
                    // Impresión dentro del elemento con ID 'contenedor-historial'
                    document.getElementById('contenedor-historial').innerHTML = html;
                });
        });
    });

    // Establecer el historial del día como DEFAULT cada que el usuario entre a esta página
    window.addEventListener('DOMContentLoaded', () => {
        const titulo = document.getElementById('titulo-historial');
        if (titulo) {
            titulo.textContent = 'Día de hoy';
        }

        // Obtener e historial del día por default
        fetch('habitos/get_historial.php?filtro=dia')
            .then(res => res.text())
            .then(html => {
                document.getElementById('contenedor-historial').innerHTML = html;
            });
        
        // Llamar al archivo que genera el reporte semanal para hacer su impreión en el div 'contenedor-reporte'
        fetch('habitos/reporte_habito.php') 
            .then(res => res.text())
            .then(html => {
                document.getElementById('contenedor-reporte').innerHTML = html;
            });
    });
</script>

<?php include '../includes/footer.php'; ?>