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
	<link href='css/fullcalendar.min.css' rel='stylesheet'/>
	<link href='css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
	<script src='lib/moment.min.js'></script>
	<script src='lib/jquery.min.js'></script>
	<script src='lib/fullcalendar.min.js'></script>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">
				<h1>Vacaciones recreativas</h1>
			</div>
			<div class="col-md-5 text-right user">
				<h4 >Bienvenido  -->
					<img src="img/user.png" alt="Avatar" title="<?php print($userRow['user_name']);?>" class="avatar">
					 <b><?php print($userRow['user_name']); ?></b> <--	
				</h4>	
			</div>
			<div class="col-md-1 text-left logout">
			<a href="logout.php?logout=true"><img src="img/logout.png" title="Cerrar sesion" class="logout"></a>
			</div>
		</div>
	<div class="row form_usuario">
		<div class="col-md-12 text-center calendar">
			<center><div id="container">
			<div id='calendar'></div>
			</div></center>
		</div>
	</div>	
<script>

	$(document).ready(function() {
		
		$('#calendar').fullCalendar({
			
			defaultDate: '2017-11-12',
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: [
				{
					title: 'All Day Event',
					start: '2017-11-01'
				}
			]
		});
		
	});

</script>
</body>
</html>