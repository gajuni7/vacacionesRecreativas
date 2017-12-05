<?php

	include_once 'dbconfig.php';
	if(!$user->is_loggedin())
	{
	 $user->redirect('index.php');
	}
	$user_id = $_SESSION['user_session'];
	$stmt = $DB_con->prepare("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
	<title>vacaciones recreativas</title>	
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/homeStyle.css">
	<link rel="icon"  href="img/icon.png">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">
				<h1>Vacaciones recreativas</h1>
			</div>
			<div class="col-md-6 text-right">
				<h2>Bienvenido:
					<img src="img/user.png" alt="Avatar" class="avatar">
					 <?php print($userRow['user_name']); ?>
					<img src="img/logout.png" alt="Avatar" class="avatar"> 
				</h2>	
			</div>
		</div>
	<div class="row form_usuario">
		<div class="col-md-12 text-center calendar">
		<form method="post" class="form-signin" id="login-form">
				<div class="container">

				</div>
		</form>

		</div>
	</div>	

</body>
</html>