<body>
    <h3 class="">LISTA DE PRODUCTOS</h3>
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Apellido Paterno</th>
                <th scope="col">Apellido Materno</th>
                <th scope="col">Nombre</th>
                <th scope="col">Usuario</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = $inicio;
            foreach ($usuarios as $usuario) {
                $i++;
            ?>
                <tr>
                    <th scope="row"><?php echo $i ?></th>
                    <td><?php echo $usuario['apellido_paterno'] ?></td>
                    <td><?php echo $usuario['apellido_materno'] ?></td>
                    <td><?php echo $usuario['nombres'] ?></td>
                    <td><?php echo $usuario['usuario'] ?></td>
                    <td>
                    
                        <a href="./?c=Usuario&m=modificar&id=<?php echo $usuario['id_usuario'] ?>" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-pencil"></i></a>
                        <a href="./?c=Usuario&m=eliminar&id=<?php echo $usuario['id_usuario'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar este usuario?');"><i class="glyphicon glyphicon-trash"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <ul class="pagination">
        <li class="page-item">
            <a class="page-link" href="./?c=Usuario&m=listar&pagina=1" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <?php
        for ($i = 1; $i <= $numeroVueltas; $i++) {

        ?>
            <li class="page-item <?php echo ($pagina == $i) ? 'active' : ''; ?>"><a class="page-link"
                    href="./?c=Usuario&m=listar&pagina=<?php echo $i ?>">
                    <?php echo $i ?> </a></li>
        <?php
        }
        ?>
        <li class="page-item">
            <a class="page-link" href="./?c=Usuario&m=listar&pagina=<?php echo $numeroVueltas?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</body>