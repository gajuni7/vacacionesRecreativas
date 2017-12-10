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
  $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

function yaExiste($nombre){
try{
        $conexion = new Conexion();
            $consulta = $conexion->prepare("SELECT art_nombre FROM articulos 
              WHERE art_nombre=:nombre");
            $consulta ->execute(array(':nombre'=>$nombre));
            $row=$consulta->fetch(PDO::FETCH_ASSOC);

        if($row['art_nombre']==$nombre) {
            return true;
        }else{
            return false;
        }
    }catch(PDOException $e){
           echo $e->getMessage();
       }    
}     


if(isset($_POST['btn-registrar'])){
   $nombre = trim($_POST['txt_nombre']);
   $descrip = trim($_POST['txt_descrip']); 
 
  if(!yaExiste($descrip)){  

        $articulo = new Articulo($nombre,$descrip);
        if($articulo->guardar()){
        $articulo->redirect('admin.articulos.php?joined');
        } 
      }else{
            $error[] = "!Lo sentimos el articulo <b>".$nombre."</b> ya existe!";
      } 
}
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
  <div class="row form_usuario">
    <div class="col-md-12 text-center reg">
    <form method="post">
        <div class="imgcontainer">
           <img src="img/articulo.png" alt="Avatar" class="avatar">
        </div>
         <h2>Registra un Articulo</h2>
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
                  <input type="text" placeholder="Digite el nombre" id="descripcion" 
                  name="txt_nombre" class="descrip" 
                  value="<?php if(isset($error)){echo $descrip;}?>" required>
              </div>   
                  <div class="col-md-12 text-center">
                    <input type="text" placeholder="Descripcion" name="txt_descrip" class="descrip" required>
                  </div>
              </div>
            </div>  
                  <div class="col-md-12 text-center">
                    <button class="regist" type="submit" name="btn-registrar">Registrar
                    </button>
                  </div>
              <div class="col-md-12 text-center">
                <button type="button" class="cancelbtn">Cancelar</button>
              </div> 
          </div>      
                  
        </div>
    </form>

    </div>
  </div>  

</body>
</html>