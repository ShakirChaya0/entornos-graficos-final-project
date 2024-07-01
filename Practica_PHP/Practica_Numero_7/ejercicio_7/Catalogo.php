<?php
    include("database.php");
    ob_start("ob_gzhandler");
    session_start();

    if (isset($_SESSION['carro'])) {
        $carro = $_SESSION['carro'];
    } else {
        $carro = false;
    }

    $result = mysqli_query($connection, "SELECT * FROM catalogo ORDER BY producto ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr valign="middle">
                <th>Producto</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($row = mysqli_fetch_assoc($result)){
            ?>
            <tr valign="middle" class="catalogo">
                <td><?php echo $row['producto'] ?></td>
                <td><?php echo $row['precio'] ?></td>
                <td align="center">
                    <?php if(!$carro || !isset($carro[md5($row['id'])]['identificador']) || $carro[md5($row['id'])]['identificador'] != md5($row['id'])) { ?>
                        <a href="Agregarcar.php?id=<?php echo $row['id'] ?>" class="btn btn-primary">Agregar</a>
                    <?php } else { ?>
                        <a href="borrarCarrito.php?id=<?php echo $row['id'] ?>" class="btn btn-danger">Quitar</a>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="verCarrito.php" class="btn btn-info">Ver carrito</a>
</div>
</body>
</html>
<?php
    ob_end_flush();
?>
