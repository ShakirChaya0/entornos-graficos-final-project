<?php
    session_start();
    $_SESSION["cont"] = 1;
?>
<html>
<head>
    <title>Usuario a modificar</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<form action="Modificar.php" method="POST" name="FormModiIni">
    <table>
        <tr>
            <td> Ciudad a modificar : </td>
            <td>
            <input type="TEXT" name="ciudad">
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
            <input type="SUBMIT" name="submit" value="Modificar">
            <p><a href="Menu.html">Volver al men&uacute; del ABM</a></p>
            </td>
        </tr>
    </table>
</form>
</body>
</html>