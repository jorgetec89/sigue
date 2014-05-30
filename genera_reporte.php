<?

$fechai=$_POST['inicio'];
$fechaf=$_POST['fin'];

$fechai.=" 00:00:01";
$fechaf.=" 23:59:59";


/*
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=Reporte_Fecha_Especifica.xls");
header("Pragma: no-cache");
header("Expires: 0");
*/


?>

<!DOCTYPE html>

    <html>
      <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
        </head>
 
              <body>

                <div class="container">
   
<?php

      $con = mysql_connect("localhost","root","icel.1c31");
                   mysql_set_charset('utf8',$con);
                 
                 if (!$con)  {
                   die('Could not connect: ' . mysql_error());
                 }
                 mysql_select_db("sigue", $con);
                   $contador=0;    

                     $sql  = "SELECT * FROM (((talumnos LEFT JOIN tprospecto ON talumnos.idtalumnos = tprospecto.idtalumnos) LEFT JOIN torigen ON tprospecto.idtorigen = torigen.idtorigen) LEFT JOIN tnivelacademico ON tprospecto.idtnivelacademico = tnivelacademico.idtnivelacademico) LEFT JOIN tcontacto_alu ON talumnos.idtalumnos = tcontacto_alu.idtalumnos AND tcontacto_alu.idttipocontacto WHERE fecha_informes BETWEEN '$fechai' AND '$fechaf' AND idttipocontacto = 1";
                     $query_consulta = mysql_query($sql); 
                               // echo "Contenido de consulta" . $query_consulta . "<br>";      
                     $conteo = mysql_num_rows($query_consulta); 
            
                     

                $tabla= "<table class = 'table table-striped'>
                              <thead>
                              <tr style='background-color:#066DCE; color:#ffffff; '>
                              
                              <td align='center'><strong>No.</strong></td>
                              <td align='center'><strong>Nombre</strong></td>                              
                              <td align='center'><strong>Apellido Paterno</strong></td> 
                              <td align='center'><strong>Apellido Materno</strong></td> 
                              <td align='center'><strong>Telefono</strong></td> 
                              <td align='center'><strong>Nivel</strong></td>
                              <td align='center'><strong>Origen</strong></td>
                              <td align='center'><strong>Fecha Informes</strong></td>
                                                            
                              </tr>
                             
                              </thead>";   

                              echo "<h2> Numero de Registros: ". $conteo . "</h2> <br>";                                             
                                 
                                 
                                while($row = mysql_fetch_array($query_consulta)) 

                                {


                                $fechacompar=$fecha;
                                $fname_prospecto=$row['nombre_alu'];
                                $lname_prospecto=$row['paterno_alu'];
                                $materno_prospecto=$row['materno_alu'];                      
                                $fecha = $row['fecha_informes'];
                                $tori = $row['idtorigen'];
                                $contacto = $row['contacto_alu'];                           
                                $nivel_academico = $row['nivelacademico'];
                                $origen = $row['origen'];
                                $contador=$contador+1;
                                  
                                  $tabla.="
                                      <tr $tabla_css>

                                              <td>$contador</td>
                                              <td>$fname_prospecto</td>
                                              <td>$lname_prospecto</td>
                                              <td>$materno_prospecto</td>
                                              <td>$contacto</td>
                                              <td>$nivel_academico</td>
                                              <td>$origen</td>
                                              <td>$fecha</td>

                                              
                                      </tr>";
                                             
                                                                                          
                                                                       
                 }  //while row distin
                                
                                 $tabla.="</table>";
                                 $estilo=" <style> 
                                
                                            .reg1{
                                
                                            background-color: #eee;
                                
                                                }
                                
                                            .reg2{
                                
                                            background-color: #ddd;
                                
                                                }
                                           </style>";


                                    echo $estilo;
                                   echo $tabla;
    

      
                            ?>

</div>
                    </body>

       </html>      
