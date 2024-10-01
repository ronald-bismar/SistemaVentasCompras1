<h3 class="text-center">MODIFICAR COMPRA</h3>
<form action="index.php/?c=Compra&m=actualizar" method="post" enctype="multipart/form-data" class="">
    <!-- mandamos el id del controlador  -->
    <input type="hidden" name="id" value="<?php echo $id ?>">
    
    Cantidad de Unidades:
    <input type="number" name="cantidad" class="form-control" value="<?php echo $compra['cantidad'] ?>" required>

    <div class="text-center">
        <input type="submit" value="Modificar" class="btn btn-primary">
    </div>
</form>
