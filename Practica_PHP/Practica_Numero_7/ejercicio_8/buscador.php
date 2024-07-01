<?php
    include("database.php");
    $search_list = 'SELECT * FROM buscador WHERE canciones = "'.$_POST["cancion"].'"';
    $result_list = mysqli_query($conn, $search_list);
    if(mysqli_num_rows($result_list) > 0){
        $row = mysqli_fetch_assoc($result_list);
        echo"La cancion {$row['canciones']} tiene una duracion de {$row['duracion']}";
    }
    else{
        echo"No se pudo encontrar la cancion que busca";
    }
?>