<h3 class="text-center"> REGISTRAR NUEVO PRODUCTO</h3>
<form action="index.php/?c=producto&m=guardar" method="post" enctype="multipart/form-data" class="">
    Codigo de Producto:
    <input type="text" name="codigo" class="form-control">

    Nombre del Producto:
    <input type="text" name="nombre" class="form-control">

    Precio del Producto:
    <input type="number" name="precio" class="form-control">

    Descripcion del producto:
    <!-- <input type="textarea" name="descripcion" class="form-control"><br> -->
    <div class="mb-3">
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
    </div>

    Foto del producto:
    <input type="file" name="foto" class="form-control"><br>
    <div class="text-center">
        <input type="submit" value="Guardar" class="btn btn-primary">
    </div>

</form>