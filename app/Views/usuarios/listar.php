<?= $header; ?>

    <a class="btn btn-success" href= "<?=base_url('crear') ?>">Crear servicio</a>
    <br/>
    <br/>
        <table class="table table-light">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Cargo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach($usuarios as $usuario): ?>

                <tr>
                    <td><?= $usuario['id'] ?></td>
                    <td>                       
                        <img class="img-thumbnail" src="<?= base_url() ?>/uploads/<?= $usuario['imagen']; ?>" width="100" alt="">               
                    </td>
                    <td><?= $usuario['nombre'] ?></td>
                    <td><?= $usuario['cargo'] ?></td>
                    <td>
                        <a href="<?= base_url('editar/'.$usuario['id']); ?>" class="btn btn-info" type="button">Editar</a>
                        <a href="<?= base_url('borrar/'.$usuario['id']); ?>" class="btn btn-danger" type="button">Eliminar</a>                   
                    </td>
                </tr>

                <?php endforeach; ?>

            </tbody>
        </table>

<?= $footer; ?>