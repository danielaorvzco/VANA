<?php 
    session_start();
    
    // Redirigir a Index
    if(!isset($_SESSION['usuario_id'])){
        header ("Location: ../index.html");
        exit();
    }

    include '../includes/header.php';
    include '../includes/conexion.php';
    include 'habitos/imprimir_habitos.php';
?>
    <main>
        <div class="fondo-estacion">
            <div class="line1">
                <article class="bienvenido">Es bueno tenerte de nuevo, <?=$_SESSION['nombre'];?>!</article>
                <a href="habitoindex.php"><button class="btn-habitos">+</button></a>
            </div>
            <div class="box-estacion">
                <div class="personajes">
                    <img src="../includes/assets/imgs/personaje1.png" alt="personaje-vana1" class="personaje1">
                    <img src="../includes/assets/imgs/personaje3.png" alt="personaje-vana2" class="personaje2">
                </div>
                <div class="estacion-click">
                    <article class="estacion">Estación click click</article>
                    <div class="meta-menu">
                        <div>
                            <article class="metas">Metas diarias</article>
                            <form action="habitos/completar_habito.php" method="POST" class="habitos-form">
                                <div class='lista-habitos'>
                                    <?php
                                    // Imprimir los hábitos INCOMPLETOS con frecuencia DIARIA
                                        foreach ($habitos as $habito) {
                                            if ($habito['frecuencia'] == 'diario') {
                                                $isCompletado = $habito['completado'] ? true : false;
                                                $checked = $isCompletado ? 'checked disabled' : '';
                                                $completadoClass = $isCompletado ? 'habito-completado' : '';

                                                echo "
                                                    <div class='habito-item habito-custom $completadoClass' id='habito-" . $habito['id'] . "'>
                                                        <input type='checkbox' class='check-habito' id='check-" . $habito['id'] . "' data-id='" . $habito['id'] . "' $checked/>
                                                        <label for='check-" . $habito['id'] . "'>
                                                            " . $habito['nombre'] . ": " . $habito['descripcion'] . "
                                                        </label>
                                                    </div>";
                                            }
                                        }
                                    ?>
                                </div>
                            </form>
                        </div>
                        <div>
                            <article class="metas">Metas semanales</article>
                            <form action="habitos/completar_habito.php" method="POST" class="habitos-form">
                                <div class='lista-habitos'>
                                    <?php
                                    // Imprimir los hábitos INCOMPLETOS con frecuencia SEMANAL
                                        foreach ($habitos as $habito) {
                                            if ($habito['frecuencia'] == 'semanal') {
                                                $isCompletado = $habito['completado'] ? true : false;
                                                $checked = $isCompletado ? 'checked disabled' : '';
                                                $completadoClass = $isCompletado ? 'habito-completado' : '';

                                                echo "
                                                    <div class='habito-item habito-custom $completadoClass' id='habito-" . $habito['id'] . "'>
                                                        <input type='checkbox' class='check-habito' id='check-" . $habito['id'] . "' data-id='" . $habito['id'] . "' $checked />
                                                        <label for='check-" . $habito['id'] . "'>
                                                            " . $habito['nombre'] . ": " . $habito['descripcion'] . "
                                                        </label>
                                                    </div>";
                                            }
                                        }
                                    ?>
                                </div>
                            </form>
                        </div>
                        <div>
                            <article class="metas">Tus otras metas</article>
                            <form action="habitos/completar_habito.php" method="POST" class="habitos-form">
                                <div class='lista-habitos'>
                                    <?php
                                    // Imprimir los hábitos INCOMPLETOS con frecuencia MENSUAL, BIMESTRAL O TRIMESTRUAL
                                        foreach ($habitos as $habito) {
                                            if (in_array($habito['frecuencia'], ['mensual', 'bimestral', 'trimestrual'])) {
                                                    $isCompletado = $habito['completado'] ? true : false;
                                                    $checked = $isCompletado ? 'checked disabled' : '';
                                                    $completadoClass = $isCompletado ? 'habito-completado' : '';

                                                    echo "
                                                        <div class='habito-item habito-custom $completadoClass' id='habito-" . $habito['id'] . "'>
                                                            <input type='checkbox' class='check-habito' id='check-" . $habito['id'] . "' data-id='" . $habito['id'] . "' $checked/>
                                                            <label for='check-" . $habito['id'] . "'>
                                                                " . $habito['nombre'] . ": " . $habito['descripcion'] . "
                                                            </label>
                                                        </div>";
                                            }
                                        }
                                    ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>  
            </div>
            <br> <br>
            <article class="msg-moti">todo esfuerzo es reconocido por nosotros</article>
            <br><br><br><br><br>
        </div>
        <br>
    </main>
    
    <script>
        // Cambiar el aspecto del hábito y checkbox si checkbox es seleccionado
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.check-habito').forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    if (this.checked) {
                        const id = this.getAttribute('data-id');
                        // Archivo para hacer registro de la completación del hábito
                        fetch('habitos/completar_habito.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `id=${id}`
                        })
                        .then(res => res.text())
                        .then(data => {
                            const habitoItem = document.getElementById(`habito-${id}`);
                            habitoItem.classList.add('habito-completado');
                            this.disabled = true; 
                        })
                        .catch(err => console.error('Error al marcar hábito como completado:', err));
                    }
                });
            });
        });
    </script>

<?php include '../includes/footer.php'; ?>  