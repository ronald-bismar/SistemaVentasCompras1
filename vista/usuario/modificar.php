<h3 class="text-center">MODIFICAR PRODUCTO</h3>
<form action="index.php/?c=producto&m=actualizar" method="post" enctype="multipart/form-data" class="">
    <!-- mandamos el id del controlador  -->
    <input type="hidden" name="id" value="<?php echo $id ?>">
    
    Codigo de Producto:
    <input type="text" name="codigo" class="form-control" value="<?php echo $producto['codigo'] ?>" required>

    Nombre del Producto:
    <input type="text" name="nombre" class="form-control" value="<?php echo $producto['nombre'] ?>" required>

    Precio del Producto:
    <input type="number" name="precio" class="form-control" value="<?php echo $producto['precio'] ?>" required>

    Descripción del producto:
    <div class="mb-3">
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo $producto['descripcion'] ?></textarea>
    </div>

    Foto del producto:<br>
    <img src="imagenes/productos/<?php echo $producto['foto'] ?>" alt="" style="width:150px;height:auto;"><br><br>
    Selecciona imagen para modificar
    <input type="file" name="foto" class="form-control"><br>

    <input type="hidden" name="fotoActual" value="<?php echo $producto['foto']; ?>">


    <div class="text-center">
        <input type="submit" value="Modificar" class="btn btn-primary">
    </div>
</form>
