
  <?php


  $mess = $_GET['m'];
  $anio = $_GET['a'];
  if($mess == "" || $anio == ""){
      $anio = date("Y");
      $mess = date("n");
      
  }

  $meses = array(1 => "Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  $nmes = $meses[$mess];


      $ultimo = date("t",mktime(0, 0, 0, $mess, 1, $anio));
      if($mess == '12' || $mess == '1'){
          if($mess == '12'){
              $next = 1;
              $prev = $mess -1;
              $anion = $anio + 1;
              $aniop = $anio;
              $smes = $meses[$next];
              $ames = $meses[$prev];
          }
          if($mess == '1'){
              $next = $mess + 1;
              $prev = 12;
              $anion = $anio;
              $aniop = $anio -1;
              $smes = $meses[$next];
              $ames = $meses[$prev];       
          }
      }else{
          $next = $mess + 1;
          $prev = $mess - 1;    
          $aniop = $anio;
          $anion = $anio;
          $smes = $meses[$next];
          $ames = $meses[$prev];
      }
  	
  	$nav = "
  		<div class='dp_pec_nav dp_pec_nav_monthly'>
  			<a href='".$_SERVER['PHP_SELF']."?m=$prev&a=$aniop'>
  				<span class='prev_month'><i class='fa fa-chevron-left'></i><strong>$ames</strong></span>
  			</a>
  			<span class='actual_month'>".$nmes." $anio</span>
  			<a href='".$_SERVER['PHP_SELF']."?m=$next&a=$anion'>
  				<span class='next_month'><strong>$smes</strong><i class='fa fa-chevron-right'></i></span>
  			</a>
  		</div>

   var mypcc = '1';

   var durations = new Array();
   // var rectypes  = new Array();
   durations[9] = 15
   durations[10] = 30
   durations[1] = 0
   durations[5] = 15

  // login.php makes sure the session ID captured here is different for each
  // new login.  We maintain it here because most browsers do not have separate
  // cookie storage for different top-level windows.  This function should be
  // called just prior to invoking any server script that requires correct
  // session data.  onclick="top.restoreSession()" usually does the job.
  //
  var oemr_session_name = 'OpenEMR';
  var oemr_session_id   = 'rh6o1gqa3t0t9nk2kl4vqe38v0';
  //
  function restoreSession() {
   var ca = document.cookie.split('; ');
   for (var i = 0; i < ca.length; ++i) {
    var c = ca[i].split('=');
    if (c[0] == oemr_session_name && c[1] != oemr_session_id) {
     document.cookie = oemr_session_name + '=' + oemr_session_id + '; path=/';
    }
   }
   return true;
  }

   // This is for callback by the find-patient popup.
   function setpatient(pid, lname, fname, dob) {
    var f = document.forms[0];
    f.form_patient.value = lname + ', ' + fname;
    f.form_pid.value = pid;
    dobstyle = (dob == '' || dob.substr(5, 10) == '00-00') ? '' : 'none';
    document.getElementById('dob_row').style.display = dobstyle;
   }

   // This invokes the find-patient popup.
   function sel_patient() {
    dlgopen('find_patient_popup.php', '_blank', 500, 400);
   }

   // Do whatever is needed when a new event category is selected.
   // For now this means changing the event title and duration.
   function set_display() {
    var f = document.forms[0];
    var s = f.form_category;
    if (s.selectedIndex >= 0) {
     var catid = s.options[s.selectedIndex].value;
     var style_apptstatus = document.getElementById('title_apptstatus').style;
     var style_prefcat = document.getElementById('title_prefcat').style;
     if (catid == '2') { // In Office
      style_apptstatus.display = 'none';
      style_prefcat.display = '';
      f.form_apptstatus.style.display = 'none';
      f.form_prefcat.style.display = '';
     } else {
      style_prefcat.display = 'none';
      style_apptstatus.display = '';
      f.form_prefcat.style.display = 'none';
      f.form_apptstatus.style.display = '';
     }
    }
   }

   // Do whatever is needed when a new event category is selected.
   // For now this means changing the event title and duration.
   function set_category() {
    var f = document.forms[0];
    var s = f.form_category;
    if (s.selectedIndex >= 0) {
     var catid = s.options[s.selectedIndex].value;
     f.form_title.value = s.options[s.selectedIndex].text;
     f.form_duration.value = durations[catid];
     set_display();
    }
   }

   // Modify some visual attributes when the all-day or timed-event
   // radio buttons are clicked.
   function set_allday() {
    var f = document.forms[0];
    var color1 = '#777777';
    var color2 = '#777777';
    var disabled2 = true;
    if (document.getElementById('rballday1').checked) {
     color1 = '#000000';
    }
    if (document.getElementById('rballday2').checked) {
     color2 = '#000000';
     disabled2 = false;
    }
    document.getElementById('tdallday1').style.color = color1;
    document.getElementById('tdallday2').style.color = color2;
    document.getElementById('tdallday3').style.color = color2;
    document.getElementById('tdallday4').style.color = color2;
    document.getElementById('tdallday5').style.color = color2;
    f.form_hour.disabled     = disabled2;
    f.form_minute.disabled   = disabled2;
    f.form_ampm.disabled     = disabled2;
    f.form_duration.disabled = disabled2;
   }

   // Modify some visual attributes when the Repeat checkbox is clicked.
   function set_repeat() {
    var f = document.forms[0];
    var isdisabled = true;
    var mycolor = '#777777';
    var myvisibility = 'hidden';
    if (f.form_repeat.checked) {
     isdisabled = false;
     mycolor = '#000000';
     myvisibility = 'visible';
    }
    f.form_repeat_type.disabled = isdisabled;
    f.form_repeat_freq.disabled = isdisabled;
    f.form_enddate.disabled = isdisabled;
    document.getElementById('tdrepeat1').style.color = mycolor;
    document.getElementById('tdrepeat2').style.color = mycolor;
    document.getElementById('img_enddate').style.visibility = myvisibility;
   }

   // This is for callback by the find-available popup.
   function setappt(year,mon,mday,hours,minutes) {
    var f = document.forms[0];
    f.form_date.value = '' + year + '-' +
     ('' + (mon  + 100)).substring(1) + '-' +
     ('' + (mday + 100)).substring(1);
    f.form_ampm.selectedIndex = (hours >= 12) ? 1 : 0;
    f.form_hour.value = (hours > 12) ? hours - 12 : hours;
    f.form_minute.value = ('' + (minutes + 100)).substring(1);
   }

      // Invoke the find-available popup.
      function find_available(extra) {
          top.restoreSession();
          // (CHEMED) Conditional value selection, because there is no <select> element
          // when making an appointment for a specific provider
          var s = document.forms[0].form_provider;
          var f = document.forms[0].facility;
                      s = document.forms[0].form_provider.value;
              f = document.forms[0].facility.value;
                  var c = document.forms[0].form_category;
  	var formDate = document.forms[0].form_date;
          dlgopen('/imed/interface/main/calendar/find_appt_popup.php' +
                  '?providerid=' + s +
                  '&catid=' + c.options[c.selectedIndex].value +
                  '&facility=' + f +
                  '&startdate=' + formDate.value +
                  '&evdur=' + document.forms[0].form_duration.value +
                  '&eid=0' +
                  extra,
                  '_blank', 500, 400);
          //END (CHEMED) modifications
      }

  	";
  	$dias_semana = "<div class='dp_pec_dayname'>
  						<span>Domingo</span>
  				 </div>
  				 <div class='dp_pec_dayname'>
  						<span>Lunes</span>
  				 </div>	
  				 <div class='dp_pec_dayname'>
  						<span>Martes</span>
  				 </div>
  				 <div class='dp_pec_dayname'>
  						<span>Miércoles</span>
  				 </div>
  				 <div class='dp_pec_dayname'>
  						<span>Jueves</span>
  				 </div>
  				 <div class='dp_pec_dayname'>
  						<span>Viernes</span>
  				 </div>
  				 <div class='dp_pec_dayname'>
  						<span>Sábado</span>
  				 </div>
  	";
  	$diaa = "1";
  	while($diaa <= $ultimo){
  		$dia = date("D",mktime(0,0,0,$mess,$diaa,$anio)); # retorna el día de la semana en letras...
  		$fecha = date("d",mktime(0,0,0,$mess,$diaa,$anio)); #retorna el día del mes en 01/31
  		$dia_semana = date("w",mktime(0,0,0,$mess,$diaa,$anio)); #retorna el día de la semana en número

  		if($dia == "Sun"){
  			$domingo = " first-child";
  		}
  		else{
  			$domingo = "";
  		}
  		
  		if($fecha == "01"){
  			$i=0;
  			while($i != $dia_semana){
  				if($i == 0){
  					$dis_domingo = " first-child";
  				}
  				else{
  					$dis_domingo = "";
  				}
  				$calendario .= "<div class='dp_pec_date disabled$dis_domingo'>
  							<div class='dp_date_head'><span>&nbsp;</span></div>
  						</div>";
  				$i++;
  			}
  		}
  		
  		$calendario .= "
  			<div class='dp_pec_date$domingo' data-dppec-date='$anio-$mess-$diaa'>
  				<div class='dp_date_head'><span>$fecha</span></div>
  				
  			
  			</div>
  		";
  		$diaa++;
  	}
      echo "</tr>";
  ?>

  <body>
  <head>
  <link type="text/css" rel="stylesheet" href="css/calendario.css">

  </head>
  <body>

  <div class="dp_pec_wrapper dp_pec_monthly light" id="dp_pec_id872955989" style="width: 100% ">
  	<?=$nav;?>
  	<div style="clear:both;"></div>
  	<div class="dp_pec_content isDraggable">
  		<?=$dias_semana;?>
  		<?=$calendario;?>
  		<div class="clear"></div>
  	</div>
  </div>
  l
