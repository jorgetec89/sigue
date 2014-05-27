<?
header('Content-Type: text/xml; charset=ISO-8859-1'); 
mb_http_input("iso-8859-1");
mb_http_output("iso-8859-1");
?>
<?php
require('include/sess.php');

	$fecha = $_GET['fecha'];
	$campus = $_GET['campus'];
		
	$sql		= "SELECT hora_cita FROM ";
	$sql	       .= "tcita ";
	$sql	       .= "WHERE ";
	$sql	       .= "fecha_cita = '$fecha' AND ";
	$sql	       .= "idtcampus = '$campus' ";
	$que		= $conexion->query($sql);
	
	while ( $row = $que->fetch_array() ){
		$ocu[] = strtotime($row['hora_cita']);
	}
	
	mysqli_free_result ( $que );
	mysqli_close ( $conexion );
	
	
	$hoy		= DATE('Y-m-d');
	$hora		=  DATE('H:i:s');
	
	$start		= "09:00:00";
	$end		= "17:00:00";
	
	$tinicio = strtotime($start);
	$tfinal = strtotime($end);
	
	echo "<select name='horario'>";
	while($tinicio <= $tfinal){
		if (in_array($tinicio, $ocu) OR $fecha < $hoy OR $tinicio == $tfinal OR ($tinicio < strtotime($hora) AND $fecha == $hoy) ) { $dis = " disabled";}
		else {$dis = "";}

	  echo "<option value='" . DATE("H:i:s",$tinicio) . "'$dis>" . DATE("H:i:s",$tinicio) . "</option>\n";
	  $tinicio = strtotime('+20 minutes',$tinicio);
	}
	echo "</select>";

?>
