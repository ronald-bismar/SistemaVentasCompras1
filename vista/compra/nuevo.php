<h3 class="text-center">REGISTRAR NUEVA COMPRA</h3>
<form action="index.php/?c=producto&m=guardar" method="post" enctype="multipart/form-data" class="">
    Cantidad:
    <input type="text" name="cantidad" class="form-control">

    Producto:
    <select name="tipo_producto" id="tipo_producto" class="form-control" onchange="actualizarCampos()">
        <?php
         $i = $inicio;
         foreach ($productos as $producto) {
             $i++;
             $nombreProducto = $producto['nombre'];
             $precioProducto = $producto['precio']; // Precio del producto
             $descripcionProducto = $producto['descripcion']; // Descripción del producto
        ?>
        <option
            value="<?php echo htmlspecialchars(json_encode(['nombre' => $nombreProducto, 'precio' => $precioProducto, 'descripcion' => $descripcionProducto])); ?>">
            <?php echo $nombreProducto ?>
        </option>
        <?php
         }
         ?>
    </select>

    Precio del Producto:
    <input type="number" id="precio" name="precio" class="form-control">

    Descripción del producto:
    <div class="mb-3">
        <textarea class="form-control" id="descripcion" name="descripcion" rows="2"></textarea>
    </div>

    <div class="text-center">
        <input type="submit" value="Comprar" class="btn btn-primary">
    </div>
</form>

<script>
function actualizarCampos() {
    // Obtener el valor del producto seleccionado
    var select = document.getElementById("tipo_producto");
    var productoSeleccionado = JSON.parse(select.value);

    // Actualizar los campos con los datos del producto seleccionado
    document.getElementById("precio").value = productoSeleccionado.precio;
    document.getElementById("descripcion").value = productoSeleccionado.descripcion;
}
</script>