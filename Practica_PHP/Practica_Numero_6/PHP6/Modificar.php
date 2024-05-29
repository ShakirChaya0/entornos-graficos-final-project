<?php
    session_start();
    include("database.php");
    if($_SESSION["cont"] < 2){
        $_SESSION["buscar"] = $_POST["ciudad"];
        $_SESSION["cont"]++;
    }
    $search_list = 'SELECT * FROM ciudades WHERE ciudad = "'.$_SESSION["buscar"].'" ';
    $result = mysqli_query($conn, $search_list);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        $buscar = $row["ciudad"];
            echo"
            <p> Ingrese los datos que desee cambiar</p>
            <form method='POST' name='FormAlta'>
                <table width='225'>
                    <tr>
                        <td>Ciudad: </td>
                        <td> <input type='text' name='Ciudad'>
                    </tr>
                    <tr>
                        <td> Pais:</Td>
                        <td> <input type='text' name='Pais'> </td>
                    </tr>
                    <tr>
                        <td> Habitantes: </td>
                        <td> <input type='text' name='Habitantes'></td>
                    </tr>
                    <tr>
                        <td> Superficie: </td>
                        <td> <input type='text' name='Superficie'> </td>
                    </tr>
                    <tr>
                        <td> tieneMetro: </td>
                        <td> <input type='radio' name='tieneMetro' value='1' id='SI'><label for='SI'>Si</label><input type='radio' name='tieneMetro' value='0' id='No'><label for='No'>No</label></td>
                    </tr>
                    <tr>
                        <td colspan='2' align='center'> <input type='submit' name='Agregar' value='Agregar'>
                        <p><a href='home.html'>Volver al menu; del ABML</a></p>
                        </td>
                    </tr>
                </table>
            </form>
            ";
            if(isset($_POST["Agregar"])){
                $buscar = $_SESSION["buscar"];
                $ciudad = $_POST["Ciudad"];
                $pais = $_POST["Pais"];
                $habitan = $_POST["Habitantes"];
                $super = $_POST["Superficies"];
                $tiene = $_POST["tieneMetro"];
                $sql = "UPDATE ciudades SET ciudad = '$ciudad',  pais = '$pais', habitantes = '$habitan', superficie = '$super', 
                tieneMetro = '$tiene' WHERE ciudad = '$buscar'";
                mysqli_query($conn, $sql);
                echo"Actualizado exitosamente";
            }
    }
    elseif(isset($_POST["Agregar"])){
        $buscar = $_SESSION["buscar"];
        $ciudad = $_POST["Ciudad"];
        $pais = $_POST["Pais"];
        $habitan = $_POST["Habitantes"];
        $super = $_POST["Superficies"];
        $tiene = $_POST["tieneMetro"];
        $sql = "UPDATE ciudades SET ciudad = '$ciudad',  pais = '$pais', habitantes = '$habitan', superficie = '$super', 
                tieneMetro = '$tiene' WHERE ciudad = '$buscar";
                mysqli_query($conn, $sql);
                echo"Actualizado exitosamente";
    }
    else{
        echo "No existe dicha ciudad";
    }
?>