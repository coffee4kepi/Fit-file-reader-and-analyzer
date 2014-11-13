<html>

<!--   Fit file reader and analyzer: pagina_analyze.php
//    Copyright (C) 2014  Ugolotti Aldo coffee4kepi@gmail.com
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation, either version 3 of the License, or
//    any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
-->
	<head>
		<link rel="stylesheet" type="text/css" href="./style_analisi.css">	
		<link type="text/css" rel="stylesheet" href="../Rickshaw/rickshaw.min.css">
		<script src="../Rickshaw/vendor/d3.min.js"></script>
		<script src="../Rickshaw/vendor/d3.layout.min.js"></script>
		<script src="../Rickshaw/rickshaw.min.js"></script>
		<script src="./disegna_func.js"></script>
	</head>

	<body>

		<?php

		include 'fit_class.php';


		
		$DIR="../fit_files/";
		$path="";
		$path=$_POST['filename'];
		//$path='497H1945.FIT';
		$path=$DIR.$path;

		$file=new fit_file($path);

		//STAMPO I TOTALI -- record session numero 18
		$totr=count($file->record);

		for ($i=0;$i<$totr;$i++){
			if ($file->record[$i]->__get('global_code_type')==18){
				$record_num=$i;
				break;
			}	
		}
		$tot=count($file->record[$record_num]->field);
		$key=search_key($file,2,$record_num,$tot);
		$start_time=$file->record[$record_num]->field[$key]->data[0]->get_data_conv();
		$start_time=data_readable($start_time);
		$key=search_key($file,8,$record_num,$tot);
		$durata=$file->record[$record_num]->field[$key]->data[0]->get_data_conv();
		$key=search_key($file,9,$record_num,$tot);
		$distanza=$file->record[$record_num]->field[$key]->data[0]->get_data_conv();
		$key=search_key($file,14,$record_num,$tot);
		$vel=$file->record[$record_num]->field[$key]->data[0]->get_data_conv();
		$vel2_min=(int)((1/$vel)*60);
		$vel2_sec=(int)(((1/$vel)*60-(int)((1/$vel)*60))*60);
		$vel2=$vel2_min.":".$vel2_sec;
		$key=search_key($file,5,$record_num,$tot);
		$sport=$file->record[$record_num]->field[$key]->data[0]->get_data_conv();
		$distanza=number_format($distanza);
		$vel=number_format($vel,1);
		echo "<p align='center'>Inizio: <b>$start_time</b> - durata [min]: <b>$durata</b> - distanza [m]: <b>$distanza</b> - vel_media [km/h]: <b>$vel</b> - vel_media [min/km]: <b>$vel2</b> - sport: <b>$sport</b></p>";
		//STAMPO I LAP ---codice
		$lap=$file->getLAP();
		$num_lap=count($lap);
		if (count($lap[0])==7) {$alt_bool=1;} else {$alt_bool=0;} //controlla se ci sono i dati di altimetria
		if (!$alt_bool) $string=""; else $string="<td><b>d+</b></td><td><b>d-</b></td><td><b>p%</b></td>";
		echo "<div id='total_tab_container'><table id='total_tab' border='1'>";
		echo "<tr><td><b>Giro</b></td><td><b>Lunghezza [m]</b></td><td><b>Durata [min]</b></td><td><b>Vel_media [km/h]</b></td><td><b>Vel_media [min/km]</b></td>$string</tr>";
		for ($l=0;$l<$num_lap;$l++) {
			$text1=$lap[$l][0];
			$text2=$lap[$l][1];
			$text3=number_format($lap[$l][2],1);
			$text6=$lap[$l][3];
			if (!$alt_bool) $string=""; else{
				$text4=$lap[$l][4];
				$text5=$lap[$l][5];
				$text7=number_format($lap[$l][6],2);
				$string="<td>$text4</td><td>$text5</td><td>$text7</td>";
			}
			echo "<tr><td>$l</td><td>$text1</td><td>$text2</td><td>$text3</td><td>$text6</td>$string</tr>";
		}
		echo "</table></div>";

		$dati_grafico_lap_nv=array();
		$dati_grafico_lap_nd=array();
		$dati_grafico_lap_tv=array();
		$dati_grafico_lap_nap=array();
		$dati_grafico_lap_nam=array();
		$dati_grafico_lap_np=array();
		$dati_grafico_lap_tp=array();

		for ($i=0;$i<$num_lap;$i++){
			$dati_grafico_lap_nv[$i]=array('x' => $i, 'y' => $lap[$i][2]);
			if ($i==0) $dati_grafico_lap_tv[$i]=array('x' => $lap[$i][1], 'y' => $lap[$i][2]);
			else $dati_grafico_lap_tv[$i]=array('x' => $lap[$i-1][1]+$lap[$i][1], 'y' => $lap[$i][2]);
			$dati_grafico_lap_nd[$i]=array('x' => $i, 'y' => $lap[$i][0]);
			if ($alt_bool==1) {
				$dati_grafico_lap_nap[$i]=array('x' => $i, 'y' => $lap[$i][4]);
				$dati_grafico_lap_nam[$i]=array('x' => $i, 'y' => $lap[$i][5]);
				$dati_grafico_lap_np[$i]=array('x' => $i, 'y' => $lap[$i][6]);
				if ($i==0) $dati_grafico_lap_tp[$i]=array('x' => $lap[$i][1], 'y' => $lap[$i][6]);
				else $dati_grafico_lap_tp[$i]=array('x' => $lap[$i-1][1]+$lap[$i][1], 'y' => $lap[$i][6]);
			}else {
				$dati_grafico_lap_nap[$i]=array('x' => $i, 'y' => NULL);
				$dati_grafico_lap_nam[$i]=array('x' => $i, 'y' => NULL);
				$dati_grafico_lap_np[$i]=array('x' => $i, 'y' => NULL);
				if ($i==0) $dati_grafico_lap_tp[$i]=array('x' => $lap[$i][1], 'y' => NULL);
				else $dati_grafico_lap_tp[$i]=array('x' => $lap[$i-1][1]+$lap[$i][1], 'y' => NULL);
			}
		}


		//RIEMPIO I VETTORI CON I DATI DEL GPS
		$dati_gps=$file->getGPS();

		//parsing dei vettori per essere dati in pasto al grafico javascript
		$dati_grafico_gps_dv=array();
		$dati_grafico_gps_tv=array();
		$dati_grafico_gps_da=array();
		$dati_grafico_gps_ta=array();
		$dati_grafico_gps_dp=array();
		$dati_grafico_gps_tp=array();

		$num_dati=count($dati_gps);
		for ($i=0;$i<$num_dati;$i++){
			$dati_grafico_gps_dv[$i]=array('x' => $dati_gps[$i][1]/1000, 'y' => $dati_gps[$i][2]);
			$dati_grafico_gps_tv[$i]=array('x' => $dati_gps[$i][0], 'y' => $dati_gps[$i][2]);
			if ($alt_bool==1) {
				$dati_grafico_gps_da[$i]=array('x' => $dati_gps[$i][1]/1000, 'y' => $dati_gps[$i][4]);
				$dati_grafico_gps_dp[$i]=array('x' => $dati_gps[$i][1]/1000, 'y' => $dati_gps[$i][5]);
				$dati_grafico_gps_ta[$i]=array('x' => $dati_gps[$i][0], 'y' => $dati_gps[$i][4]);
				$dati_grafico_gps_tp[$i]=array('x' => $dati_gps[$i][0], 'y' => $dati_gps[$i][5]);
				
			}else{
				$dati_grafico_gps_da[$i]=array('x' => $dati_gps[$i][1]/1000, 'y' => NULL);
				$dati_grafico_gps_dp[$i]=array('x' => $dati_gps[$i][1]/1000, 'y' => NULL);
				$dati_grafico_gps_ta[$i]=array('x' => $dati_gps[$i][0], 'y' => NULL);
				$dati_grafico_gps_tp[$i]=array('x' => $dati_gps[$i][0], 'y' => NULL);
				
			}
		}


		?>
	<br>
		
	<div id="time_switch" align="center">

		<form  action="" valign="middle">
			<label for="button_tempo">MOSTRA SULL'ASSE X :</label>
			<input type="radio" id="button_distanza" name="display" onclick="cambio_grafico();"> 
			<label for="button_distanza">distanza</label>
			<input type="radio" id="button_tempo" name="display" onclick="cambio_grafico();"> 
			<label for="button_tempo">tempo</label>
		</form>
	</div>
	<div id="chart_lap_container">
		<div id="chart_lap_container1">
			<div id="title_lap1"></div>
			<div id="lap1"></div>
			<div id="y_lap_axis1"></div>
			<div id="x_lap_axis1"></div>
		</div>
		<div id="chart_lap_container2">
			<div id="title_lap2"></div>
			<div id="lap2"></div>
			<div id="y_lap_axis2"></div>
			<div id="x_lap_axis2"></div>
		</div>		
	</div>

	<div id="chart_gps_container">
		<div id="chart_gps_container1">
			<div id="title_gps1"></div>
			<div id="gps1"></div>
			<div id="y_gps_axis1"></div>
			<div id="x_gps_axis1"></div>
		</div>
		<div id="chart_gps_container2">
			<div id="title_gps2"></div>
			<div id="gps2"></div>
			<div id="y_gps_axis2"></div>
			<div id="x_gps_axis2"></div>
		</div>	
		<div id="chart_gps_container3">
			<div id="title_gps3"></div>
			<div id="gps3"></div>
			<div id="y_gps_axis3"></div>
			<div id="x_gps_axis3"></div>
		</div>	
	</div>

	<script>
	var alt = <?php echo json_encode($alt_bool); ?> ;

	var y_tab_height=document.getElementById('total_tab_container').offsetHeight;
	var y_tab_pos=document.getElementById('total_tab_container').offsetTop;
	var y_graph=y_tab_height+y_tab_pos+20;
	document.getElementById('time_switch').style.top=y_graph+'px';
	y_graph=y_graph+60;
	document.getElementById('chart_lap_container').style.top=y_graph+'px';
	if (alt==1) var y_graphlap_height=610; else var y_graphlap_height=310;
	var y_graphlap_pos=document.getElementById('chart_lap_container').offsetTop;
	y_graph=y_graphlap_height+y_graphlap_pos+20;
	document.getElementById('chart_gps_container').style.top=y_graph+'px';

	var datalap_nv =<?php echo json_encode($dati_grafico_lap_nv); ?> ;
	var datalap_nd =<?php echo json_encode($dati_grafico_lap_nd); ?> ;
	var datalap_tv =<?php echo json_encode($dati_grafico_lap_tv); ?> ;
	//var datalap_nap =<?php echo json_encode($dati_grafico_lap_nap); ?> ;
	//var datalap_nam =<?php echo json_encode($dati_grafico_lap_nam); ?> ;
	var datalap_np =<?php echo json_encode($dati_grafico_lap_np); ?> ;
	var datalap_tp =<?php echo json_encode($dati_grafico_lap_tp); ?> ;
	


	document.getElementById('button_distanza').checked=true;

	document.getElementById('title_lap1').innerHTML='VELOCITA [min/km] VS N.GIRO';
	disegna("#lap1",1000,250,'bar','orange',datalap_nv,'velocita','x_lap_axis1',min_km,'y_lap_axis1');
	if (alt==1) {
		document.getElementById('title_lap2').innerHTML='PENDENZA [%] VS N.GIRO';
		disegna("#lap2",1000,250,'bar','red',datalap_np,'pendenza','x_lap_axis2',neutro,'y_lap_axis2');
	}

	var datagps_dv =<?php echo json_encode($dati_grafico_gps_dv); ?> ;
	var datagps_tv =<?php echo json_encode($dati_grafico_gps_tv); ?> ;
	var datagps_dp =<?php echo json_encode($dati_grafico_gps_dp); ?> ;
	var datagps_tp =<?php echo json_encode($dati_grafico_gps_tp); ?> ;
	var datagps_da =<?php echo json_encode($dati_grafico_gps_da); ?> ;
	var datagps_ta =<?php echo json_encode($dati_grafico_gps_ta); ?> ;


	document.getElementById('title_gps1').innerHTML='VELOCITA [min/km] VS DISTANZA';
	disegna("#gps1",1200,250,'line','green',datagps_dv,'velocita','x_gps_axis1',min_km,'y_gps_axis1');
	if (alt==1) {
		document.getElementById('chart_lap_container').offsetHeight= 900;
		document.getElementById('title_gps2').innerHTML='PENDENZA [%] VS DISTANZA';
		disegna("#gps2",1200,250,'line','blue',datagps_dp,'pendenza','x_gps_axis2',neutro,'y_gps_axis2');
		document.getElementById('title_gps3').innerHTML='ALTITUDINE [m] VS DISTANZA';
		disegna("#gps3",1200,250,'line','gray',datagps_da,'altitudine','x_gps_axis3',neutro,'y_gps_axis3');
	}

	function cambio_grafico(){

		bool=document.getElementById('button_distanza').checked;
		if (bool==false){
			b=true; //dati in funzione del TEMPO



		}else{
			b=false; //dati in funzione della DISTANZA


		}
		return true;
	}

	function min_km(y){
				var y_min=parseInt(60/y);
				var y_sec=((60/y-y_min)*60).toFixed(0);
				var stringa=y_min.toString()+':'+y_sec.toString();
				return stringa;
			};

	function neutro(y){
				return y.toFixed(2);
			};

//	function distanza(x){
//				x=x/1000;
//				return x.toFixed(2);
//			};


	</script>



	
	</body>
</html>
