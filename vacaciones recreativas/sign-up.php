<?php
require_once 'dbconfig.php';

if($user->is_loggedin()!="")
{
    $user->redirect('home.php');
}

if(isset($_POST['btn-signup']))
{
   $uname = trim($_POST['txt_uname']);
   $upass = trim($_POST['txt_upass']); 
 
      try 
      {
         $stmt = $DB_con->prepare("SELECT user_name FROM users WHERE user_name=:uname");
         $stmt->execute(array(':uname'=>$uname));
         $row=$stmt->fetch(PDO::FETCH_ASSOC);
    
         if($row['user_name']==$uname) {
            $error[] = "!Lo sentimos el usuario <b>".$uname."</b> ya existe!";
         }
         else
         {
            if($user->register($uname,$upass)) 
            {
                $user->redirect('sign-up.php?joined');
            }
         }
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
  } 


?>

<!DOCTYPE html>
<html>
<head>
  <title>vacaciones recreativas</title> 
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/regStyle.css">
  <link rel="icon"  href="img/icon.png">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <h1>Vacaciones recreativas</h1>
      </div>
    </div>
  <div class="row form_usuario">
    <div class="col-md-12 text-center reg">
    <form method="post">
        <div class="imgcontainer">
           <img src="img/user.png" alt="Avatar" class="avatar">
        </div>

        <div class="container">
            <h2>Registrate</h2>

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
                    <center><div class="col-md-12 alert alert-info error">
                       <i class="glyphicon glyphicon-log-in"></i>Registrado exitosamente 
                       <a href='index.php'>Inicia sesion aqui</a> 
                   </div></center>
                <?php
              }
            ?>
            <div class="row">
              <div class="col-md-12 text-center">
                  <input type="text" placeholder="Usuario" id="usuario" name="txt_uname" class="uname" 
                  value="<?php if(isset($error)){echo $uname;}?>" required>
                </div>
                <div class="col-md-12 text-center">
                  <input type="password" placeholder="Contraseña" name="txt_upass" class="psw" required>
                </div>
                <div class="col-md-12 text-center">
                  <input type="password" placeholder="Verificar contraseña" name="txt_upass" class="psw" required>
                </div>
                <div class="col-md-12 text-center">
                  <p id="reg">Si ya tienes una cuenta<a href="index.php"> Inicia sesion aqui</a></p>
                </div>
                <div class="col-md-12 text-center">
                  <button class="regist" type="submit" name="btn-signup">Registrarse</button>
                </div>
              </div>
              <div class="col-md-12 text-center">
                <button type="button" class="cancelbtn">Cancelar</button>
              </div>
        </div>
    </form>

    </div>
  </div>  

</body>
</html>