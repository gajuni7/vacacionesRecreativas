<?php
	require_once 'class.conexion.php';
	include_once 'dbconfig.php';
	if(!$user->is_loggedin())
	{
	 $user->redirect('index.php');
	}
	$user_id = $_SESSION['user_session'];
	$stmt = $DB_con->prepare("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	function yaExiste($nombre,$descrip,$hora,$fecha){
try{
		$conexion = new Conexion();

		$consulta = $conexion->prepare("SELECT ua.user_name, 
				fh.act_descripcion,fh.act_fecha,fh.act_hora
							from act_fechahora AS fh
                                 INNER JOIN users_actividades AS ua
                                 ON (ua.act_descripcion =fh.act_descripcion)
					WHERE ua.user_name=:nombre AND fh.act_descripcion=:descripcion
					AND fh.act_fecha=:fecha AND fh.act_hora=:hora");

		$consulta ->execute(array(':nombre'=>$nombre,
								':descripcion'=>$descrip,
								':fecha'=>$fecha,
								':hora'=>$hora));
								
		$row=$consulta->fetch(PDO::FETCH_ASSOC);
		if($row['user_name']==$nombre && $row['act_descripcion']==$descrip
			&& $row['act_fecha']==$fecha && $row['act_hora']==$hora) {
			return true;
		}else{
			return false;
		}
	}catch(PDOException $e){
			echo $e->getMessage();
	}    
  }

if(isset($_POST['btn-registrar'])){ 		
		$actividad = trim($_POST['actividad']);
		$horafecha = explode('-',trim($_POST['diahora']));
		$cupo = intval(trim($_POST['cupo']));
		$usuario = $userRow['user_name'];
		$newCupo = $cupo-1;
		$fe = $horafecha[0];
		$fech= explode('/',$fe);
		$fecha=''. $fech[0].'-'.$fech[1].'-'.$fech[2];
		$hora =''.$horafecha[1];
		echo yaExiste($usuario,$actividad,$hora,$fecha);
	if(yaExiste($usuario,$actividad,$hora,$fecha)){ 
		$con = new Conexion();
		$cambiar = "UPDATE act_fechahora SET act_cupo =:cupo 
    					WHERE act_descripcion =:descripcion AND 
    					act_hora=:hora AND act_fecha=:fecha";
    	$consul = $con->prepare($cambiar);
    	$consul ->execute(array(':descripcion'=>$actividad,
								':fecha'=>$fecha,
								':hora'=>$hora,
								':cupo'=>$newCupo));

		$cons = $con->prepare('INSERT INTO '.'users_actividades'.
						            '(user_name,act_descripcion,
						            		act_hora,act_fecha) 
						            VALUES(:usuario,:actividad,:hora,:fecha)');
			$cons->bindParam(':usuario', $usuario);
			$cons->bindParam(':actividad',$actividad);
			$cons->bindParam(':fecha',$fecha);
			$cons->bindParam(':hora',$hora);
			$cons->execute();
			header("Location: home.php?joined");
						
	}else{
			$error[] = "¡Lo sentimos el usuario <b>".$usuario."</b> ya esta registrado en esta actividad!";

	} 
}
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
<form  method="post">	   	
	<div class="row">
		<div class="col-md-12 text-center calendar">
		<?php
              if(isset($error))
              {
                foreach($error as $error)
                {
                   ?>
                     <center><div class="alert alert-danger error">
                        <i class="glyphicon glyphicon-warning-sign"></i><?php echo $error; ?></div></center>
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
			<center><div id="container">
			<div id='calendar'></div>
		</div>	</center><br>
			<input type="hidden" name="actividad" id="acti" readonly>
			<input type="hidden" name="diahora" id="diahora" readonly>	
			<input type="hidden" name="cupo" id="cupo" readonly>	
		</div>
	</div>	

	<div id="myModal" class="modal">
		<div class="modal-content">
			<div class="modal-header">
				<h1 id="act"></h1>
				<span class="close">&times;</span>    
			</div>
			<div class="modal-body">
			    <p></p>	
			</div>
			<div class="modal-footer">
				<button class="regist" type="submit" name="btn-registrar">
				Registrarse
				</button>
			</div>
		</div>
	</div>	
	
</form>	
<script>
		
		   				
	$(document).ready(function() {
		
		$('#calendar').fullCalendar({
		
			 eventClick:  function(event, jsEvent, view){

			var articulos = event.className.join(' ');
			var titulo = event.title.split(",");
            var modal = document.getElementById('myModal');
            modal.style.display = "block";
            document.getElementsByClassName("close")[0].onclick = function() {	modal.style.display = "none";}            
            var start = moment(event.start).format('YYYY/MM/DD - HH:mm:ss');
            document.getElementById("act").innerHTML = titulo[0];
            document.getElementById("acti").value = titulo[0];
            document.getElementById("diahora").value =''+ start;
            document.getElementById("cupo").value =event.id;
            document.getElementsByTagName("p")[0].innerHTML = 
            "LUGAR: "+titulo[1]+"<br>"+
            "DIA - HORA: "+start+"<br>"+
            "CUPO MAXIMO: "+event.id+' personas'+"<br>"+
            "ARTICULOS:"+"<br>"+articulos;            		
            

            
           
          
        },  
			defaultDate: '2017-12-07',
			eventLimit: true,
			default: true, // allow "more" link when too many events

			events: 
				{
				 url:'cargarEventos.php',
				 cache: true
				},

			 timeFormat: 'H(:mm)',
			 eventColor: '#df2d3c', 
			 eventTextColor: 'white',
			 monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
    		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
    		dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
    		dayNamesShort: ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb']
		
	});

  });      

</script>
</body>
</html>