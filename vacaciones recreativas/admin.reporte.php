<?php
require_once 'class.articulo.php';
include_once 'admin.dbconfig.php';

if(!$admin->is_loggedin())
  {
   $admin->redirect('index.admin.php');
  }
  $admin_id = $_SESSION['admin_session'];
  $stmt = $DB_con->prepare("SELECT * FROM administradores WHERE admin_id=:admin_id");
  $stmt->execute(array(":admin_id"=>$admin_id));
  $adminRow=$stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <title>vacaciones recreativas</title> 
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/articuloStyle.css">
  <link rel="icon"  href="img/icon.png">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
  <div class="container-fluid">
    <div class="row top">
      <div class="col-md-6">
        <h1>Vacaciones recreativas
            <a href="admin.actividades.php">
            <img src="img/actividad.png" title="actividades" alt="actividades" 
            class="menu"></a>
            <a href="admin.horario.php">
            <img src="img/tiempo.png" title="tiempo" alt="horarios" class="menu"></a>
            <a href="admin.articulos.php">
            <img src="img/articulo.png" title="articulo" alt="horarios" class="menu"></a>
         </h1>   
      </div>
      <div class="col-md-5 text-right user">
        <h4 >Bienvenido  -->
          <img src="img/admin.png" alt="Avatar" title="<?php print($adminRow['admin_name']);?>" class="avatar">
           <b><?php print($adminRow['admin_name']); ?></b> <--  
        </h4> 
      </div>
      <div class="col-md-1 text-left logout">
      <a href="admin.logout.php?logout=true"><img src="img/logout.png" title="Cerrar sesion" class="logout"></a>
      </div>
    </div>
  <div class="row form_usuario">
    <div class="col-md-12 text-center reg">
    <form onsubmit="return false;" method="post">
        <div class="imgcontainer">
           <img src="img/reporte.png" title="reporte" alt="Avatar" class="avatar">
        </div>
         <h2>Reporte de usuarios inscritos en actividades</h2>
        <div class="container">
            <div class="row ">
              <div class="col-md-12 text-center">
              <textarea  rows="8" style="text-align:left;" id="reporte" class="descrip" readonly>
               <?php
                require_once 'class.articulo.php';  
                  $conexion = new Conexion();
              $consul = $conexion->prepare("SELECT act_descripcion,user_name,
                                          act_fecha,act_hora
                                             from users_actividades");
                        $consul ->execute();

              while($row=$consul->fetch(PDO::FETCH_ASSOC)){
              echo"- USUARIO: ".$row['user_name']." - ACTIVIDAD: ".
                      $row['act_descripcion']." - FECHA: ".$row['act_fecha'].
                      " - HORA: ".$row['act_hora']."\n";
                }    
              ?> 
              </textarea>
              </div>   
              </div>
            </div>  
              </div> 
          </div>      
                  
        </div>
    </form>

    </div>
  </div>  

</body>
</html>