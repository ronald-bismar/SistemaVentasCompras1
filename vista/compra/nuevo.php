<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos Disponibles</title>
    <!-- Incluye Bootstrap CSS desde un CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            border-radius: 8px;
            border: 1px solid #ddd;
            overflow: hidden;  
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 1.25rem;
        }

        .card-title {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .card-text {
            font-size: 1rem;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0,0,0,0.5);
        }

        .btn-primary {
            width: 100%;
        }

        .col-md-4 {
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <h3 class="text-center mb-4">Productos Disponibles</h3>
    <div class="container">
        <div class="row">
            <?php foreach ($productos as $producto): ?>
            <div class="col-md-4">
                <div class="card shadow-sm border-light">
                    <img src="imagenes/productos/<?php echo $producto['foto']; ?>" class="card-img-top" alt="Imagen del producto">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $producto['nombre']; ?></h5>
                        <p class="card-text"><?php echo $producto['descripcion']; ?></p>
                        <p class="card-text"><strong>Precio:</strong> $<?php echo number_format($producto['precio'], 2); ?></p>
                        <a href="./?c=Compra&m=mostrarFormularioCompra&id_producto=<?php echo $producto['id_producto']; ?>" class="btn btn-primary">Comprar</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
