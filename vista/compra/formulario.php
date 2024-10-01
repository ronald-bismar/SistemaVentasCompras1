<h3 class="text-center">Registrar Nueva Compra</h3>
<form action="index.php/?c=Compra&m=guardar" method="post" enctype="multipart/form-data" class="">
    Cantidad:
    <input type="number" name="cantidad" class="form-control" required>

    Producto:
    <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
    <input type="text" class="form-control" value="<?php echo $producto['nombre']; ?>" readonly>

    Precio del Producto:
    <input type="number" id="precio" name="precio" class="form-control" value="<?php echo $producto['precio']; ?>" readonly>

    Descripción del producto:
    <div class="mb-3">
        <textarea class="form-control" id="descripcion" name="descripcion" rows="2" readonly><?php echo $producto['descripcion']; ?></textarea>
    </div>

    <div class="text-center">
        <input type="submit" value="Registrar Compra" class="btn btn-primary">
    </div>
</form>
