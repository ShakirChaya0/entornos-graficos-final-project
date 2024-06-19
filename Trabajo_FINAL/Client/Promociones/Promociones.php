<?php
  ob_start();
  session_start();
  function mostrarpromociones(){
    include("../../database.php");
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fecha_actual = date("Y-m-d");
    $search_usu = 'SELECT * FROM usuarios WHERE codUsuario = "'.$_SESSION["codUsuario"].'"';
    $result_usu = mysqli_query($conn, $search_usu);
    $row_usu = mysqli_fetch_array($result_usu);
    $search_promo = 'SELECT * FROM promociones';
    $result_promo = mysqli_query($conn, $search_promo);
    if(mysqli_num_rows($result_promo) > 0){
      $consulta_filas = "SELECT COUNT(*) AS total_filas FROM uso_promociones";
      $result_filas = mysqli_query($conn, $consulta_filas);
      $filas = mysqli_fetch_array($result_filas);
      $flag = true;
      $dia_actual = date("l", strtotime("-1 day"));
      $semana = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
      while($row_promo = mysqli_fetch_assoc($result_promo)){
        $search_local = 'SELECT * FROM locales WHERE codLocal = "'.$row_promo["codLocal"].'"';
        $result_local = mysqli_query($conn, $search_local);
        $row_local = mysqli_fetch_array($result_local);
        $position = array_search($dia_actual, $semana);
        $dias_disponibles = str_split($row_promo["diasSemana"]);
        //FILTRADO POR FECHAS:
        if($row_promo["fechaDesdePromo"] <= $fecha_actual && $row_promo["fechaHastaPromo"] >= $fecha_actual && $row_promo["estadoPromo"] == "aprobada" && $dias_disponibles[$position] == "1"){
          //FILTRADO POR PROMOCIONES USADAS
          if($filas["total_filas"] > 0){
            $search_usopromo = 'SELECT * FROM uso_promociones WHERE codCliente = "'.$row_usu["codUsuario"].'"';
            $result_usoPromo = mysqli_query($conn, $search_usopromo);
            while($row_usoPromo = mysqli_fetch_assoc($result_usoPromo)){
                if($row_usoPromo == null){
                    $row_usoPromo["codPromo"] = "0";
                }
                if($row_usoPromo["codPromo"] == $row_promo["codPromo"] && strtolower($row_usoPromo["estadoUsoPromo"]) == "enviada"){
                  echo "
                    <div class='container container_usada'>
                      <div class ='local_data'> 
                        {$row_promo['textoPromo']} 
                      </div>
                      <div class = 'div-content base-div'>
                        <p class = 'prom_usada'> {$row_local['nombreLocal']}</p>
                      </div>
                      <div class = 'div-content hover-div'>
                        <div class='Promocion_usada '>Enviada</div>
                      </div>      
                    </div>";
                    $flag = false;
                  break;
                }
                elseif($row_usoPromo["codPromo"] == $row_promo["codPromo"] && strtolower($row_usoPromo["estadoUsoPromo"]) == "aprobada"){
                  echo "
                    <div class='container container_aprobado'>
                      <div class ='local_data'> 
                         {$row_promo['textoPromo']} 
                      </div>
                      <div class = 'div-content base-div'>
                        <p class = 'prom_aprobado'> {$row_local['nombreLocal']}</p>
                      </div>
                      <div class = 'div-content hover-div'>
                        <div class='Promocion_aprobada '>Usada</div>
                      </div>      
                    </div>";
                  $flag = false;
                  break;
                }

                elseif($row_usoPromo["codPromo"] == "0"){
                  $flag = false;
                  break;
                }
              }
            if($flag){
              if(strtolower($_SESSION["categoriaCliente"]) == "premium"){
                  echo "
                  <div class='container'>
                  <div class ='local_data'>  {$row_promo['textoPromo']}  </div>
                  <div class = 'div-content base-div'>
                  <p class = 'data'> {$row_local['nombreLocal']}</p>
                  </div>
                  <div class = 'div-content hover-div'>
                  <form method= 'post' action='Promociones.php'>
                  <input name='{$row_promo['codPromo']}' type='submit' class='link_promociones' value='Usar'>
                  </form>
                  </div>
                  </div>";
                  if(!empty($_POST["{$row_promo['codPromo']}"]) && $_POST["{$row_promo['codPromo']}"] == "Usar") {
                    $cantProm = $row_usu["cantidadPromo"] + 1;
                    $sql = "UPDATE usuarios SET cantidadPromo = '$cantProm' WHERE codUsuario = {$row_usu['codUsuario']}";
                    mysqli_query($conn, $sql);
                    if($cantProm > 3 && $cantProm < 9){
                      $sqli = "UPDATE usuarios SET categoriaCliente = 'Medium' WHERE codUsuario = {$row_usu['codUsuario']}";
                      mysqli_query($conn, $sqli);
                    }
                    elseif($cantProm > 9){
                      $sqlia = "UPDATE usuarios SET categoriaCliente = 'Premium' WHERE codUsuario = {$row_usu['codUsuario']}";
                      mysqli_query($conn, $sqlia);
                    }
                    $add_prom = "INSERT INTO uso_promociones (codCliente, codPromo, fechaUsoPromo, estadoUsoPromo, codLocal) VALUES ({$row_usu['codUsuario']}, {$row_promo['codPromo']}, '$fecha_actual', 'enviada', {$row_promo['codLocal']})";
                    mysqli_query($conn, $add_prom);
                    $_POST = array();
                    header("LOCATION: Promociones.php"); 
                  }
                }
                elseif(strtolower($_SESSION["categoriaCliente"]) == "medium"){
                  if($row_promo["categoriaCliente"] != "premium"){
                    echo "
                    <div class='container'>
                    <div class ='local_data'>  {$row_promo['textoPromo']}  </div>
                    <div class = 'div-content base-div'>
                    <p class = 'data'> {$row_local['nombreLocal']}</p>
                    </div>
                    <div class = 'div-content hover-div'>
                    <form method= 'post' action='Promociones.php'>
                    <input name='{$row_promo['codPromo']}' type='submit' class='link_promociones' value='Usar'>
                    </form>
                    </div>
                    </div>";
                    if(!empty($_POST["{$row_promo['codPromo']}"]) && $_POST["{$row_promo['codPromo']}"] == "Usar") {
                      $cantProm = $row_usu["cantidadPromo"] + 1;
                      $sql = "UPDATE usuarios SET cantidadPromo = '$cantProm' WHERE codUsuario = {$row_usu['codUsuario']}";
                      mysqli_query($conn, $sql);
                      if($cantProm > 3 && $cantProm < 9){
                        $sqli = "UPDATE usuarios SET categoriaCliente = 'Medium' WHERE codUsuario = {$row_usu['codUsuario']}";
                        mysqli_query($conn, $sqli);
                      }
                      elseif($cantProm > 9){
                        $sqlia = "UPDATE usuarios SET categoriaCliente = 'Premium' WHERE codUsuario = {$row_usu['codUsuario']}";
                        mysqli_query($conn, $sqlia);
                      }
                      $add_prom = "INSERT INTO uso_promociones (codCliente, codPromo, fechaUsoPromo, estadoUsoPromo, codLocal) VALUES ({$row_usu['codUsuario']}, {$row_promo['codPromo']}, '$fecha_actual', 'enviada', {$row_promo['codLocal']})";
                      mysqli_query($conn, $add_prom);
                      $_POST = array();
                      header("LOCATION: Promociones.php");  
                      }
                }
              }
            elseif(strtolower($_SESSION["categoriaCliente"]) == "inicial"){
              if(strtolower($row_promo["categoriaCliente"]) == "inicial"){
                  echo "
                    <div class='container'>
                    <div class ='local_data'>  {$row_promo['textoPromo']}  </div>
                    <div class = 'div-content base-div'>
                    <p class = 'data'> {$row_local['nombreLocal']}</p>
                    </div>
                    <div class = 'div-content hover-div'>
                    <form method= 'post' action='Promociones.php'>
                    <input name='{$row_promo['codPromo']}' type='submit' class='link_promociones' value='Usar'>
                    </form>
                    </div>
                    </div>";
                    if(!empty($_POST["{$row_promo['codPromo']}"]) && $_POST["{$row_promo['codPromo']}"] == "Usar") {
                      $cantProm = $row_usu["cantidadPromo"] + 1;
                      $sql = "UPDATE usuarios SET cantidadPromo = '$cantProm' WHERE codUsuario = {$row_usu['codUsuario']}";
                      mysqli_query($conn, $sql);
                      if($cantProm > 3 && $cantProm < 9){
                        $sqli = "UPDATE usuarios SET categoriaCliente = 'Medium' WHERE codUsuario = {$row_usu['codUsuario']}";
                        mysqli_query($conn, $sqli);
                      }
                      elseif($cantProm > 9){
                        $sqlia = "UPDATE usuarios SET categoriaCliente = 'Premium' WHERE codUsuario = {$row_usu['codUsuario']}";
                        mysqli_query($conn, $sqlia);
                      }
                      $add_prom = "INSERT INTO uso_promociones (codCliente, codPromo, fechaUsoPromo, estadoUsoPromo, codLocal) VALUES ({$row_usu['codUsuario']}, {$row_promo['codPromo']}, '$fecha_actual', 'enviada', {$row_promo['codLocal']})";
                      mysqli_query($conn, $add_prom);
                      $_POST = array();
                      header("LOCATION: Promociones.php");  
                      }
              }
            }
            }
            else{
              $flag = true;
            }
          }
          else{
              if(strtolower($_SESSION["categoriaCliente"]) == "premium"){
                echo "
                <div class='container'>
                <div class ='local_data'>  {$row_promo['textoPromo']}  </div>
                <div class = 'div-content base-div'>
                <p class = 'data'> {$row_local['nombreLocal']}</p>
                </div>
                <div class = 'div-content hover-div'>
                <form method= 'post' action='Promociones.php'>
                <input name='{$row_promo['codPromo']}' type='submit' class='link_promociones' value='Usar'>
                </form>
                </div>
                </div>";
              if(!empty($_POST["{$row_promo['codPromo']}"]) && $_POST["{$row_promo['codPromo']}"] == "Usar") {
                $cantProm = $row_usu["cantidadPromo"] + 1;
                $sql = "UPDATE usuarios SET cantidadPromo = '$cantProm' WHERE codUsuario = {$row_usu['codUsuario']}";
                mysqli_query($conn, $sql);
                if($cantProm > 3 && $cantProm < 9){
                  $sqli = "UPDATE usuarios SET categoriaCliente = 'Medium' WHERE codUsuario = {$row_usu['codUsuario']}";
                  mysqli_query($conn, $sqli);
                }
                elseif($cantProm > 9){
                  $sqlia = "UPDATE usuarios SET categoriaCliente = 'Premium' WHERE codUsuario = {$row_usu['codUsuario']}";
                  mysqli_query($conn, $sqlia);
                }
                $add_prom = "INSERT INTO uso_promociones (codCliente, codPromo, fechaUsoPromo, estadoUsoPromo, codLocal) VALUES ({$row_usu['codUsuario']}, {$row_promo['codPromo']}, '$fecha_actual', 'enviada', {$row_promo['codLocal']})";
                mysqli_query($conn, $add_prom);
                $_POST = array();
                header("LOCATION: Promociones.php");  
              }
            }
            elseif(strtolower($_SESSION["categoriaCliente"]) == "medium"){
              if($row_promo["categoriaCliente"] != "premium"){
                echo "
                <div class='container'>
                <div class ='local_data'>  {$row_promo['textoPromo']}  </div>
                <div class = 'div-content base-div'>
                <p class = 'data'> {$row_local['nombreLocal']}</p>
                </div>
                <div class = 'div-content hover-div'>
                <form method= 'post' action='Promociones.php'>
                <input name='{$row_promo['codPromo']}' type='submit' class='link_promociones' value='Usar'>
                </form>
                </div>
                </div>";
                if(!empty($_POST["{$row_promo['codPromo']}"]) && $_POST["{$row_promo['codPromo']}"] == "Usar") {
                  $cantProm = $row_usu["cantidadPromo"] + 1;
                  $sql = "UPDATE usuarios SET cantidadPromo = '$cantProm' WHERE codUsuario = {$row_usu['codUsuario']}";
                  mysqli_query($conn, $sql);
                  if($cantProm > 3 && $cantProm < 9){
                    $sqli = "UPDATE usuarios SET categoriaCliente = 'Medium' WHERE codUsuario = {$row_usu['codUsuario']}";
                    mysqli_query($conn, $sqli);
                  }
                  elseif($cantProm > 9){
                    $sqlia = "UPDATE usuarios SET categoriaCliente = 'Premium' WHERE codUsuario = {$row_usu['codUsuario']}";
                    mysqli_query($conn, $sqlia);
                  }
                  $add_prom = "INSERT INTO uso_promociones (codCliente, codPromo, fechaUsoPromo, estadoUsoPromo, codLocal) VALUES ({$row_usu['codUsuario']}, {$row_promo['codPromo']}, '$fecha_actual', 'enviada', {$row_promo['codLocal']})";
                  mysqli_query($conn, $add_prom);
                  $_POST = array();
                  header("LOCATION: Promociones.php");  
                }
              }
            }
            elseif(strtolower($_SESSION["categoriaCliente"]) == "inicial"){
              if(strtolower($row_promo["categoriaCliente"]) == "inicial"){
                echo "
                <div class='container'>
                <div class ='local_data'>  {$row_promo['textoPromo']}  </div>
                <div class = 'div-content base-div'>
                <p class = 'data'> {$row_local['nombreLocal']}</p>
                </div>
                <div class = 'div-content hover-div'>
                <form method= 'post' action='Promociones.php'>
                <input name='{$row_promo['codPromo']}' type='submit' class='link_promociones' value='Usar'>
                </form>
                </div>
                </div>";
                if(!empty($_POST["{$row_promo['codPromo']}"]) && $_POST["{$row_promo['codPromo']}"] == "Usar") {
                  $cantProm = $row_usu["cantidadPromo"] + 1;
                  $sql = "UPDATE usuarios SET cantidadPromo = '$cantProm' WHERE codUsuario = {$row_usu['codUsuario']}";
                  mysqli_query($conn, $sql);
                  if($cantProm > 3 && $cantProm < 9){
                    $sqli = "UPDATE usuarios SET categoriaCliente = 'Medium' WHERE codUsuario = {$row_usu['codUsuario']}";
                    mysqli_query($conn, $sqli);
                  }
                  elseif($cantProm > 9){
                    $sqlia = "UPDATE usuarios SET categoriaCliente = 'Premium' WHERE codUsuario = {$row_usu['codUsuario']}";
                    mysqli_query($conn, $sqlia);
                  }
                  $add_prom = "INSERT INTO uso_promociones (codCliente, codPromo, fechaUsoPromo, estadoUsoPromo, codLocal) VALUES ({$row_usu['codUsuario']}, {$row_promo['codPromo']}, '$fecha_actual', 'enviada', {$row_promo['codLocal']})";
                  mysqli_query($conn, $add_prom);
                  $_POST = array();
                  header("LOCATION: Promociones.php");  
                }
              }
            }
          }
        } 
      }
    }
    else{
      echo"
              <div class = 'error_box'>
                <p class = 'error'>No hay promociones todavia</p>
              </div>
            
            ";
    }
  } 

  function mostrarpromociones_NoUsadas(){
    include("../../database.php");
    $fecha_actual = date("Y-m-d");
    $search_usu = 'SELECT * FROM usuarios WHERE codUsuario = "'.$_SESSION["codUsuario"].'"';
    $result_usu = mysqli_query($conn, $search_usu);
    $row_usu = mysqli_fetch_array($result_usu);
    $search_promo = 'SELECT * FROM promociones WHERE categoriaCliente = "'.$_SESSION["categoriaCliente"].'"';
    $result_promo = mysqli_query($conn, $search_promo);
    if(mysqli_num_rows($result_promo) > 0){
      $consulta_filas = "SELECT COUNT(*) AS total_filas FROM uso_promociones";
      $result_filas = mysqli_query($conn, $consulta_filas);
      $filas = mysqli_fetch_array($result_filas);
      $flag = true;
      $dia_actual = date("l", strtotime("-1 day"));
      $semana = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
      while($row_promo = mysqli_fetch_assoc($result_promo)){
        $search_local = 'SELECT * FROM locales WHERE codLocal = "'.$row_promo["codLocal"].'"';
        $result_local = mysqli_query($conn, $search_local);
        $row_local = mysqli_fetch_array($result_local);
        $position = array_search($dia_actual, $semana);
        $dias_disponibles = str_split($row_promo["diasSemana"]);
        //FILTRADO POR FECHAS:
        if($row_promo["fechaDesdePromo"] < $fecha_actual && $row_promo["fechaHastaPromo"] >= $fecha_actual && $row_promo["estadoPromo"] == "aceptada" && $dias_disponibles[$position] == "1"){
          //FILTRADO POR PROMOCIONES USADAS
          if($filas["total_filas"] > 0){
            $search_usopromo = 'SELECT * FROM uso_promociones WHERE codCliente = "'.$row_usu["codUsuario"].'"';
            $result_usoPromo = mysqli_query($conn, $search_usopromo);
            while($row_usoPromo = mysqli_fetch_assoc($result_usoPromo)){
                if($row_usoPromo == null){
                    $row_usoPromo["codPromo"] = "0";
                }
                if($row_usoPromo["codPromo"] == $row_promo["codPromo"]){
                  $flag = false;
                  break;
                }
                elseif($row_usoPromo["codPromo"] == "0"){
                  $flag = false;
                  break;
                }
              }
            if($flag){
              echo "
                <div class='container'>
                <div class ='local_data'>  {$row_promo['textoPromo']}  </div>
                <div class = 'div-content base-div'>
                <p class = 'data'> {$row_local['nombreLocal']}</p>
                </div>
                <div class = 'div-content hover-div'>
                <form method= 'post' action='Promociones.php'>
                <input name='{$row_promo['codPromo']}' type='submit' class='link_promociones' value='Usar'>
                </form>
                </div>
                </div>";
                if(!empty($_POST["{$row_promo['codPromo']}"]) && $_POST["{$row_promo['codPromo']}"] == "Usar") {
                  $cantProm = $row_usu["cantidadPromo"] + 1;
                  $sql = "UPDATE usuarios SET cantidadPromo = '$cantProm' WHERE codUsuario = {$row_usu['codUsuario']}";
                  mysqli_query($conn, $sql);
                  if($cantProm > 3 && $cantProm < 9){
                    $sqli = "UPDATE usuarios SET categoriaCliente = 'Medium' WHERE codUsuario = {$row_usu['codUsuario']}";
                    mysqli_query($conn, $sqli);
                  }
                  elseif($cantProm > 9){
                    $sqlia = "UPDATE usuarios SET categoriaCliente = 'Premium' WHERE codUsuario = {$row_usu['codUsuario']}";
                    mysqli_query($conn, $sqlia);
                  }
                  $add_prom = "INSERT INTO uso_promociones (codCliente, codPromo, fechaUsoPromo, estadoUsoPromo, codLocal) VALUES ({$row_usu['codUsuario']}, {$row_promo['codPromo']}, '$fecha_actual', 'enviada', {$row_promo['codLocal']})";
                  mysqli_query($conn, $add_prom);
                  $_POST = array();
                  header("LOCATION: Promociones.php"); 
                }
            }
            else{
              $flag = true;
            }
          }
          else{
                echo "
                <div class='container'>
                <div class ='local_data'>  {$row_promo['textoPromo']}  </div>
                <div class = 'div-content base-div'>
                <p class = 'data'> {$row_local['nombreLocal']}</p>
                </div>
                <div class = 'div-content hover-div'>
                <form method= 'post' action='Promociones.php'>
                <input name='{$row_promo['codPromo']}' type='submit' class='link_promociones' value='Usar'>
                </form>
                </div>
                </div>";
              if(!empty($_POST["{$row_promo['codPromo']}"]) && $_POST["{$row_promo['codPromo']}"] == "Usar") {
                $cantProm = $row_usu["cantidadPromo"] + 1;
                $sql = "UPDATE usuarios SET cantidadPromo = '$cantProm' WHERE codUsuario = {$row_usu['codUsuario']}";
                mysqli_query($conn, $sql);
                if($cantProm > 3 && $cantProm < 9){
                  $sqli = "UPDATE usuarios SET categoriaCliente = 'Medium' WHERE codUsuario = {$row_usu['codUsuario']}";
                  mysqli_query($conn, $sqli);
                }
                elseif($cantProm > 9){
                  $sqlia = "UPDATE usuarios SET categoriaCliente = 'Premium' WHERE codUsuario = {$row_usu['codUsuario']}";
                  mysqli_query($conn, $sqlia);
                }
                $add_prom = "INSERT INTO uso_promociones (codCliente, codPromo, fechaUsoPromo, estadoUsoPromo, codLocal) VALUES ({$row_usu['codUsuario']}, {$row_promo['codPromo']}, '$fecha_actual', 'enviada', {$row_promo['codLocal']})";
                mysqli_query($conn, $add_prom);
                $_POST = array();
                header("LOCATION: Promociones.php");  
              }
          }
        } 
      }
    }
    else{
      echo"
              <div class = 'error_box'>
                <p class = 'error'>No hay promociones todavia</p>
              </div>
            
            ";
    }
  } 

  function mostrarpromociones_usadas(){
    include("../../database.php");
    $fecha_actual = date("Y-m-d");
    $search_usu = 'SELECT * FROM usuarios WHERE codUsuario = "'.$_SESSION["codUsuario"].'"';
    $result_usu = mysqli_query($conn, $search_usu);
    $row_usu = mysqli_fetch_array($result_usu);
    $search_promo = 'SELECT * FROM promociones WHERE categoriaCliente = "'.$_SESSION["categoriaCliente"].'"';
    $result_promo = mysqli_query($conn, $search_promo);
    if(mysqli_num_rows($result_promo) > 0){
      $consulta_filas = "SELECT COUNT(*) AS total_filas FROM uso_promociones";
      $result_filas = mysqli_query($conn, $consulta_filas);
      $filas = mysqli_fetch_array($result_filas);
      $dia_actual = date("l", strtotime("-1 day"));
      $semana = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
      while($row_promo = mysqli_fetch_assoc($result_promo)){
        $search_local = 'SELECT * FROM locales WHERE codLocal = "'.$row_promo["codLocal"].'"';
        $result_local = mysqli_query($conn, $search_local);
        $row_local = mysqli_fetch_array($result_local);
        $position = array_search($dia_actual, $semana);
        $dias_disponibles = str_split($row_promo["diasSemana"]);
        //FILTRADO POR FECHAS:
        if($row_promo["fechaDesdePromo"] < $fecha_actual && $row_promo["fechaHastaPromo"] >= $fecha_actual && $row_promo["estadoPromo"] == "aceptada" && $dias_disponibles[$position] == "1"){
          //FILTRADO POR PROMOCIONES USADAS
          if($filas["total_filas"] > 0){
            $search_usopromo = 'SELECT * FROM uso_promociones WHERE codCliente = "'.$row_usu["codUsuario"].'"';
            $result_usoPromo = mysqli_query($conn, $search_usopromo);
            while($row_usoPromo = mysqli_fetch_assoc($result_usoPromo)){
                if($row_usoPromo["codPromo"] == $row_promo["codPromo"] && strtolower($row_usoPromo["estadoUsoPromo"]) == "aceptada"){
                  echo "
                    <div class='container container_aprobado'>
                      <div class ='local_data'> 
                         {$row_promo['textoPromo']} 
                      </div>
                      <div class = 'div-content base-div'>
                        <p class = 'prom_aprobado'> {$row_local['nombreLocal']}</p>
                      </div>
                      <div class = 'div-content hover-div'>
                        <div class='Promocion_aprobada '>Usada</div>
                      </div>      
                    </div>";
                  break;
                }
              }
          }
        } 
      }
    }
    else{
      echo"
              <div class = 'error_box'>
                <p class = 'error'>No hay promociones todavia</p>
              </div>
            
            ";
    }
  }

  function mostrarpromociones_NombreLocal($busqueda){
    include("../../database.php");
    $fecha_actual = date("Y-m-d");
    $search_usu = 'SELECT * FROM usuarios WHERE codUsuario = "'.$_SESSION["codUsuario"].'"';
    $result_usu = mysqli_query($conn, $search_usu);
    $row_usu = mysqli_fetch_array($result_usu);
    $search_promo = 'SELECT * FROM promociones WHERE categoriaCliente = "'.$_SESSION["categoriaCliente"].'"';
    $result_promo = mysqli_query($conn, $search_promo);
    if(mysqli_num_rows($result_promo) > 0){
      $consulta_filas = "SELECT COUNT(*) AS total_filas FROM uso_promociones";
      $result_filas = mysqli_query($conn, $consulta_filas);
      $filas = mysqli_fetch_array($result_filas);
      $flag = true;
      $bandera = true;
      $dia_actual = date("l", strtotime("-1 day"));
      $semana = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
      while($row_promo = mysqli_fetch_assoc($result_promo)){
        $search_local = 'SELECT * FROM locales WHERE nombreLocal = "'.$busqueda.'"';
        $result_local = mysqli_query($conn, $search_local);
        $row_local = mysqli_fetch_array($result_local);
        if($row_local == null){
          $row_local["codLocal"] = 0;
        }
        $position = array_search($dia_actual, $semana);
        $dias_disponibles = str_split($row_promo["diasSemana"]);
        //FILTRADO POR FECHAS:
        if($row_promo["fechaDesdePromo"] < $fecha_actual && $row_promo["fechaHastaPromo"] >= $fecha_actual && $row_promo["estadoPromo"] == "aceptada" && $dias_disponibles[$position] == "1" && $row_local["codLocal"] == $row_promo["codLocal"]){
          //FILTRADO POR PROMOCIONES USADAS
          $bandera = false;
          if($filas["total_filas"] > 0){
            $search_usopromo = 'SELECT * FROM uso_promociones WHERE codCliente = "'.$row_usu["codUsuario"].'"';
            $result_usoPromo = mysqli_query($conn, $search_usopromo);
            if($row_local != null){
              while($row_usoPromo = mysqli_fetch_assoc($result_usoPromo)){
                  if($row_usoPromo["codPromo"] == $row_promo["codPromo"] && strtolower($row_usoPromo["estadoUsoPromo"] == "enviada")){
                    echo "
                      <div class='container container_usada'>
                        <div class ='local_data'> 
                           {$row_promo['textoPromo']} 
                        </div>
                        <div class = 'div-content base-div'>
                          <p class = 'prom_usada'> {$row_local['nombreLocal']}</p>
                        </div>
                        <div class = 'div-content hover-div'>
                          <div class='Promocion_usada '>Usada</div>
                        </div>      
                      </div>";
                    $flag = false;
                    break;
                  }
                  elseif($row_usoPromo["codPromo"] == $row_promo["codPromo"] && strtolower($row_usoPromo["estadoUsoPromo"] == "aceptada")){
                    echo"
                    <div class='container container_aprobado'>
                      <div class ='local_data'> 
                         {$row_promo['textoPromo']} 
                      </div>
                      <div class = 'div-content base-div'>
                        <p class = 'prom_aprobado'> {$row_local['nombreLocal']}</p>
                      </div>
                      <div class = 'div-content hover-div'>
                        <div class='Promocion_aprobada '>Usada</div>
                      </div>      
                    </div>
                    ";
                    $flag = false;
                    break;
                  }
                }
                if($row_local["codLocal"] == $row_promo["codLocal"] && $flag){
                  echo "
                  <div class='container'>
                    <div class ='local_data'>  {$row_promo['textoPromo']}  </div>
                    <div class = 'div-content base-div'>
                      <p class = 'data'> {$row_local['nombreLocal']}</p>
                    </div>
                    <div class = 'div-content hover-div'>
                      <form method= 'post' action='Promociones.php'>
                        <input name='{$row_promo['codPromo']}' type='submit' class='link_promociones' value='Usar'>
                      </form>
                    </div>
                  </div>";
                }
            }
          }
        }
      }
      if($bandera){
        echo"
              <div class = 'error_box'>
                <p class = 'error'>No se encontro lo que buscaste</p>
              </div>
            
            ";
      }
    }
    else{
      echo"
              <div class = 'error_box'>
                <p class = 'error'>No hay promociones todavia</p>
              </div>
            
            ";
    }
  }

  function mostrarpromociones_estadoEnviada(){
    include("../../database.php");
    $fecha_actual = date("Y-m-d");
    $search_usu = 'SELECT * FROM usuarios WHERE codUsuario = "'.$_SESSION["codUsuario"].'"';
    $result_usu = mysqli_query($conn, $search_usu);
    $row_usu = mysqli_fetch_array($result_usu);
    $search_promo = 'SELECT * FROM promociones WHERE categoriaCliente = "'.$_SESSION["categoriaCliente"].'"';
    $result_promo = mysqli_query($conn, $search_promo);
    if(mysqli_num_rows($result_promo) > 0){
      $consulta_filas = "SELECT COUNT(*) AS total_filas FROM uso_promociones";
      $result_filas = mysqli_query($conn, $consulta_filas);
      $filas = mysqli_fetch_array($result_filas);
      $dia_actual = date("l", strtotime("-1 day"));
      $semana = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
      while($row_promo = mysqli_fetch_assoc($result_promo)){
        $search_local = 'SELECT * FROM locales WHERE codLocal = "'.$row_promo["codLocal"].'"';
        $result_local = mysqli_query($conn, $search_local);
        $row_local = mysqli_fetch_array($result_local);
        if($row_local == null){
          $row_local["codLocal"] = 0;
        }
        $position = array_search($dia_actual, $semana);
        $dias_disponibles = str_split($row_promo["diasSemana"]);
        //FILTRADO POR FECHAS:
        if($row_promo["fechaDesdePromo"] < $fecha_actual && $row_promo["fechaHastaPromo"] >= $fecha_actual && $row_promo["estadoPromo"] == "aceptada" && $dias_disponibles[$position] == "1" && $row_local["codLocal"] == $row_promo["codLocal"]){
          //FILTRADO POR PROMOCIONES USADAS
          if($filas["total_filas"] > 0){
            $search_usopromo = 'SELECT * FROM uso_promociones WHERE codCliente = "'.$row_usu["codUsuario"].'"';
            $result_usoPromo = mysqli_query($conn, $search_usopromo);
            if($row_local != null){
              while($row_usoPromo = mysqli_fetch_assoc($result_usoPromo)){
                  if($row_usoPromo["codPromo"] == $row_promo["codPromo"] && strtolower($row_usoPromo["estadoUsoPromo"]) == "enviada"){
                    echo "
                      <div class='container container_usada'>
                        <div class ='local_data'> 
                           {$row_promo['textoPromo']} 
                        </div>
                        <div class = 'div-content base-div'>
                          <p class = 'prom_usada'> {$row_local['nombreLocal']}</p>
                        </div>
                        <div class = 'div-content hover-div'>
                          <div class='Promocion_usada '>Usada</div>
                        </div>      
                      </div>";
                    $flag = false;
                    break;
                  }
                }
            }
          }
        }
      }
    }
    else{
      echo"
              <div class = 'error_box'>
                <p class = 'error'>No hay promociones todavia</p>
              </div>
            
            ";
    }
  }

  function mostrarpromociones_NombreLocal_usadas($busqueda){
    include("../../database.php");
    $fecha_actual = date("Y-m-d");
    $search_usu = 'SELECT * FROM usuarios WHERE codUsuario = "'.$_SESSION["codUsuario"].'"';
    $result_usu = mysqli_query($conn, $search_usu);
    $row_usu = mysqli_fetch_array($result_usu);
    $search_promo = 'SELECT * FROM promociones WHERE categoriaCliente = "'.$_SESSION["categoriaCliente"].'"';
    $result_promo = mysqli_query($conn, $search_promo);
    if(mysqli_num_rows($result_promo) > 0){
      $consulta_filas = "SELECT COUNT(*) AS total_filas FROM uso_promociones";
      $result_filas = mysqli_query($conn, $consulta_filas);
      $filas = mysqli_fetch_array($result_filas);
      $dia_actual = date("l", strtotime("-1 day"));
      $semana = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
      while($row_promo = mysqli_fetch_assoc($result_promo)){
        $search_local = 'SELECT * FROM locales WHERE codLocal = "'.$row_promo["codLocal"].'"';
        $result_local = mysqli_query($conn, $search_local);
        $row_local = mysqli_fetch_array($result_local);
        $position = array_search($dia_actual, $semana);
        $dias_disponibles = str_split($row_promo["diasSemana"]);
        //FILTRADO POR FECHAS:
        if($row_promo["fechaDesdePromo"] < $fecha_actual && $row_promo["fechaHastaPromo"] >= $fecha_actual && $row_promo["estadoPromo"] == "aceptada" && $dias_disponibles[$position] == "1" && strtolower($row_local["nombreLocal"]) == strtolower($busqueda)){
          //FILTRADO POR PROMOCIONES USADAS
          if($filas["total_filas"] > 0){
            $search_usopromo = 'SELECT * FROM uso_promociones WHERE codCliente = "'.$row_usu["codUsuario"].'"';
            $result_usoPromo = mysqli_query($conn, $search_usopromo);
            while($row_usoPromo = mysqli_fetch_assoc($result_usoPromo)){
                if($row_usoPromo["codPromo"] == $row_promo["codPromo"]){
                  echo "
                    <div class='container container_usada'>
                      <div class ='local_data'> 
                         {$row_promo['textoPromo']} 
                      </div>
                      <div class = 'div-content base-div'>
                        <p class = 'prom_usada'> {$row_local['nombreLocal']}</p>
                      </div>
                      <div class = 'div-content hover-div'>
                        <div class='Promocion_usada '>Usada</div>
                      </div>      
                    </div>";
                  break;
                }
              }
            }
          }
      }
    }
    else{
      echo"
              <div class = 'error_box'>
                <p class = 'error'>No hay promociones todavia</p>
              </div>
            
            ";
    }
  }

  function mostrar_UNR(){
    include("../../database.php");
    $fecha_actual = date("Y-m-d");
    $search_promo = "SELECT * FROM promociones";
    $result_promo = mysqli_query($conn, $search_promo);
    if(mysqli_num_rows($result_promo) > 0){
      $dia_actual = date("l", strtotime("-1 day"));
      $semana = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
      while($row_promo = mysqli_fetch_assoc($result_promo)){
        $search_local = 'SELECT * FROM locales WHERE codLocal = "'.$row_promo["codLocal"].'"';
        $result_local = mysqli_query($conn, $search_local);
        $row_local = mysqli_fetch_array($result_local);
        $position = array_search($dia_actual, $semana);
        $dias_disponibles = str_split($row_promo["diasSemana"]);
        //FILTRADO POR FECHAS:
        if($row_promo["fechaDesdePromo"] <= $fecha_actual && $row_promo["fechaHastaPromo"] >= $fecha_actual && $row_promo["estadoPromo"] == "aceptada" && $dias_disponibles[$position] == "1"){
          echo "
          <div class='container'>
          <div class ='local_data'>  {$row_promo['textoPromo']}  </div>
          <div class = 'div-content base-div'>
          <p class = 'data'> {$row_local['nombreLocal']}</p>
          </div>
          <div class = 'div-content hover-div'>
          <form method= 'post' action='Promociones.php'>
          <input name='{$row_promo['codPromo']}' type='submit' class='link_promociones' value='Usar'>
          </form>
          </div>
          </div>";
          if(!empty($_POST["{$row_promo['codPromo']}"]) && $_POST["{$row_promo['codPromo']}"] == "Usar"){
            header("LOCATION: ../../inicio_de_sesion/inicio_sesion.php");
          }
        }
      }
    }
    else{
      echo"
              <div class = 'error_box'>
                <p class = 'error'>No hay promociones todavia</p>
              </div>
            
            ";
    }
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Locales</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="Promociones.css">
  <link rel="stylesheet" href="../../Pie_De_Pagina/footer.css">
  <link rel="stylesheet" href="../../Barra_Navegacion/Bar-style.css">

</head>
<body>
  <?php 
    include("../../Barra_Navegacion/Nav-bar.php");
  ?>
  <div class="lineas_title">Promociones</div>
  <section class="section1">
    <form class="filtrado_locales" action = "<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
      <label class="search_label" for="select_parametro"><b>Búsqueda de local:</b>
        <select name="parametro" id="select_parametro" class="form-search__select">
            <option value="Todas">Todas las promociones</option>
            <option value="nombreLocal">Por nombre de local</option>
            <option value="estadoNoUsada">No usadas</option>
            <option value="estadoEnviada">Enviadas</option>
            <option value="estadoUsada">Usadas</option>
        </select>
      </label>
      <input id="lupa_local" type="text" class="busqueda_local" name="search" placeholder="¿Que es lo que busca?">
      <!--<input id="promociones_usadas" type="checkbox" name="usadas" class="checkbox_prom">-->
      <label for="enviar_busqueda" class="label_busqueda"><img class="lupa_busqueda" src="../../Imagenes-Videos/lupa.png" alt="lupa de busqueda"><input type="submit" class="lupa_input" id="enviar_busqueda" name="busqued"></label>
    </form>
  </section>
  <div class="iteracion">
    <?php  
      if($_SESSION["tipoUsuario"] != "UNR"){
        if(empty($_POST["busqued"])) {
          mostrarpromociones();
        }
        else{
          if($_POST["parametro"] == "Todas"){
              mostrarpromociones();
          }
          elseif($_POST["parametro"] == "nombreLocal"){
              mostrarpromociones_NombreLocal($_POST["search"]);
          }
          elseif($_POST["parametro"] == "estadoNoUsada"){
            mostrarpromociones_NoUsadas();
          }
          elseif($_POST["parametro"] == "estadoEnviada"){
            mostrarpromociones_estadoEnviada();
          }
          elseif($_POST["parametro"] == "estadoUsada"){
            mostrarpromociones_usadas();
          }
        }
      }
      else{
        mostrar_UNR();
      }
    ?>  
  </div>

<?php 
  include("../../Pie_De_Pagina/footer.php");
?>

</body>
<?php
  ob_end_flush();
?>