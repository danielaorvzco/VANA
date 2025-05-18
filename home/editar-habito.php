<?php 
    session_start();
    
    // Redirigir al Index
    if(!isset($_SESSION['usuario_id'])){
        header ("Location: ../index.html");
        exit();
    }

    include '../includes/header.php';

    // Verficar que se recibe el ID del hábito a editar
    $id = $_GET['id'] ?? null;
    if (!$id) {
        echo "<p>Error: ID de hábito no proporcionado.</p>";
    exit;
    }
?>
    <main>
    <div class="fondo-estacion">
        <div class="line1">
            <article class="bienvenido">No te preocupes!</article>
        </div>
        <article class="msg-siempre">Siempre es bueno reevaluar nuestras decisiones</article>
        <div class="Form-cuerpo">
            <img src="../includes/assets/imgs/personaje5.png" alt="personaje5-vana" class="personajeidk">
            <div class="Formulario-editar">
                <form action="habitos/editar_habito.php" method="POST">
                    <input type="hidden" name="habito_id" value="<?= htmlspecialchars($id) ?>">
                    <article class="select-text">Editemos este hábito</article>
                    <div class="select-edit">
                        <!-- Seleccionar el campo a editar -> se habilita el input -->
                        <article class="select-text">Selecciona el campo que quieres editar</article>
                        <select name="campo" id="campo" onchange="habilitarCampo()">
                            <option value="">--Selecciona--</option>
                            <option value="nombre">Nombre</option>
                            <option value="descripcion">Descripción</option>
                            <option value="frecuencia">Frecuencia</option>
                            <option value="meta">Meta</option>
                            <option value="fecha_creacion">Fecha de creación</option>
                            <option value="estado">Estado de completación</option>
                        </select>
                    </div>

                    <div class="Form-editar">
                        <div class="grupo1-campo">
                            <div class="campo-edit">
                                <article class="label-form">Nombre</article>
                                <input type="text" name="valor" id="input-nombre" disabled>
                            </div>
                            <div class="campo-edit">
                                <article class="label-form">Descripción</article>
                                <input type="text" name="valor" id="input-descripcion" disabled>
                            </div>
                            <div class="campo-edit">
                                <article class="label-form">Frecuencia</article>
                                <select name="valor" id="input-frecuencia" disabled>
                                    <option value="diario">Diario</option>
                                    <option value="semanal">Semanal</option>
                                    <option value="mensual">Mensual</option>
                                    <option value="bimestral">Bimestral</option>
                                    <option value="trimestrual">Trimestral</option>
                                </select>
                            </div>
                        </div>
                        <div class="grupo2-campo">
                            <div class="campo-edit">
                                <article class="label-form">Meta</article>
                                <input type="number" name="valor" id="input-meta" disabled>
                            </div>
                            <div class="campo-edit">
                                <article class="label-form">Fecha de creación</article>
                                <input type="date" name="valor" id="input-fecha_creacion" disabled>
                            </div>
                            <div class="campo-edit">
                                <article class="label-form">Estado</article>
                                <select name="valor" id="input-estado" disabled>
                                    <option value="incompleto">Incompleto</option>
                                    <option value="completo">Completo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <!-- Mandar nuevo valor al archivo UPDATE -->
                    <button type="submit" class="btn-habitos-rg">Actualizar</button>
                </form>
            </div>
        </div>
        <br><br><br>
    </div>
    <br>
</main>

    <script>
        // Función para habilitar input valor mandado por el SELECT
        function habilitarCampo() {
            const campos = ["nombre", "descripcion", "frecuencia", "meta", "fecha_creacion", "estado"];
            const seleccionado = document.getElementById("campo").value;

            campos.forEach(campo => {
                const input = document.getElementById("input-" + campo);
                if (input) {
                    input.disabled = (campo !== seleccionado);
                    input.style.backgroundColor = campo === seleccionado ? "#fff" : "#e0e0e0";
                }
            });
        }
    </script>

<?php include '../includes/footer.php'; ?>