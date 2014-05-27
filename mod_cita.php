<?
	$indice		= $_POST['indice'];
	$horario_cita	= $_POST['horario'];
	$fecha_cita	= $_POST['fechacita'];
	$campus_cita	= $_POST['campus_cita'];
	
	$_SESSION['idalumno'] = $idalumno;
	
	if(isset($indice) && isset($horario_cita) && isset($fecha_cita) && isset($campus_cita)){
		 unset($_SESSION['campus'][$indice]);
		 
	}
	
	# Se modifica el array de $campi para la generación de las visitas
	
	$campi = array();
	$key = 1;
	
	for ($i=0; $i<count($_POST['campus']);$i++) {  	
	      $campi[$key] = $_POST['campus'][$i];
	      $key++;
	}
	
	if (empty($campi)){
		$campi	= $_SESSION['campus'];
	}
	else {
		$_SESSION['campus'] = $campi;
	}
	
	# fin del array $campi
	
	$i = 1;
	foreach ($campi as $campus => $valor) {
		
		$indice = $campus;
		switch ($valor) {
			case 1 : $campus = "Coacalco"; break;
			case 2 : $campus = "Cuautitlan"; break;
			case 3 : $campus = "Cuernavaca"; break;
			case 4 : $campus = "Ermita"; break;
			case 5 : $campus = "La Villa"; break;
			case 6 : $campus = "Lomas Verdes"; break;
			case 7 : $campus = "Toluca"; break;
			case 8 : $campus = "Tlalpan"; break;
			case 9 : $campus = "Zaragoza"; break;
			case 10 : $campus = "Zona Rosa"; break;
	    	}
		$citas .= "
		<tr>
		<td$colspan>
		<form action='" . $_SERVER['PHP_SELF'] . "' method='POST' id='cita[]'>
		<table width='100%'>
			<tr>
				<td width='20%'>
					<input type='hidden' name='empleado' value='$agente' />
					<input type='hidden' name='alumno' value='$idalumno' />
					<input type='hidden' name='nombre' value='$nombre' />
					<input type='hidden' name='paterno' value='$paterno' />
					<input type='hidden' name='materno' value='$materno' />
					
					<input type='hidden' name='indice' value='$indice' />
					<input type='hidden' name='campus_cita' value='$valor' />					
					$campus
				</td>
				<td width='30%'>
					<input type='text' name='fechacita' placeholder='Fecha de la cita' class='sig_fecha' onChange=\"bsc_horario(this.value,'$valor','horario[$i]')\">
				</td>
				<td id='horario[$i]' width='25%'>
					<select disabled>
						<option>00:00:00</option>
					</select>
				</td>
				<td width='25%'>
					<input type='hidden' name='estatus' value='cita' />
					<input type='hidden' name='accion' value='Enviar' />
					<input type='submit' value='Crear cita' />
				</td>
			</tr>
		</table>
		</form>
		</td>
		</tr>
		";
		$i++;
	}
	
	 if ( isset($origen) AND $fecha_informes ) {
		$infoextra = "<tr>
			<td><i class='fa $ico_origen'></i> $origen</td>
			<td>$fecha_informes</td>
		</tr>";
	}
?>

		<script type="text/javascript">

			$(#cita[]).submit(function()) {

				$.ajax {


					type: 'POST',
					url: $($this).attr('action'),
					data:$($this).serialize(),
					success:function(data){
						$('#').html(data);
		        

		        }
        })        
        return false;
    }); 

		</script>

		
			<table align="center" border="0" class="sig_form">
				<tr class="sig_header">
					<td>
						Agente:
					</td>
					<td>
						ID:
					</td>
				</tr>
				<tr class="sig_agente">
					<td>
						<?=$nombre_emp . " " . $paterno_emp;?>
					</td>
					<td>
						<?=$empleado;?>
						<input type='hidden' name='empleado' value='$empleado' />
					</td>
				</tr>
				<tr class="sig_titu">
					<td colspan="2">Prospecto:<h2><?="[" . $idalumno . "] - " . $nombre . " " . $paterno . " " . $materno;?><h2></td>
				</tr>
				<tr class="sig_header">
					<td colspan="2">
						<?
							if(!empty($campi)){
								echo "Genereción de Citas";
							}
							else {
								echo "Citas Asignadas";
							}
						?>
					</td>
				</tr>
				<?=$infoextra;?>				
				<?=$citas;?>
				
							
			</table>
			<?include('mod_calendario.php');?>

