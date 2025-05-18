<?php include 'includes/headerlogins.php'; ?>

    <main>
        <script>
            // Función para validar que las contraseñas coincidan
            function validarFormulario(){
                const pass = document.getElementById("password").value;
                const confirmPass = document.getElementById('confirm_password').value;

                if (pass !== confirmPass) {
                    echo "<article class='error sesion-opcion'>Las contraseñas no coinciden</article>";
                    return false;
                }
                return true;
            }
        </script>

        <div class="cuenta-box">
            <img src="includes/assets/imgs/profile.svg" alt="perfil-icono" class="icn-perfil-sesion">
            <article class="sesion-text">Crear cuenta</article>
            <form action="includes/procesar_usuario.php" method="POST" onsubmit="return validarFormulario();">
                <input type="hidden" name="origen" value="../create.php">
                <div class="form-formato">
                    <img src="includes/assets/imgs/persona.svg" alt="contra-icono" class="icn-form">
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre" require>
                </div>
                <div class="form-formato">
                    <img src="includes/assets/imgs/personaplus.svg" alt="contra-icono" class="icn-form">
                    <input type="text" name="apellido_paterno" id="apellido_paterno" placeholder="Apellido paterno" require>
                </div>
                <div class="form-formato">
                    <img src="includes/assets/imgs/personaplus.svg" alt="contra-icono" class="icn-form">
                    <input type="text" name="apellido_materno" id="apellido_materno" placeholder="Apellido materno" require>
                </div>
                <div class="form-formato">
                    <img src="includes/assets/imgs/email.svg" alt="correo-icono" class="icn-form">
                    <input type="email" name="correo" id="correo" placeholder="Correo" require>
                </div>
                <div class="form-formato">
                    <img src="includes/assets/imgs/password.svg" alt="contra-icono" class="icn-form">
                    <input type="password" name="password" id="password" placeholder="Contraseña" require>
                </div>
                <div class="form-formato">
                    <img src="includes/assets/imgs/password.svg" alt="contra-icono" class="icn-form">
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirmar contraseña" require>
                </div>
                <a href="" class="form-formato">
                    <input type="submit" value="Crear cuenta" class="boton-ingresar">
                </a>
                <?php
                    // Impresión de errores 
                    if (isset($_GET['error'])){
                        if ($_GET['error'] == 1) {
                            echo "<article class='error sesion-opcion'>Campos obligatorios vacios</article>";
                        } else if ($_GET['error'] == 2) {
                            echo "<article class='error sesion-opcion'>Las contraseñas no coinciden</article>";
                        } else {
                            echo "<article class='error sesion-opcion'>Correo ya registrado</article>";
                        }
                    }
                ?>
                <hr>
                <a href="login.php"><article class="sesion-opcion">Iniciar sesión</article></a>
            </form>
        </div>
    </main>
    </div>

<?php include 'includes/footerlogins.php'; ?>