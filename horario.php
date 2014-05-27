<?

	function redondear_hora ($hour,$minutes) {
	    $seconds = strtotime($hour);
	    $rounded = ceil($seconds / ($minutes * 60)) * ($minutes * 60);
	    return date("H:i:s", $rounded);
	}


	$hora = DATE("H:i:s");
	echo $hora;
	echo redondear_hora($hora,"60");
	exit;


	$ocu[0] = strtotime("12:20");
	$ocu[1] = strtotime("13:40");
	$ocu[2] = strtotime("11:00");


	$start = "09:00";
	$end = "15:00";

	$tinicio = strtotime($start);
	$tfinal = strtotime($end);

	echo "<select>";
	while($tinicio <= $tfinal){
		if (in_array($tinicio, $ocu) OR $tinicio < strtotime($hora) ) { $dis = " disabled"; }
		else {$dis = "";}
		
	  echo "<option value='".date("H:i",$tinicio)."'$dis>".date("H:i",$tinicio)."</option>\n";
	  $tinicio = strtotime('+20 minutes',$tinicio);
	}

	echo "</select>";

	?>
