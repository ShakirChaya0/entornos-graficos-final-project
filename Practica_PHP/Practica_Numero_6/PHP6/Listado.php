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
    $search_list = "SELECT * FROM ciudades";
    $result_list = mysqli_query($conn, $search_list);
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
    <tr>
        <p><a href="home.html">Volver al menu; del ABML</a></p>
    </tr>
</table>

</body>
</html>
