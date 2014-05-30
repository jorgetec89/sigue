<?
header("Content-Type: text/html; charset=iso-8859-1");
require('include/sess.php');
include('include/functions.php');


	if(!empty($_GET['d'])){
		$sql = "DELETE FROM talumnos WHERE idtalumnos = '".$_GET['d']."'";
		$que = $conexion->query($sql);
	
		header("Location: index.php?i=$inicio&c=$cantidad&o=$orden&f=$forma");
	}
	
	$url_icos 	 = "images/icel/web/icos/";
	
	$sql		 = "SELECT * FROM ";
	$sql		.= "((((talumnos ";
	$sql		.= "LEFT JOIN tprospecto ON talumnos.idtalumnos = tprospecto.idtalumnos) ";
	$sql		.= "LEFT JOIN torigen ON tprospecto.idtorigen = torigen.idtorigen) ";
	$sql		.= "LEFT JOIN tnivelacademico ON tprospecto.idtnivelacademico = tnivelacademico.idtnivelacademico) ";
	$sql		.= "LEFT JOIN tcontacto_alu ON talumnos.idtalumnos = tcontacto_alu.idtalumnos AND tcontacto_alu.idttipocontacto = 1) ";
	$sql		.= "ORDER BY ";
	
	switch ($orden) {
		case "n":
			$sql		.= "talumnos.nombre_alu ";
			break;
		case "a":
			$sql		.= "tnivelacademico.idtnivelacademico ";
			break;
		case "f":
			$sql		.= "tprospecto.fecha_informes "; 
			break;
		default:
			$sql		.= "tprospecto.fecha_informes ";
			break;
	}
	
	if($forma == "d"){
		$sql .= "DESC ";
	}
	elseif ($forma == "a") {
		$sql .= "ASC ";
	}
	
	$sql		.= "LIMIT $inicio, $cantidad ";

	
	$que = $conexion->query($sql);	
	
	
	$estilo = 0;
	
	$pros_bar = 6;
	$acci_bar = 1;
	
	if($privilegios_emp==4){
		$eli 	= "<td class='sig_elm'><a href=\"".$_SERVER['PHP_SELF']."?i=$inicio&c=$cantidad&o=$orden&f=$forma&d=";
		$mi	= "\" onclick=\"return confirmar(mensaje='¿Realmente desea eliminar el registro ";
		$nar 	= "?')\"><i class='fa fa-minus-square'></i></a></td>";
		$pros_bar++;
		$acci_bar++;
	}
	
	while($row = $que->fetch_array()){
		if($row['idttipoalumno'] == 1){ // tipoalumno = 1 (Prospecto)
			if($estilo % 2){
				$tipo = "sigue1";
			}
		      	else{
				$tipo = "sigue2";
			}

			$folio		 = $row['idtalumnos'];
			$nombre_alu	 = $row['nombre_alu'];
			$paterno_alu	 = $row['paterno_alu'];
			$contacto_alu	 = $row['contacto_alu'];
			$nivel_int_img	 = $row['nivelacademico_img'];
			$nivel_interes	 = $row['nivelacademico'];
			$ico_origen	 = $row['ico_origen'];
			$origen		 = $row['origen'];
			$fecha_informes	 = $row['fecha_informes'];

			$registro 	.= "<tr class='$tipo'>";
			$registro 	.= "<td>" . $nombre_alu . " " . $paterno_alu ."</td><td><a href='tel://[$contacto_alu]' >$contacto_alu</a></td><td><img src='$url_icos$nivel_int_img' title='$nivel_interes' /></td><td class='cadurruti_ghost'><i class='fa $ico_origen' title='$origen'></i></td><td>$fecha_informes</td><td class='sig_dtl'><a class='fancybox fancybox.iframe' href='user.php?id=$folio'><i class='fa fa-list-alt'></i></a></td>";
			
			if($privilegios_emp==4){
				$registro .= $eli . $folio . $mi . $folio . $nar;
			}
			
			$registro 	.= "<tr>";

			$estilo++;
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset= UTF-8">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<link type="text/css" rel="stylesheet" href="css/sigue.css?v=2.0.0" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">


<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});
	
	function confirmar ( mensaje ) {
	  return confirm( mensaje );
	}
</script>


<script type="text/javascript">

              function valida_fecha(){
       
               f=document.reporte_prospecto;
               mensaje="";
                
                if ((f.inicio.value=="")&&(f.fin.value!="")){
                            mensaje += "\n    -Falta colocar la fecha Inicio";

                    }
                if ((f.inicio.value!="")&&(f.fin.value=="")){
                            mensaje += "\n    -Falta colocar la fecha Fin";
                    }
                    
                
                //Validar las fechas
                if ((f.inicio.value!="")&&(f.fin.value!="")){
                    var fecha=f.inicio.value;
                    var fecha2=f.fin.value;
                                       
                    var xYear=fecha.substring(0,4);  
                    var xMes=fecha.substring(5,7);  
                    var xDia=fecha.substring(8,11);  
                    
                    //alert(xYear);
                    //alert(xMes);
                    //alert(xDia);
                                        
                    var yYear=fecha2.substring(0,4);  
                    var yMes=fecha2.substring(5,7);  
                    var yDia=fecha2.substring(8,11);  
                    
                    if (xYear> yYear)  
                        {  
                           // return(true)  
                            mensaje += "\n    - La Fecha Inicio es mayor a la Fecha Fin";
                        }  
                        else  
                        {  
                          if (xYear == yYear)  
                          {   
                            if (xMes> yMes)  
                            {  
                               // return(true)  
                               mensaje += "\n    - La Fecha Inicio es mayor a la Fecha Fin";
                            }  
                            else  
                            {   
                                    if (xMes==yMes)  
                                    {  
                                          if (xDia> yDia)  
                                           // return(true); 
                                          mensaje += "\n    - La Fecha Inicio es mayor a la Fecha Fin";

                                     }  
                         
                                }  
                            }
                            
                        }
                        
                }
                    
                    
                    
                        if (mensaje!="") {
               mensaje ="_____________________________\n" +
                               mensaje;
                 alert(mensaje);

               //return !(opcion);
                    return false;
                 }
                else {
                    return true;
                 }
                                        
       }






     
 </script>

 <!-- <script type="text/javascript">
/*
       
$(function() {
    $( "#inicio" ).datepicker({
      dateFormat: "yy-mm-dd",
      changeMonth: true,
      changeYear: true
    });

$(function() {
    $( "#fin" ).datepicker({
      dateFormat: "yy-mm-dd",
      changeMonth: true,
      changeYear: true
    });

  });
});
       
*/

 </script> -->


</head>
<body screen_capture_injected="true">

<nav>
	<ul>
		<li class="home"><a href="#"><div class="logo"></div></a></li>
		<li><a href="#">Alumnos</a>
			<ul>
				<li><a href="#">Prospectos</a>
					<ul>
						<li><a class='fancybox fancybox.iframe' href='prospecto.php'>Nuevo</a></li>
					</ul>
				</li>
			</ul>
		</li>
		
		<li><a href="#"><?=$nombre_emp . " " . $paterno_emp;?></a>
			<ul class="mnu_usuario">
				<li><a href="salir.php">Salir</a></li>
			</ul>
		</li>
	</ul>
</nav>
<!-- Barra de funciones -->
<div class="sigue_bar">
        	
		<form method="GET" action="<?=$_SERVER['PHP_SELF'];?>">
			<select size="1" name="mostrar" onchange="top.location.href=this.options[this.selectedIndex].value">
				<option class="sigue2">Registros por Página</option>
				<option value="?i=<?=$inicio;?>&amp;c=10&amp;o=<?=$orden;?>&amp;f=<?=$forma;?>" class="sigue1">10</option>
				<option value="?i=<?=$inicio;?>&amp;c=20&amp;o=<?=$orden;?>&amp;f=<?=$forma;?>" class="sigue2">20</option>
				<option value="?i=<?=$inicio;?>&amp;c=30&amp;o=<?=$orden;?>&amp;f=<?=$forma;?>" class="sigue1">30</option>
				<option value="?i=<?=$inicio;?>&amp;c=40&amp;o=<?=$orden;?>&amp;f=<?=$forma;?>" class="sigue2">40</option>
			</select>
		</form>

		<div align = "right">



		<form name="reporte_prospecto" action="genera_reporte.php" method="post">
        
        <table>
       	
       	<td><h3>Busqueda Avanzada:</h3></td> 
       	<td><input type = "hidden" ></td>
		<td><input type = "hidden" ></td>
		<td><input type = "hidden" ></td>

        <td>Fecha Inicio: <input type="date" id="inicio" name="inicio" ></td>
      	<td>Fecha Final:  <input type="date" id="fin" name="fin" ></td>   

      	<td><input type = "hidden" ></td>
      	<td><input type = "hidden" ></td>
		<td><input type = "hidden" ></td>
		<td><input type = "hidden" ></td>
		<td><input type = "hidden" ></td>

        <td><input type="submit" onclick="return valida_fecha()" value ="Buscar"/></td>

    	</form>


      	<td><a class="fancybox fancybox.iframe sig_nvo" href="prospecto.php"><i class="fa fa-plus-square"></i> Nuevo Prospecto</a></td>
 		    	 

        </table>   

       	</div>

		
</div>



	<table class="sig_listado">
		<thead>
		<tr>
			<td colspan="<?=$pros_bar;?>">Prospectos [<?=$total;?>]</td>
		</tr>
		</thead>
		<tbody>
		<tr>
			
			<td><a href="<?=$_SERVER['PHP_SELF']."?i=".$inicio."&amp;c=".$cantidad."&amp;o=n&amp;f=".$forma_enl;?>">Nombre</a></td><td>Teléfono</td><td><a href="<?=$_SERVER['PHP_SELF']."?i=".$inicio."&amp;c=".$cantidad."&amp;o=a&amp;f=".$forma_enl;?>">Nivel</a></td><td class='cadurruti_ghost'>Origen</td><td><a href="<?=$_SERVER['PHP_SELF']."?i=".$inicio."&amp;c=".$cantidad."&amp;o=f&amp;f=".$forma_enl;?>">Fecha <span class="cadurruti_ghost">Informes</span></a></td><td colspan="<?=$acci_bar;?>">Acciones</td>
		</tr>
		
		<?=$registro;?>
		</tbody>
	</table>
	<div class="sig_paginador">
		<ul>
			<li><?=$inicia;?></li>
			<li><?=$anterior;?></li>
			<li><?=$siguiente;?></li>
			<li><?=$fin;?></li>
		</ul>
	</div>

</body>
</html>
