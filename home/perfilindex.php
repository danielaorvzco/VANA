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
            <div class="perfil-bienvenido">
                <img src="../includes/assets/imgs/name-icn.svg" alt="icono-nombre" class="icn-tag">
                <article class="bien-perfil">Bienvenido a tu perfil</article>
            </div>
        </div>
        <br>
        <article class="bienvenido-perfil"><?=$_SESSION['nombre_completo'];?></article>
        <div class="btns-perfil">
            <button type="submit" class="btn-perfil-pink">Editar</button>
            <button class="btn-perfil-blue" onclick="window.location.href='../logout.php'">Cerrar sesión</button>
        </div>
        <form action="usuarios/editar_perfil.php" method="POST" onsubmit="return validarFormulario();">
            <div class="form-perfil">
                <?php
                    // Impresión de errores 
                    if (isset($_GET['error'])){
                        if ($_GET['error'] == 1) {
                            echo "<article class='red label-form'>Correo ya registrado</article>";
                        } else {
                            echo "<article class='red label-form'>Campo vacio</article>";
                        } 
                    }
                ?>
                <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id'] ?>">
                    <div class="select-edit">
                        <article class="select-perfil">Selecciona el campo que quieres editar</article>
                        <select name="campo" id="campo" disabled onchange="habilitarCampo()">
                            <option value="">--Selecciona--</option>
                            <option value="nombre">Nombre</option>
                            <option value="apellido_paterno">Apellido paterno</option>
                            <option value="apellido_materno">Apellido materno</option>
                            <option value="correo">Correo</option>
                            <option value="password">Contraseña</option>
                        </select>
                    </div>
                    <div class="grupo1-campo">
                        <div class="campo-perfil">
                            <img src="../includes/assets/imgs/actualizar.svg" alt="icono-actualizar" class="icn-actualizar">
                            <div class="campo-edit">
                                <article class="label-form">Nombre</article>
                                <input type="text" name="valor" id="input-nombre" disabled>
                            </div>
                        </div>
                        <div class="campo-perfil">
                            <img src="../includes/assets/imgs/actualizar.svg" alt="icono-actualizar" class="icn-actualizar">
                            <div class="campo-edit">
                                <article class="label-form">Apellido paterno</article>
                                <input type="text" name="valor" id="input-apellido_paterno" disabled>
                            </div>
                        </div>
                        <div class="campo-perfil">
                            <img src="../includes/assets/imgs/actualizar.svg" alt="icono-actualizar" class="icn-actualizar">
                            <div class="campo-edit">
                                <article class="label-form">Apellido materno</article>
                                <input type="text" name="valor" id="input-apellido_materno" disabled>
                            </div>
                        </div>
                        <div class="campo-perfil">
                            <img src="../includes/assets/imgs/actualizar.svg" alt="icono-actualizar" class="icn-actualizar">
                            <div class="campo-edit">
                                <article class="label-form">Correo</article>
                                <input type="email" name="valor" id="input-correo" disabled>
                            </div>
                        </div>
                        <div class="campo-perfil">
                            <img src="../includes/assets/imgs/actualizar.svg" alt="icono-actualizar" class="icn-actualizar">
                            <div class="campo-edit">
                                <article class="label-form">Contraseña</article>
                                <input type="password" name="valor" id="input-password" disabled>
                            </div>
                        </div>
                        <div class="campo-perfil">
                            <img src="../includes/assets/imgs/actualizar.svg" alt="icono-actualizar" class="icn-actualizar">
                            <div class="campo-edit">
                                <article class="label-form">Confirmar contraseña</article>
                                <input type="password" id="input-confirm_password" disabled>
                            </div>
                        </div>
                    </div>

                    <br>
                    <button type="submit" class="btn-habitos-rg">Actualizar</button>
                </form>
            </div>
    </main>

    <script>
        //  Si se selecciona el btn de editar, se habilita el SELECT de campo a editar
        document.querySelector('.btn-perfil-pink').addEventListener('click', () => {
            document.getElementById('campo').disabled = false;
        });

        // Función para habilitar input valor mandado por el SELECT
        function habilitarCampo() {
            const campoSeleccionado = document.getElementById("campo").value;
            const campos = ["nombre", "apellido_paterno", "apellido_materno", "correo", "password"];

            campos.forEach(campo => {
                const input = document.getElementById("input-" + campo);
                if (input) {
                    const esSeleccionado = campo === campoSeleccionado;
                    input.disabled = !esSeleccionado;
                    input.style.backgroundColor = esSeleccionado ? "#fff" : "#e0e0e0";

                    if (esSeleccionado) {
                        input.setAttribute("name", "valor");
                    } else {
                        input.removeAttribute("name");
                    }
                }
            });

            // Si el campo seleccionado es password, 'condirm_password' se habilita también
            const confirmInput = document.getElementById("input-confirm_password");
            if (campoSeleccionado === "password") {
                document.getElementById("input-password").disabled = false;
                confirmInput.disabled = false;
                confirmInput.style.backgroundColor = "#fff";
            } else {
                confirmInput.disabled = true;
                confirmInput.style.backgroundColor = "#e0e0e0";
            }
        }

        // Validar que las contraseñas coincidan
        function validarFormulario(){
            const campoSeleccionado = document.getElementById("campo").value;
            
            if (campoSeleccionado == "password") {
                const pass = document.getElementById("input-password").value;
                const confirmPass = document.getElementById("input-confirm_password").value;

                if (pass !== confirmPass) {
                    alert("Las contraseñas no coinciden");
                    return false;
                }
            }
            return true;
        }
    </script>

<?php include '../includes/footer.php'; ?>