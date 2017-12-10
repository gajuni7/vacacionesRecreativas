<?php
require_once 'admin.dbconfig.php';

if($admin->is_loggedin()!="")
{
 $admin->redirect('admin.actividades.php');
}

if(isset($_POST['btn-login']))
{
	$uname = $_POST['txt_uname'];
	$upass = $_POST['txt_password'];
		
	if($admin->login($uname,$upass))
		{
		  $admin->redirect('admin.actividades.php');
		}
		 else
		{
			$error = "¡Usuario o contraseña incorrectos!";
		}	
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>vacaciones recreativas</title>	
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
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
		<div class="col-md-12 text-center user">
		<form method="post" class="form-signin" id="login-form">
				<div class="imgcontainer">
					 <img src="img/admin.png" alt="Avatar" class="avatar">
				</div>
				<div class="container">
						<h2>Administrador</h2>
						<center>
						<div id="error">
					        <?php
								if(isset($error))
								{
									?>
					                <div class="alert alert-danger">
					                   <i class="glyphicon glyphicon-warning-sign"></i><?php echo $error;?>
					                </div>
					                <?php
								}
							?>
					    </div><center>

						<div class="row">
					  		<div class="col-md-12">
						  			<input type="text" placeholder="Usuario" id="usuario" name="txt_uname"
						  			class="uname" required>
					  		</div>
					  		<div class="col-md-12">
						  			<input type="password" placeholder="Contraseña" name="txt_password" 
						  			class="psw" required>
					  		</div>
					  		<div class="col-md-12 text-center">
						  			<button name="btn-login" class="login" 
						  			type="submit">Login</button>
					  		</div>
					  	</div>
					    <button type="button" class="cancelbtn">Cancel</button>
				</div>
		</form>

		</div>
	</div>	

</body>
</html>