<?php
    include("database.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla 2x2</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 18px;
            text-align: left;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<table>
    <tr>
        <th>id</th>
        <th>ciudad</th>
        <th>pais</th>
        <th>habitantes</th>
        <th>superficie</th>
        <th>tieneMetro</th>
    </tr>
    <?php
    $cant_registros = 15;
    $pag = isset($_GET["page"]) ? $_GET["page"] : 1;
    $inicio = ($pag - 1) * $cant_registros;
    $search_list = "SELECT * FROM ciudades limit $inicio, $cant_registros";
    $result_list = mysqli_query($conn, $search_list);
    $sql_total = "SELECT COUNT(*) FROM ciudades";
    $result_total = mysqli_query($conn, $sql_total);
    $row_total = mysqli_fetch_row($result_total);
    $total_results = $row_total[0];
    $total_pags = ceil($total_results / $cant_registros);
    while ($row_list = mysqli_fetch_assoc($result_list)) {
        echo"
            <tr>
                <td>{$row_list['id']}</td>
                <td>{$row_list['ciudad']}</td>
                <td>{$row_list['pais']}</td>
                <td>{$row_list['habitantes']}</td>
                <td>{$row_list['superficie']}</td>
                <td>{$row_list['tieneMetro']}</td>
            </tr>
        ";
    }
    ?>
    <?php
        $pag = !isset($_GET["page"]) ? 1 : $_GET["page"];
    ?>
        <span>Página <?php echo $pag ?> de <?php echo $total_pags ?></span>
    <?php
        echo '
        <span>
            <ul>
        ';
        for ($i = 1; $i <= $total_pags; $i++) {
            if ($pag == $i){
                ?>
                    <li><a href=""><?php echo $i ?></a></li>    
                <?php
            }
            else{
                ?>
                    <li><a href="?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                <?php
            }  
        }
        echo '
                </ul>
            </span>
        ';
    ?>
    <tr>
        <p><a href="home.html">Volver al menu; del ABML</a></p>
    </tr>
</table>

</body>
</html>
