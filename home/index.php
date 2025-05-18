<?php 
    // Iniciar sesión
    session_start();
    
    // Redirigir a Index
    if(!isset($_SESSION['usuario_id'])){
        header ("Location: ../index.html");
        exit();
    }

    include '../includes/header.php';
    // Archivo que imprime los usuarios registrados
    include 'usuarios/get_usuarios.php';
?>
    <main>
        <script>
            // Función para validar que las contraseñas coincidan
            function validarFormulario(){
                const pass = document.getElementById("password").value;
                const confirmPass = document.getElementById('confirm_password').value;

                if (pass !== confirmPass) {
                    echo "<article class='red label-form'>Las contraseñas no coinciden</article>";
                    return false;
                }
                return true;
            }
        </script>

        <div class="fondo-estacion">
            <div class="line1">
                <article class="bienvenido">Bienvenido, <?=$rol?>!</article>
            </div>
            <article class="msg-siempre">Disfruta de tus beneficios exclusivos</article>
            <div class="Form-cuerpo">
                <img src="../includes/assets/imgs/personaje5.png" alt="personaje5-vana" class="icn-personajeGlass">
                <div class="Formulario-editar">
                    <form action="../includes/procesar_usuario.php" method="POST" onsubmit="return validarFormulario();">
                        <input type="hidden" name="origen" value="../home/index.php">
                        <div class="Form-editar">
                            <div class="grupo1-campo">
                                <div class="campo-edit">
                                    <article class="label-form">Nombre</article>
                                    <input type="text" name="nombre" id="nombre">
                                </div>
                                <div class="campo-edit">
                                    <article class="label-form">Apellido paterno</article>
                                    <input type="text" name="apellido_paterno" id="apellido_paterno">
                                </div>
                                <div class="campo-edit">
                                    <article class="label-form">Apellido materno</article>
                                    <input type="text" name="apellido_materno" id="apellido_materno">
                                </div>
                            </div>
                            <div class="grupo2-campo">
                                <div class="campo-edit">
                                    <article class="label-form">Correo</article>
                                    <input type="email" name="correo" id="correo">
                                </div>
                                <div class="campo-edit">
                                    <article class="label-form">Contraseña</article>
                                    <input type="password" name="password" id="password">
                                </div>
                                <div class="campo-edit">
                                    <article class="label-form">Confirmar contraseña</article>
                                    <input type="password" name="confirm_password" id="confirm_password">
                                </div>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn-habitos-rg">Registrar</button>
                    </form>
                    <br><br>
                    <?php
                    // Impresión de errores 
                    if (isset($_GET['error'])){
                        if ($_GET['error'] == 1) {
                            echo "<article class='red label-form'>Campos obligatorios vacios</article>";
                        } else if ($_GET['error'] == 2) {
                            echo "<article class='red label-form'>Las contraseñas no coinciden</article>";
                        } else {
                            echo "<article class='red label-form'>Correo ya registrado</article>";
                        }
                    }
                ?>
                </div>
            </div>
            <br><br><br>
        </div>

        <div class="line2">
            <article class="bienvenido-crud">Nuestros usarios</article>
        </div>
        <div class="list-usuarios">
            <?php foreach ($usuarios as $usuario): // Impresión de los usuarios ?>
                <div class="list-hobbiess">
                    <img src="../includes/assets/imgs/smile-face.svg" alt="icono-persona_feliz" class="icn-smile">
                    <form action="usuarios/eliminar_usuario.php" method="POST" style="display:inline;">
                        <input type="hidden" name="usuario_id" value="<?= $usuario['id'] ?>">
                        <button type="submit" class="icn-delete-crud" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">
                            <img src="../includes/assets/imgs/delete-azul.svg" alt="icono-borrar">
                        </button>
                    </form>
                    <a href="editar-usuario.php?id=<?= $usuario['id'] ?>">
                        <img src="../includes/assets/imgs/edit-azul.svg" alt="editar-icono" class="icn-opcion-crud">
                    </a>
                    <article class="hobbie"><?= htmlspecialchars($usuario['id']) ?> -</article>
                    <article class="hobbie"><?= htmlspecialchars($usuario['nombre']) ?> -</article>
                    <article class="otro-hobbie"><?= htmlspecialchars($usuario['apellido_paterno']) ?> -</article>
                    <article class="otro-hobbie"><?= ucfirst($usuario['apellido_materno']) ?> -</article>
                    <article class="otro-hobbie"><?= htmlspecialchars($usuario['correo']) ?> -</article>
                    <article class="otro-hobbie">
                        <?php 
                            if ($usuario['rol_id'] == 1) {
                                echo "Administrador";
                            } else {
                                echo "Usuario";
                            }
                        ?>
                    -</article>
                    <article class="otro-hobbie">
                        <?php 
                            if ($usuario['estatus_id'] == 1) {
                                echo "Activo";
                            } else {
                                echo "Eliminado";
                            }
                        ?>
                    -</article>
                    <article class="otro-hobbie"><?= htmlspecialchars($usuario['fecha_registro']) ?> </article>
                </div>
            <?php endforeach; ?>
            <br>
        </div>
        </main>

<?php include '../includes/footer.php'; ?>