<body>
    <h3 class="">LISTA DE COMPRAS</h3>
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Codigo compra</th>
                <th scope="col">Nombre</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Fecha de Compra</th>
                <th scope="col">Foto</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = $inicio;
            foreach ($compras as $compra) {
                $i++;
            ?>
                <tr>
                    <th scope="row"><?php echo $i ?></th>
                    <td><?php echo $compra['id_compra'] ?></td>
                    <td><?php echo $compra['nombre_producto'] ?></td>
                    <td><?php echo $compra['cantidad'] ?></td>
                    <td><?php echo $compra['fecha'] ?></td>
                    <td><img src="imagenes/productos/<?php echo $compra['foto'] ?>" width="30px" height="30px"></td>
                    <td>
                        <!-- botones de las acciones -->
                        <a href="imagenes/productos/<?php echo $compra['foto'] ?>" width="100px" height="100px" target="_blank" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-picture"></i></a>

                        <a href="./?c=Compra&m=modificar&id=<?php echo $compra['id_compra'] ?>" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-pencil"></i></a>
                        <a href="./?c=Compra&m=eliminar&id=<?php echo $compra['id_compra'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar este compra?');"><i class="glyphicon glyphicon-trash"></i></a>

                        <!-- <button class="btn btn-warning">
                            <i class="glyphicon glyphicon-pencil"></i>
                        </button>
                        <form action="?c=compra&m=eliminar&id=<?php //echo $compra['codigo']; 
                                                                ?>" method="GET" style="display:inline;">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar este compra?');">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                        </form> -->
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <ul class="pagination">
        <li class="page-item">
            <a class="page-link" href="./?c=Compra&m=listar&pagina=1" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <?php
        for ($i = 1; $i <= $numeroVueltas; $i++) {

        ?>
            <li class="page-item <?php echo ($pagina == $i) ? 'active' : ''; ?>"><a class="page-link"
                    href="./?c=Compra&m=listar&pagina=<?php echo $i ?>">
                    <?php echo $i ?> </a></li>
        <?php
        }
        ?>
        <li class="page-item">
            <a class="page-link" href="./?c=Compra&m=listar&pagina=<?php echo $numeroVueltas?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</body>