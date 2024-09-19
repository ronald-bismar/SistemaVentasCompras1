<body>
    <h3 class="">LISTA DE PRODUCTOS</h3>
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Codigo</th>
                <th scope="col">Nombre</th>
                <th scope="col">Precio</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Foto</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = $inicio;
            foreach ($productos as $producto) {
                $i++;
            ?>
            <tr>
                <th scope="row"><?php echo $i ?></th>
                <td><?php echo $producto['codigo'] ?></td>
                <td><?php echo $producto['nombre'] ?></td>
                <td><?php echo $producto['precio'] ?></td>
                <td><?php echo $producto['descripcion'] ?></td>
                <td><img src="imagenes/productos/<?php echo $producto['foto'] ?>" width="30px" height="30px"></td>
                <td>
                    <!-- botones de las acciones -->
                    <a href="imagenes/productos/<?php echo $producto['foto'] ?>" width="100px" height="100px"
                        target="_blank" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-picture"></i></a>

                    <a href="./?c=Producto&m=modificar&id=<?php echo $producto['id_producto'] ?>"
                        class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-pencil"></i></a>
                    <a href="./?c=Producto&m=eliminar&id=<?php echo $producto['id_producto'] ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Está seguro de que desea eliminar este producto?');"><i
                            class="glyphicon glyphicon-trash"></i></a>

                    <!-- <button class="btn btn-warning">
                            <i class="glyphicon glyphicon-pencil"></i>
                        </button>
                        <form action="?c=producto&m=eliminar&id=<?php //echo $producto['codigo']; 
                                                                ?>" method="GET" style="display:inline;">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar este producto?');">
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
            <a class="page-link" href="./?c=Producto&m=listar&pagina=1" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <?php
        for ($i = 1; $i <= $numeroVueltas; $i++) {

        ?>
        <li class="page-item <?php echo ($pagina == $i) ? 'active' : ''; ?>"><a class="page-link"
                href="./?c=Producto&m=listar&pagina=<?php echo $i ?>">
                <?php echo $i ?> </a></li>
        <?php
        }
        ?>
        <li class="page-item">
            <a class="page-link" href="./?c=Producto&m=listar&pagina=<?php echo $numeroVueltas?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</body>