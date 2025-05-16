<?php include 'includes/headerlogins.php'; ?>

    <main>
        <div class="sesion-box">
            <img src="includes/assets/imgs/profile.svg" alt="perfil-icono" class="icn-perfil-sesion">
            <article class="sesion-text">Iniciar sesión</article>
            <form action="includes/verificar_sesion.php" method="POST">
                <div class="form-formato">
                    <img src="includes/assets/imgs/email.svg" alt="correo-icono" class="icn-form">
                    <input type="email" name="usuario" id="usuario" placeholder="Correo" require>
                </div>
                <div class="form-formato">
                    <img src="includes/assets/imgs/password.svg" alt="contra-icono" class="icn-form">
                    <input type="password" name="password" id="password" placeholder="Contraseña" require>
                </div>
                <a href="" class="form-formato">
                    <input type="submit" value="Iniciar sesión" class="boton-ingresar">
                </a>
            </form>
        </div>
    </main>
    </div>

<?php include 'includes/footerlogins.php'; ?>