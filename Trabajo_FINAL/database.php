<?php
    $db_server = "localhost";
    $db_user = "u213228055_Shakir";
    $db_pass = "Entornos1";
    $db_name = "u213228055_rsc_db";
    $conn = "";
    try{
        $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    }
    catch(mysqli_sql_exception){
        echo"Colud not conneted!";
    }
    if($conn){
        //echo"you are connected <br>";
    }
?>