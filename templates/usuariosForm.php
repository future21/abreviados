<h2><?php echo $view->label ?></h2>
<form name ="client" id="client" method="POST" action="main.php">
    <input type="hidden" name="id" id="id" value="<?php print $view->client->getId() ?>">
    <div>
        <label>Nombre</label>
        <input type="text" name="nombre" id="nombre" value = "<?php print $view->client->getNombre() ?>">
    </div>
    <div>
        <label>Apellido</label>
        <input type="text" name="apellido" id="apellido"value = "<?php print $view->client->getApellido() ?>">
    </div>
    <div>
        <label>Email</label>
        <input type="text" name="email" id="email" value = "<?php print $view->client->getEmail() ?>">
    </div>

    <div>
        <label>Password</label>
        <input type="text" name="encrypted_password" id="encrypted_password" value = "<?php print $view->client->getEncrypted_password() ?>">
    </div>
    <!--
    <div>
        <label>Salt</label>
        <input type="text" name="salt" id="salt" value = "<?php print $view->client->getSalt() ?>">
    </div>
    -->
    <?php if ($_SESSION['key']=="1") { ?>
    <div>
        <label>Administrador</label>
        <?php
        if ($view->client->getAdm()=="1") {
            $check=$view->client->getAdm();
            $checked=($check=="1")?" checked ":"";
            echo '<input type="checkbox" name="adm" id="adm" value="0" '.$checked.'>';
        } else {
            echo '<input type="checkbox" name="adm" id="adm" value="1">';
        }
        ?>
    </div>
    <?php } ?>
    <div>
        <label>Creado:</label><?php print $view->client->getCreated_at() ?>
        <!--<input type="text" name="created_at" id="created_at" value = "<?php print $view->client->getCreated_at() ?>">-->
    </div>
    <div class="buttonsBar">
        <input id="pass" type="button" name="pass" value ="Password" />
        <input id="cancel" type="button" name="cancel" value ="Cancelar" />
        <input id="submit" type="submit" name="submit" value ="Guardar" />
    </div>
</form>