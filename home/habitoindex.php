<?php 
    session_start();
    
    // Redirigir al Index
    if(!isset($_SESSION['usuario_id'])){
        header ("Location: ../index.html");
        exit();
    }

    include '../includes/header.php';
    // Archivo que consulta todos los hábitos del usuario
    include 'habitos/habitos_usuario.php';
?>
    <main>
        <div class="fondo-estacion">
            <div class="line2">
                <article class="bienvenido">Tus hábitos, <?=$_SESSION['nombre'];?>!</article>
            </div>
            <div class="box-estacion">
                <div class="personajes">
                    <img src="../includes/assets/imgs/personaje4.png" alt="personaje-vana1" class="personaje1">
                </div>
                <div class="estacion-click">
                    <article class="estacion">lo favorito de lo favorito</article>
                    <div class="list-hobbies">
                        <?php foreach ($habitos as $habito): // Imprimir TODOS los hábitos del usuario?>
                        <div class="list-hobbiess <?= $habito['estado'] === 'completo' ? 'hbt-completado' : '' ?>">
                            <img src="../includes/assets/imgs/heart.svg" alt="icono-corazon" class="icn-hobbie">
                            <!-- FORM para envíar el ID del hábito a eliminar -->
                            <form action="habitos/eliminar_habito.php" method="POST" style="display:inline;">
                                <input type="hidden" name="habito_id" value="<?= $habito['id'] ?>">
                                <button type="submit" class="icn-delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este hábito?')">
                                    <img src="../includes/assets/imgs/delete.svg" alt="icono-borrar">
                                </button>
                            </form>
                            <?php if ($habito['estado'] === 'completo'): ?>
                                <img src="../includes/assets/imgs/edit.svg" alt="editar-icono" class="icn-opcion sub" title="No editable">
                            <?php else: ?>
                                <!-- Envíar id del hábito a la página de edición -->
                                <a href="editar-habito.php?id=<?= $habito['id'] ?>">
                                    <img src="../includes/assets/imgs/edit.svg" alt="editar-icono" class="icn-opcion">
                                </a>
                            <?php endif; ?>
                            <!-- Impresión de los datos del hábito -->
                            <article class="hobbie"><?= htmlspecialchars($habito['nombre']) ?> -</article>
                            <article class="descripcion"><?= htmlspecialchars($habito['descripcion']) ?> -</article>
                            <article class="otro-hobbie"><?= ucfirst($habito['frecuencia']) ?> -</article>
                            <article class="otro-hobbie"><?= htmlspecialchars($habito['meta']) ?> días -</article>
                            <article class="otro-hobbie"><?= date("d/m/Y", strtotime($habito['fecha_creacion'])) ?> -</article>
                            <article class="otro-hobbie"><?= ucfirst($habito['estado']) ?></article>
                        </div>
                        <?php endforeach; ?>
                        <br>
                    </div>
                </div>
            </div>
        </div>

        <div class="fondo-formulario">
            <div class="box-formulario">
                <div class="izq">
                    <article class="registro-text">Registremos un nuevo hábito</article>
                    <form action="habitos/registrar_habito.php" method="POST">
                        <div class="estr-form">
                            <div class="etiqueta">
                                <img src="../includes/assets/imgs/name-icn.svg" alt="icono-formulario" class="icn-hobbie">
                                <article class="label-form">Empecemos por el nombre</article>
                            </div>
                            <input type="text" name="nombre" id="nombre">
                        </div>
                        <div class="estr-form">
                            <div class="etiqueta">
                                <img src="../includes/assets/imgs/name-icn.svg" alt="icono-formulario" class="icn-hobbie">
                                <article class="label-form">¿Qué tal una pequeña descripción?</article>
                            </div>
                            <input type="text" name="descripcion" id="descripcion">
                        </div>
                        <div class="estr-form">
                            <div class="etiqueta">
                                <img src="../includes/assets/imgs/name-icn.svg" alt="icono-formulario" class="icn-hobbie">
                                <article class="label-form">Selecciona tu frecuencia</article>
                            </div>
                            <select name="frecuencia" id="frecuencia">
                                <option value="diario">Diaria</option>
                                <option value="semanal">Semanal</option>
                                <option value="mensual">Mensual</option>
                                <option value="bimestral">Bimestral</option>
                                <option value="trimestrual">Trimestral</option>
                            </select>
                        </div>
                        <div class="estr-form">
                            <div class="etiqueta">
                                <img src="../includes/assets/imgs/name-icn.svg" alt="icono-formulario" class="icn-hobbie">
                                <article class="label-form">Establezcamos un meta</article>
                            </div>
                            <input type="number" name="meta" id="meta">
                            <article class="hb-help">Veces que quieres cumplir esta hábito según la frecuencia</article>
                        </div>
                        <?php
                            if (isset($_GET['error'])){
                                // Impresión de errores
                                echo "<article class='hb-help red'>Campos obligatorios vacios</article>";
                            }
                        ?>
                        <br>
                        <button class="btn-habitos-rg">¡Listo!</button>
                    </form>
                </div>

                <div class="der">
                    <div class="msg-form">
                        <article class="bienvenido">Pero...</article>
                        <article class="bnv-italic">quieres más?</article>
                    </div>
                    <img src="../includes/assets/imgs/personaje5.png" alt="personaje-5" class="personaje3">
                </div>
            </div>
        </div>
    </main>

<?php include '../includes/footer.php'; ?>