<?php
    session_start();
    include("database.php");

    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
    $cantidad = isset($_REQUEST['cantidad']) ? (int)$_REQUEST['cantidad'] : 1;

    if (!$id) {
        die("ID de producto no especificado.");
    }

    $result = mysqli_query($connection, "SELECT * FROM catalogo WHERE id='$id'");
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        if (!isset($_SESSION['carro'])) {
            $_SESSION['carro'] = [];
        }
        $_SESSION['carro'][md5($id)] = [
            'identificador' => md5($id),
            'cantidad' => $cantidad,
            'producto' => $row['producto'],
            'precio' => $row['precio'],
            'id' => $id
        ];
    }

    header("Location: Catalogo.php");
?>
