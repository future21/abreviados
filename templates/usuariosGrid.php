<div class="bar">
    <?php if ($_SESSION['key']=="1") {
        echo "<a id='new' class='button' href='javascript:void(0);'>Nuevo Usuario</a>";

    } ?>
</div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_lista_usuarios">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <!--<th>Password</th>
            <th>Salt</th>-->
            <th>Creado</th>
            <th>Editar</th>
            <th>Borrar</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($view->clientes as $cliente):  // uso la otra sintaxis de php para templates ?>
            <tr>
                <td><?php echo $cliente['id'];?></td>
                <td><?php echo $cliente['nombre'];?></td>
                <td><?php echo $cliente['apellido'];?></td>
                <td><?php echo $cliente['email'];?></td>
                <!--<td><?php echo $cliente['encrypted_password'];?></td>
                <td><?php echo $cliente['salt'];?></td>-->
                <td><?php echo $cliente['created_at'];?></td>
                <?php if (($_SESSION['key']=="1") or ($_SESSION['id']==$cliente['id'])) {
                    //if ($view->id==$cliente['id']) {
                    echo "<td><a class='edit' href='javascript:void(0);' data-id=". $cliente['id'].">Editar</a></td>";
                    echo "<td><a class='delete' href='javascript:void(0);' data-id=". $cliente["id"].">Borrar</a></td>";
                    //}
                } ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
