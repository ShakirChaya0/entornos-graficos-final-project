<?php
    session_start();
    include("database.php");

    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;

    if ($id && isset($_SESSION['carro'][md5($id)])) {
        unset($_SESSION['carro'][md5($id)]);
    }

    header("Location: Catalogo.php");
?>
