<h3 class="text-center">MODIFICAR USUARIO</h3>
<form action="index.php/?c=Usuario&m=actualizar" method="post" enctype="multipart/form-data" class="">
    <!-- mandamos el id del controlador  -->
    <input type="hidden" name="id" value="<?php echo $id ?>">
    
    Apellido Paterno:
    <input type="text" name="apellido_paterno" class="form-control" value="<?php echo $usuario['apellido_paterno'] ?>" required>

    Apellido Materno:
    <input type="text" name="apellido_materno" class="form-control" value="<?php echo $usuario['apellido_materno'] ?>" required>

    Nombres:
    <input type="text" name="nombres" class="form-control" value="<?php echo $usuario['nombres'] ?>" required>


    Usuario:
    <input type="text" name="usuario" class="form-control" value="<?php echo $usuario['usuario'] ?>" required>

    <div class="text-center">
        <input type="submit" value="Modificar" class="btn btn-primary">
    </div>
</form>
