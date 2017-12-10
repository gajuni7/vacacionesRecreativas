<?php

	require_once 'class.conexion.php';
	$conexion = new Conexion();
	$sql= "SELECT fh.act_fecha, fh.act_hora, fh.act_descripcion, fh.act_cupo, 
	a.act_lugar
                             from act_fechahora AS fh
                                 INNER JOIN actividades AS a
                                     ON (fh.act_descripcion= a.act_descripcion)";
		 	$consulta = $conexion->prepare($sql);
            $consulta ->execute(array(':descripcion'));
        	$consulta->execute();
        
   		 while($row=$consulta->fetch(PDO::FETCH_ASSOC)) {	
	        $articulos = articulos($row['act_descripcion']);	
	        	$eventos[] = array('id'=>$row['act_cupo'],
					'title' =>$row['act_descripcion'].','.$row['act_lugar'], 
						'start' => $row['act_fecha'].' '.$row['act_hora'],
						'className'=>$articulos);	
			}	
	        	
        	
			$arrayJson = json_encode($eventos, JSON_UNESCAPED_UNICODE);
    		print_r($arrayJson);


	
	function articulos($actividad){
	$conexion = new Conexion();
	$articulos='';
	$sql2= "SELECT  aa.act_descripcion,a.art_nombre, a.art_descripcion
		                             from actividades_articulos AS aa
		                                 INNER JOIN articulos AS a
		                                    ON (aa.art_nombre= a.art_nombre)
		                                     WHERE aa.act_descripcion=:descrip";
			$consul = $conexion->prepare($sql2);
            $consul ->execute(array(':descrip'=>$actividad));
            while($row=$consul->fetch(PDO::FETCH_ASSOC)){
            $articulos.=$row['art_nombre'].': '.$row['art_descripcion'].'<br>';

		}	
		return $articulos;
    }

?>