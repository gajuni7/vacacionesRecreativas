<?php
require_once 'class.actividad.php';
require_once 'class.conexion.php';
include_once 'admin.dbconfig.php';
  if(!$admin->is_loggedin())
  {
   $admin->redirect('index.admin.php');
  }
  $admin_id = $_SESSION['admin_session'];
  $stmt = $DB_con->prepare("SELECT * FROM administradores WHERE admin_id=:admin_id");
  $stmt->execute(array(":admin_id"=>$admin_id));
  $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

    $con = new Conexion();
    $cons = $con->prepare("SELECT COUNT(*) FROM articulos ");
    $cons ->execute();
    $row=$cons->fetch(PDO::FETCH_ASSOC);
    $tam= intVal($row['COUNT(*)']);


function yaExiste($descrip){
try{
        $conexion = new Conexion();
            $consulta = $conexion->prepare("SELECT act_descripcion FROM actividades WHERE act_descripcion=:descrip");
            $consulta ->execute(array(':descrip'=>$descrip));
            $row=$consulta->fetch(PDO::FETCH_ASSOC);

        if($row['act_descripcion']==$descrip) {
            return true;
        }else{
            return false;
        }
    }catch(PDOException $e){
           echo $e->getMessage();
       }    
}     


if(isset($_POST['btn-registrar'])){
   $descrip = trim($_POST['txt_descrip']);
   $lugar = trim($_POST['txt_lugar']); 
 
  if(!yaExiste($descrip)){  

        $actividad = new Actividad($descrip,$lugar);

      if($actividad->guardar()){
         $actividad->redirect('admin.actividades.php?joined');

          for ($i=0; $i <=$tam+1 ; $i++) { 

            if(isset($_POST[''.$i])){
                
               $articulo = trim($_POST[''.$i]);
                $cons = $con->prepare('INSERT INTO '.'actividades_articulos'.
                 '(act_descripcion, art_nombre) VALUES(:descripcion, :articulo)');
                $cons->bindParam(':descripcion', $descrip);
                $cons->bindParam(':articulo', $articulo);
                $cons->execute();
            }
          }
        } 
  } 
  else{
            $error[] = "!Lo sentimos la actividad <b>".$descrip."</b> ya existe!";
      } 
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>vacaciones recreativas</title> 
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/actividadStyle.css">
  <link rel="icon"  href="img/icon.png">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
  <div class="container-fluid">
    <div class="row top">
      <div class="col-md-6">
        <h1>Vacaciones recreativas
            <a href="admin.articulos.php">
            <img src="img/articulo.png" title="articulos" alt="articulos" class="menu"></a>
            <a href="admin.horario.php">
            <img src="img/tiempo.png" title="horarios" alt="horarios" class="menu"><a href=""></a>
            <a href="admin.reporte.php">
            <img src="img/reporte.png" title="reporte" alt="actividades" class="menu"></a>
        </h1>    
      </div>
      <div class="col-md-5 text-right user">
        <h4 >Bienvenido  -->
          <img src="img/admin.png" alt="Avatar" title="<?php print($userRow['admin_name']);?>" class="avatar">
           <b><?php print($userRow['admin_name']); ?></b> <--  
        </h4> 
      </div>
      <div class="col-md-1 text-left logout">
      <a href="admin.logout.php?logout=true"><img src="img/logout.png" title="Cerrar sesion" class="logout"></a>
      </div>

    </div>
  <div class="row form_usuario reg">
    <div class="col-md-8 text-center">
    <form method="post">
        <div class="imgcontainer">
           <img src="img/actividad.png" alt="Avatar" class="avatar">
        </div>
         <h2>Registra una Actividad</h2>
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
                       <i class="glyphicon glyphicon-log-in"></i>
                       Registrado exitosamente 
                   </div></center>
                <?php
              }
            ?>
            <div class="row ">
              <div class="col-md-12 text-center">
                  <input type="text" placeholder="Digite la descripcion" id="descripcion" name="txt_descrip" class="descrip" 
                  value="<?php if(isset($error)){echo $descrip;}?>" required>
              </div>   
                  <div class="col-md-12 text-center">
                      <input type="text" placeholder="Digite el lugar" name="txt_lugar" class="descrip" required>
                  </div>
          </div>      
                  
        </div>
    

    </div>
        <div class="col-md-4 text-left select">
              <h5>SELECCIONA LOS ARTICULOS</h5>
              <?php
                    require_once 'class.conexion.php';
                      $conexion = new Conexion();
                        $consulta = $conexion->prepare("SELECT art_nombre,art_id FROM articulos");
                        $consulta ->execute(array(':nombre'));
                            
                while($row=$consulta->fetch(PDO::FETCH_ASSOC)){
                   echo '<input type="checkbox" value="'.$row["art_nombre"].
                   '"name="'.$row["art_id"].'">'.' '.$row["art_nombre"].'<br>';
                   
                }
              ?>
            </div>

           <div class="col-md-12 text-center reg">
                    <button class="regist" type="submit" name="btn-registrar">
                    Registrar</button>
                  </div>
              <div class="col-md-12 text-center">
                <button type="button" class="cancelbtn">Cancelar</button>
              </div> 
      </form>         
  </div>  

</body>
</html>