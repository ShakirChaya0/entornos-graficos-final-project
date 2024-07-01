<?php
    session_start();
    include("database.php");
    
    $carro = isset($_SESSION['carro']) ? $_SESSION['carro'] : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Carrito</h2>
    <?php if (empty($carro)) { ?>
        <div class="alert alert-warning">El carrito está vacío.</div>
    <?php } else { ?>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $totalCarrito = 0;
                foreach ($carro as $item) {
                    $totalProducto = $item['precio'] * $item['cantidad'];
                    $totalCarrito += $totalProducto;
                ?>
                <tr>
                    <td><?php echo $item['producto'] ?></td>
                    <td><?php echo $item['cantidad'] ?></td>
                    <td><?php echo $item['precio'] ?></td>
                    <td><?php echo $totalProducto ?></td>
                    <td><a href="borrarCarrito.php?id=<?php echo $item["id"] ?>" class="btn btn-danger">Quitar</a></td>
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="3" class="text-right"><strong>Total:</strong></td>
                    <td colspan="2"><?php echo $totalCarrito ?></td>
                </tr>
            </tbody>
        </table>
    <?php } ?>
    <a href="Catalogo.php" class="btn btn-primary">Ver catalogo</a>
</div>
</body>
</html>
