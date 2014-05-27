<?php
header("Content-Type: text/html; charset=iso-8859-1");
include('include/sess.php');
include('include/functions.php');
include('include/catalogos.php');

$agente		= $_POST['empleado'];
$nombre		= strtoupper($_POST['nombre']);
$paterno	= strtoupper($_POST['paterno']);
$materno	= strtoupper($_POST['materno']);
$sexo		= $_POST['sexo'];

$correo		= strtolower($_POST['email']);
$telefono	= $_POST['telefono'];
$teloficina	= $_POST['tel_ofc'];
$celular	= $_POST['celular'];
$nacimiento	= $_POST['nacimiento'];
$edad		= $_POST['edad'];
$codigopostal	= $_POST['cp'];
$entidad	= $_POST['entidad'];

$nivel		= $_POST['nivel'];
$prgacademico	= $_POST['prgacad'];
$turno		= $_POST['turno']; 			# array

$publicidad	= $_POST['medio'];

$comentarios	= $_POST['comentarios'];

$estatus	= $_POST['estatus'];
$accion		= $_POST['accion'];

//print_r ($_POST);

if ($accion == "Enviar"){
	//if( !empty($nombre) || !empty($paterno) || !empty($materno) || !empty($correo) || !empty($telefono) || !empty($nivel) || !empty($campi) || !empty($comentarios) ){

$idalumno = idalumno($paterno,$materno,$nombre);


switch ($estatus) {
	case "captura" :
	
		break;
	case "cita" :		
		echo "
		<!DOCTYPE html>
		<html>
		";
		include('include/head.html.php');
		echo "<body>";
		$colspan = " colspan='2'";
		include('mod_cita.php');		
		echo "</body>";
		break;
	default :
	
		break;
}



exit();
		$sql		 = "SELECT * FROM ";
		$sql		.= "((talumnos ";
		$sql		.= "LEFT JOIN tcontacto_alu ON talumnos.idtalumnos = tcontacto_alu.idtalumnos AND tcontacto_alu.idttipocontacto = 3) ";
		$sql		.= "LEFT JOIN tprospecto ON talumnos.idtalumnos = tprospecto.idtalumnos) ";
		$sql		.= "WHERE contacto_alu = '$correo'";

		$que = $conexion->query($sql);
		$row_cnt = $que->num_rows;

		if ($row_cnt == 1) {
			$row = $que->fetch_array();
			/*
			$paterno_alu 	= $row['paterno_alu'];
			$materno_alu 	= $row['materno_alu'];
			*/
		
			$id_alu		= $row['idtalumnos'];
		        $matricula 	= $row['matricula'];
			$nivel_alu	= $row['idtnivelacademico'];
		
			if ($nivel == $nivel_alu){
				echo "El prospecto ya se encuentra capturado con el id: $id_alu";
				exit();
		
			}
				
		}
		
	switch ($nivel) {
	    case 1:
		$pre_nivel = "el";
		$nivel_UI = "Bachillerato";
		$bgcolor_UI = "#93c73e";
		break;
	    case 2:
		$pre_nivel = "la";
		$nivel_UI = "Licenciatura";
		$bgcolor_UI = "#0082ca";
		break;
	    case 3:
		$pre_nivel = "la";
		$nivel_UI = "Especialidad";
		$bgcolor_UI = "#f68c1f";
		break;
	    case 4:
		$pre_nivel = "la";
		$nivel_UI = "Maestría";
		$bgcolor_UI = "#ffd741";
		break;
	}

	$campi_lst = campi($campi);


	//MANDAR CORREO ELECTRÓNICO
	$nombre_comp	= $nombre . " " . $paterno . " " . $materno;

	#$destino	= "informesicel@icel.edu.mx,carmenlazcano@icel.edu.mx,";
	$destino	= "carlosdurruti@icel.edu.mx";

	$asunto 	= "CALL Center - Universidad ICEL [$empleado]";	
	$mensaje 	= '
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
				"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
		                </head>
				<body bgcolor="#f1f1f1" style="font:normal 12px arial,sans-serif;color:#555;">
		                
		                <table width="600" height="100%" align="center" style="border-collapse:collapse" border="0" cellspacing="0" cellpadding="4">
				<tr>
		                    <td width="75%">
		                        <img src="http://www.icel.edu.mx/images/icel/web/logo_mail.png" />
		                    </td>
		                    <td align="right" valign="bottom"> <ul style="list-style:none;"><li>' . $idalumno . '<li><li>' . $fecha_solicitud . '</li></ul>
		                    </td>
		                </tr>
		                <tr bgcolor="#ffffff" style="border-radius:5px;">
		                    <td colspan="2">
		                        <table width="600" style="border-collapse:collapse;color:#666666;font-family:arial,sans-serif" border="0" cellspacing="0" cellpadding="6" bgcolor="#ffffff">
		                                <tr bgcolor="' . $bgcolor_UI . '"><td colspan="2" style="font:bold 18px arial,sans-serif;color:#ffffff;">' . $nivel_UI . '</td></tr>
		                                <tr><td colspan="2">Nombre:</td></tr>
		                                <tr><td colspan="2" style="color:#0a3c70;font:bold 20px arial,sans-serif;">' . $nombre_comp . '</td></tr>
		                                <tr><td>Email:</td><td>Tel&eacute;fono:</td></tr>
		                                <tr><td style="font:bold 16px arial,sans-serif;color:#0a3c70;">' . $correo . '</td><td style="font:bold 16px arial,sans-serif;color:#0a3c70;">' . $telefono . '</td></tr>
		                                <tr><td colspan="2">Dudas y comentarios:</td></tr>
		                                <tr><td colspan="2" style="font:bold 14px arial,sans-serif;color:#0a3c70;">' . $comentarios . '</td></tr>
		                                <tr bgcolor="' . $bgcolor_UI . '"><td colspan="2" style="color:#ffffff;">Campus de interés:</td></tr>
		                                <tr bgcolor="#0a3c70"><td colspan="2" style="font:bold 16px arial,sans-serif;color:#ffffff;">' . $campi_lst . '</td></tr>
		                        </table>
		                    </td>
		                <tr>
		                </table>
				</body>
				</html>
			';

		enviarcorreo($correo, $asunto, $mensaje, 'Universidad ICEL', 'informes@icel.edu.mx');

		$sql  = "INSERT INTO ";
		$sql .= "talumnos (idtalumnos,idttipoalumno,nombre_alu,paterno_alu,materno_alu) ";
		$sql .= "VALUES ";
		$sql .= "('$idalumno','1','$nombre','$paterno','$materno')";

		if ($conexion->query($sql)) {

			$sql  = "INSERT INTO ";
			$sql .= "tprospecto (idtalumnos,idtnivelacademico,idtorigen,idtpublicidad,fecha_informes,comentarios) ";
			$sql .= "VALUES ('$idalumno','$nivel','1','1','$fecha_solicitud','$comentarios')";

			if ($conexion->query($sql)) {

				$sql  = "INSERT INTO ";
				$sql .= "tcampus_interes (idtcampus,idtprospecto)";
				$sql .= "VALUES ";
				$sql .= "('$campi[0]','$idalumno'), ('$campi[1]','$idalumno'), ('$campi[2]','$idalumno') ";

				if ($conexion->query($sql)) {

					$sql  = "INSERT INTO ";
					$sql .= "tcontacto_alu (idttipocontacto,idtalumnos,contacto_alu) ";
		                        $sql .= "VALUES ";
					$sql .= "('3','$idalumno','$correo'), ('1','$idalumno','$telefono')";
		                        
					if ($conexion->query($sql)) {
		                                $mensaje = '
		                                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
		                                "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		                                <html xmlns="http://www.w3.org/1999/xhtml">
		                                <head>
		                                </head>
		                                <body bgcolor="#f1f1f1" style="font:normal 12px arial,sans-serif;color:#555;">
		                                <table width="600" height="100%" align="center" style="border-collapse:collapse" border="0" cellspacing="0" cellpadding="4">
		                                <tr>
		                                    <td width="75%">
		                                        <img src="http://www.icel.edu.mx/images/icel/web/logo_mail.png" />
		                                    </td>
		                                    <td align="right" valign="bottom"> <ul style="list-style:none;"><li>' . $idalumno . '<li><li>' . $fecha_solicitud . '</li></ul>
		                                    </td>
		                                </tr>
		                                <tr bgcolor="#ffffff" style="border-radius:5px;">
		                                    <td colspan="2">
		                                        <table width="600" style="border-collapse:collapse;color:#666666;font-family:arial,sans-serif" border="0" cellspacing="0" cellpadding="6" bgcolor="#ffffff">
		                                                <tr bgcolor="' . $bgcolor_UI . '"><td colspan="2" style="font:bold 18px arial,sans-serif;color:#ffffff;">' . $nivel_UI . '</td></tr>
		                                                <tr><td colspan="2" style="color:#0a3c70;font:bold 20px arial,sans-serif;">' . $nombre_comp . '</td></tr>
		                                                <tr><td style="font:bold 16px arial,sans-serif;color:#0a3c70;">Se ha enviado un correo a ' . $correo . ' para acusar de recibido. En breve nos comunicaremos contigo al teléfono ' . $telefono . '</td></tr>
		                                                <tr><td colspan="2">Dudas y comentarios:</td></tr>
		                                                <tr><td colspan="2" style="font:bold 14px arial,sans-serif;color:#0a3c70;">' . $comentarios . '</td></tr>
		                                                <tr bgcolor="' . $bgcolor_UI . '"><td colspan="2" style="color:#ffffff;">Los Campi que seleccionaste son:</td></tr>
		                                                <tr bgcolor="#0a3c70"><td colspan="2" style="font:bold 16px arial,sans-serif;color:#ffffff;">' . $campi_lst . '</td></tr>
		                                        </table>
		                                    </td>
		                                <tr>
		                                </table>
		                                </body>
		                                </html>
		                                ';
		                                
		                                echo $mensaje;
		                                exit();
		                        }
				
				}

			}

		}
		$conexion->close();
	//}
	
}
//Termina el registro a SIGUE

/* Agente telefónico *\___________________________________________________________________________*/



?>

<html>
<?
include('include/head.html.php');
?>
<body>
	<section>
	<form name="prospectos" action="<?=$_SERVER['PHP_SELF']?>" method="POST" id="prospectos">
		<table align="center" border="0" class="sig_form">
			<tr class="sig_header">
				<td colspan="3">
					Agente:
				</td>
				<td>
					ID:
				</td>
			</tr>
			<tr class="sig_agente">
				<td colspan="3">
					<?=$nombre_emp . " " . $paterno_emp;?>
				</td>
				<td>
					<?=$empleado;?>
					<input type="hidden" name="empleado" value="<?=$empleado;?>" />
				</td>
			</tr>
			<tr class="sig_titu">
				<td colspan="4">Datos del prospecto:</td>
			</tr>
			<tr>
				<td valign="top" width="25%">
					<input type="text" name="nombre" placeholder="Nombre" value="<?=$nombre;?>" autofocus />
				</td>
				<td valign="top" width="25%">
					<input type="text" name="paterno" placeholder="Apellido Paterno" value="<?=$paterno;?>" />
				</td>
				<td valign="top" width="25%">
					<input type="text" name="materno" placeholder="Apellido Materno" value="<?=$materno;?>" />
				</td>
				<td valign="top" width="25%">
					
					<select name="sexo" data-theme="c" data-role="slider" class="sig_switch">
						<option value="m" selected>
							Masculino
						</option>
						<option value="f">
							Femenino
						</option>
					</select>
				</td>
			</tr>
			<tr>
				<td valign="top">
					<input type="email" name="email" placeholder="Correo electrónico" value="<?=$correo;?>" />
				</td>
				<td valign="top">
					<input type="tel" name="telefono" placeholder="Teléfono" value="<?=$telefono;?>" />
				</td>
				<td valign="top">
					<input type="tel" name="tel_ofc" placeholder="Teléfono de oficina" value="<?=$tel_ofc;?>" />
				</td>
				<td valign="top">
					<input type="tel" name="celular" placeholder="Celular" value="<?=$celular;?>" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="text" name="nacimiento" id="fecha" placeholder="Fecha de nacimiento" onChange="calcular_edad(this.value)" class='sig_fecha'>
				</td>
				<td colspan="2">
					<input type="text" name="edad" id="edad" placeholder="Edad">
				</td>
			</tr>
			<tr>
				<td colspan="4" valign="top">
					<input type="text" name="cp" id="cp" placeholder="Código Postal" value="<?=$cp;?>" autocomplete="off" onkeyup="if (this.value.length == 5) { bsc_cp(this.value,'codigopostal'); }" />
				</td>
			</tr>
			<tr>
				<td colspan="4" valign="top" id="codigopostal">
				
				</td>
			</tr>
			<tr class="sig_titu">
				<td colspan="4" valign="top">Nivel de interés:</td>
			</tr>
			<tr>
				<td colspan="4" valign="top">
					<select name="nivel" id="nivel" onChange="bsc_prgacademico(this.value,'prgacad')">
						<option value="">Selecciona una opción</option>
						<option value="1" class="sigue2">Bachillerato</option>
						<option value="2" class="sigue1">Licenciatura</option>
						<option value="3" class="sigue2">Especialidad</option>
						<option value="4" class="sigue1">Maestría</option>
					</select>
				</td>
			</tr>
			<tr class="sig_titu">
				<td colspan="4" valign="top">Programa académico:</td>
			</tr>
			<tr>
				<td colspan="4" valign="top" id="prgacad">
					<select name="prgacad">
						<option value="">Selecciona un Nivel Académico</option>
					</select>
				</td>
			</tr>
			<tr class="sig_titu">
				<td colspan="4" valign="top">Turno:</td>
			</tr>
			<tr>
				<td colspan="4">
					<div data-role="fieldcontain">
		    				<fieldset data-role="controlgroup" data-type="horizontal" class="sig_checkbox">
		    					
							<input type="checkbox" name="turno[]" id="matutino" value="1" />
							<label for="matutino" class="sig_check">Matutino</label>
							
							<input type="checkbox" name="turno[]" id="vespertino" value="2" />
							<label for="vespertino" class="sig_check">Vespertino</label>
							
							<input type="checkbox" name="turno[]" id="nocturno" value="3" />
							<label for="nocturno" class="sig_check">Nocturno</label>
							
							<input type="checkbox" name="turno[]" id="sabatino" value="4" />
							<label for="sabatino" class="sig_check">Sabatino</label>
							
						</fieldset>
					</div>
				</td>
			</tr>
			<tr class="sig_titu">
				<td colspan="4" valign="top">Tres campi de interés:</td>
			</tr>
			<tr>
				<td colspan="4">
					<div data-role="fieldcontain" class="sig_campus ">
						<fieldset data-role="controlgroup" data-type="horizontal" class="sig_checkbox">
						<legend>Distrito Federal:</legend>	
							<input type="checkbox" name="campus[]" id="ermita" value="4" />
							<label for="ermita" class="sig_check">Ermita</label>
							
							<input type="checkbox" name="campus[]" id="lavilla" value="5" />
							<label for="lavilla" class="sig_check">La Villa</label>
						
							<input type="checkbox" name="campus[]" id="tlalpan" value="8" />
							<label for="tlalpan" class="sig_check">Tlalpan</label>
							
							<input type="checkbox" name="campus[]" id="zaragoza" value="9" />
							<label for="zaragoza" class="sig_check">Zaragoza</label>
							
							<input type="checkbox" name="campus[]" id="zonarosa" value="10" />
							<label for="zonarosa" class="sig_check">Zona Rosa</label>
							
						</fieldset>
					</div>
					<div data-role="fieldcontain" class="sig_campus ">
						<fieldset data-role="controlgroup" data-type="horizontal" class="sig_checkbox">
						<legend>Estado de México:</legend>
							<input type="checkbox" name="campus[]" id="coacalco" value="1" />
							<label for="coacalco" class="sig_check">Coacalco</label>
				
							<input type="checkbox" name="campus[]" id="cuautitlan" value="2" />
							<label for="cuautitlan" class="sig_check">Cuautitlán</label>
							
							<input type="checkbox" name="campus[]" id="lomasverdes" value="6" />
							<label for="lomasverdes" class="sig_check">Lomas Verdes</label>
							
							<input type="checkbox" name="campus[]" id="toluca" value="7" />
							<label for="toluca" class="sig_check">Toluca</label>
						</fieldset>
					</div>
					<div data-role="fieldcontain" class="sig_campus ">
						<fieldset data-role="controlgroup" data-type="horizontal" class="sig_checkbox">
						<legend>Morelos:</legend>
							<input type="checkbox" name="campus[]" id="cuernavaca" value="3" />
							<label for="cuernavaca" class="sig_check">Cuernavaca</label>
						</fieldset>
					</div>
				</td>
			</tr>
			
			<tr class="sig_titu">
				<td colspan="4" valign="top">Medio de publicidad:</td>
			</tr>
			<tr>
				<td colspan="4" valign="top">
					<select name="medio">
						<option value="">Seleccione un medio</option>
						<?=$medio;?>
					</select>
				</td>
			</tr>
			<tr class="sig_titu">
				<td colspan="4" valign="top">Dudas y comentarios:</td>
			</tr>
			<tr>
				<td colspan="4" valign="top">
					
					<textarea name="comentarios" cols="30" rows="5"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<input type="hidden" name="estatus" value="cita" />  
					<input type="submit" name="accion" value="Enviar" />
				</td>
			</tr>
		</table>
	</form>
	</section>

</body>

</html>
