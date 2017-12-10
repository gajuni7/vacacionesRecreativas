<?php
  require_once 'class.conexion.php';
  require_once 'class.actividad.php';
  include_once 'admin.dbconfig.php';
  if(!$admin->is_loggedin())
  {
   $admin->redirect('index.admin.php');
  }
  $admin_id = $_SESSION['admin_session'];
  $stmt = $DB_con->prepare("SELECT * FROM administradores WHERE admin_id=:admin_id");
  $stmt->execute(array(":admin_id"=>$admin_id));
  $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
  
try{
  if(isset($_POST['btn-terminar'])){ 
    $descripcion = trim($_POST['actividades']);
    $cupo = trim($_POST['cupo']);
    echo $cupo;
    $fecha = trim($_POST['fecha']);
    $hora = trim($_POST['hora']);
  

        $conexion =  new Conexion();
        $consul = $conexion->prepare("INSERT INTO act_fechahora(act_fecha,              act_hora,act_descripcion,act_cupo) 
             VALUES(:fecha,:hora,:descripcion,:cupo)");

            $consul->bindParam(':fecha', $fecha);
            $consul->bindParam(':hora', $hora);
            $consul->bindParam(':descripcion',$descripcion);
            $consul->bindParam(':cupo', $cupo);
            $consul->execute();
            header("Location: admin.horario.php?joined");
     }       
    }catch(PDOException $e){
           echo $e->getMessage();
}         
   
?>

<!DOCTYPE html>
<html>
<head>
  <title>vacaciones recreativas</title> 
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/horarioStyle.css">
  <link rel="icon"  href="img/icon.png">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script >
</script>

</head>
<body>
  <div class="container-fluid">
    <div class="row top">
      <div class="col-md-6">
        <h1>Vacaciones recreativas
            <a href="admin.articulos.php">
            <img src="img/articulo.png" title="articulos" alt="articulos" class="menu"></a>
            <a href="admin.actividades.php">
            <img src="img/actividad.png" title="actividades" alt="actividades" class="menu"></a>
            <a href="admin.reporte.php">
            <img src="img/reporte.png" title="reporte" alt="actividades" class="menu"></a>
        </h1>    
      </div>
      <div class="col-md-5 text-right user">
        <h4 >Bienvenido  -->
          <img src="img/admin.png" alt="Avatar" title="<?php print($userRow['admin_name']);?>" id="admin">
           <b><?php print($userRow['admin_name']); ?></b> <--  
        </h4> 
      </div>
      <div class="col-md-1 text-left logout">
      <a href="admin.logout.php?logout=true"><img src="img/logout.png" title="Cerrar sesion" class="logout"></a>
      </div>
  <script>
      $( function() {
          $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
        } );

  </script>
    </div>
  <div class="row form_usuario reg">
    <div class="col-md-12 text-center ">
    <form method="post">
        <div class="imgcontainer">
           <img src="img/tiempo.png" alt="Avatar" title="horario" class="avatar">
        </div><br>
         <h2>Selecciona el horario</h2>
        <div class="container">
           

            <?php
              if(isset($error))
              {
                foreach($error as $error)
                {
                   ?>
                     <center><div class="alert alert-danger error">
                        <i class="glyphicon glyphicon-warning-sign"></i><?php echo $error; ?>
                     </div></center>
                 <?php
                }
              }
              else if(isset($_GET['joined']))
              {
                 ?>
                    <center><div class="alert alert-info error">
                       <i class="glyphicon glyphicon-log-in"></i>Registrado exitosamente 
                   </div></center>
                <?php
              }
            ?>
            <div class="row ">
              <div class="col-md-12 text-center">
                <select name="actividades" class="descrip">
                  <?php  
                      require_once 'class.conexion.php';
                       //todas las actividades de la BD en un combobox 
                      $conexion = new Conexion();
                      $consulta = $conexion->prepare("SELECT act_descripcion,act_id FROM actividades");
                      $consulta ->execute(array(':descripcion'));
                 
                  while($row=$consulta->fetch(PDO::FETCH_ASSOC)){

                  echo '<option name="'.$row["act_id"].'"value="'.$row["act_descripcion"].'">'.$row["act_descripcion"].'</option>';

                    }
                  ?>  
                </select>
              </div>   
                  <div class="col-md-12 text-center">
                      <input type="text" placeholder="Fecha" id="datepicker" 
                      name="fecha" class="descrip" required>
                  </div>
                  <div class="col-md-12 text-center">
                      <input type="number" placeholder="Cupo maximo"  name="cupo" 
                      class="descrip" required>
                  </div>
                  <div class="col-md-6 text-right x">
                      <h5>Escoja la hora de la actividad</h5>
                  </div>
                  <div class="col-md-6 text-left">
                      <input type="time" name="hora" id="hora" class="descrip" step="2" value="00:00:00" required>
                   </div>     
          </div>      
                  
        </div>
    
    </div>
             
            <div class="col-md-12 text-center">
                    <button class="regist" type="submit" name="btn-terminar">Terminado</button>
                  </div>
              <div class="col-md-12 text-center">
                <button type="button" class="cancelbtn">Cancelar</button>
                  </div> 
    </form>
  </div>  

</body>
</html>