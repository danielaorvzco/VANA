<?php 
    session_start();
    
    // Redirigir a Index
    if(!isset($_SESSION['usuario_id'])){
        header ("Location: ../index.html");
        exit();
    }

    include '../includes/header.php';

    // Verficar que se recibe el ID del usuario a editar
    $id = $_GET['id'] ?? null;
    if (!$id) {
        echo "<p>Error: ID de hábito no proporcionado.</p>";
    exit;
    }
?>
    <main>
    <div class="fondo-estacion">
        <div class="line1">
            <article class="bienvenido">Bienvenido, <?= $rol?>!</article>
        </div>
        <article class="msg-siempre">Bienvenido al taller de edición</article>
        <div class="Form-cuerpo">
            <img src="../includes/assets/imgs/personaje5.png" alt="personaje5-vana">
            <div class="Formulario-editar">
                <form action="usuarios/editar_usuario.php" method="POST">
                    <input type="hidden" name="usuario_id" value="<?= htmlspecialchars($id) ?>">
                    <article class="select-text">Editemos este usuario</article>
                    <div class="select-edit">
                        <!-- Seleccionar el campo a editar -> se habilita el input -->
                        <article class="select-text">Selecciona el campo que quieres editar</article>
                        <select name="campo" id="campo" onchange="habilitarCampo()">
                            <option value="">--Selecciona--</option>
                            <option value="nombre">Nombre</option>
                            <option value="apellido_paterno">Apellido paterno</option>
                            <option value="apellido_materno">Apellido materno</option>
                            <option value="correo">Correo</option>
                            <option value="fecha_registro">Fecha de registro</option>
                            <option value="rol_id">Rol</option>
                            <option value="estatus_id">Estatus</option>
                        </select>
                    </div>

                    <div class="Form-editar">
                        <div class="grupo1-campo">
                            <div class="campo-edit">
                                <article class="label-form">Nombre</article>
                                <input type="text" name="valor" id="input-nombre" disabled>
                            </div>
                            <div class="campo-edit">
                                <article class="label-form">Apellido paterno</article>
                                <input type="text" name="valor" id="input-apellido_paterno" disabled>
                            </div>
                            <div class="campo-edit">
                                <article class="label-form">Apellido materno</article>
                                <input type="text" name="valor" id="input-apellido_materno" disabled>
                            </div>
                            <div class="campo-edit">
                                <article class="label-form">Correo</article>
                                <input type="text" name="valor" id="input-correo" disabled>
                            </div>
                        </div>
                        <div class="grupo2-campo">
                            <div class="campo-edit">
                                <article class="label-form">Fecha de registro</article>
                                <input type="date" name="valor" id="input-fecha_registro" disabled>
                            </div>
                            <div class="campo-edit">
                                <article class="label-form">Rol</article>
                                <select name="valor" id="input-rol_id" disabled>
                                    <option value="">--Selecciona--</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Usuario</option>
                                </select>
                            </div>
                            <div class="campo-edit">
                                <article class="label-form">Estatus</article>
                                <select name="valor" id="input-estatus_id" disabled>
                                    <option value="">--Selecciona--</option>
                                    <option value="1">Activo</option>
                                    <option value="2">Eliminado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <!-- Mandar nuevo valor al archivo UPDATE -->
                    <button type="submit" class="btn-habitos-rg">Actualizar</button>
                </form>
                <br><br>
                <?php
                    // Impresión de errores 
                    if (isset($_GET['error'])){
                        if ($_GET['error'] == 1) {
                            echo "<article class='red label-form'>Correo ya registrado</article>";
                        } else if ($_GET['error'] == 2) {
                            echo "<article class='red label-form'>Campo vacio</article>";
                        } else {
                            echo "<article class='red label-form'>Correo ya registrado</article>";
                        }
                    }
                ?>
            </div>
        </div>
        <br><br><br>
    </div>
    <br>
</main>

    <script>
        // Función para habilitar input valor mandado por el SELECT
        function habilitarCampo() {
            const campos = ["nombre", "apellido_paterno", "apellido_materno", "correo", "fecha_registro", "rol_id", "estatus_id"];
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