<?php

//    Fit file reader and analyzer: profilo.php
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
//    along with this program.  If not, see <http://www.gnu.org/licenses/>.


include 'profilo_file_id.php'; //definizioni tipiche della sezione file_id
include 'profilo_file_creator.php'; //definizioni tipiche della sezione file_creator
include 'profilo_file_event.php'; //definizioni tipiche della sezione event
include 'profilo_dev_info.php'; //definizioni tipiche della device_info
include 'profilo_user_data.php'; //definizioni tipiche dell'utente
include 'profilo_record.php'; //definizioni tipiche di un record
include 'profilo_lap.php'; //definizioni tipiche di un lap
include 'profilo_source.php'; //definizioni tipiche del campo source
include 'profilo_session.php'; //definizioni tipiche della sessione

function field_type_conv($n){

	$array=[0,0,0];
	switch($n)
	{	
		case 0 : $array[0]=1; $array[1]="C"; $array[2]="FF"; break;
		case 1 : $array[0]=1; $array[1]="c"; $array[2]="7F"; break;
		case 2 : $array[0]=1; $array[1]="C"; $array[2]="FF"; break;
		case 3 : $array[0]=2; $array[1]="s"; $array[2]="7FFF"; break;
		case 4 : $array[0]=2; $array[1]="S"; $array[2]="FFFF"; break;
		case 5 : $array[0]=4; $array[1]="l"; $array[2]="7FFFFFFF"; break;
		case 6 : $array[0]=4; $array[1]="L"; $array[2]="FFFFFFFF"; break;
		case 7 : $array[0]=1; $array[1]="C"; $array[2]="00"; break;
		case 8 : $array[0]=4; $array[1]="f"; $array[2]="FFFFFFFF"; break;
		case 9 : $array[0]=8; $array[1]="d"; $array[2]="FFFFFFFFFFFFFFFF"; break;
		case 10 : $array[0]=1; $array[1]="C"; $array[2]="00"; break;
		case 11 : $array[0]=2; $array[1]="S"; $array[2]="0000"; break;
		case 12 : $array[0]=4; $array[1]="V"; $array[2]="00000000"; break;
		case 13 : $array[0]=1; $array[1]="C"; $array[2]="FF"; break;
		default: echo "formato codice sbagliato , $n <br>";
	}
	return $array;	
}



class data_parent{ //serve per dare a tutte le classi di conversione il metodo di lettura uguale per tutti
	public $numero;
	public $valore;

	public function __construct($n){
		$this->numero=$n;
		$this->valore=$n;
		return true;
	}

	public function get_data_conv(){
		return $this->valore;
	}
}

function file_type_field_name($ft,$fn,&$tf,&$data){

	$risultato=array("vuoto","vuoto");

	switch($ft){

	case 0 :	$risultato[0]="file_id"; 
			if ($fn>=0){
				$campo=new name_file_id($fn,$tf,$data); 
				$risultato[1]=$campo->getName_fileid_fielddef();		
			} break;
	case 1 :	$risultato[0]="capabilities"; break;
	case 2 :	$risultato[0]="device_settings"; break;
	case 3 :	$risultato[0]="user_profile"; break;
	case 4 :	$risultato[0]="hrm_profile"; break;
	case 5 :	$risultato[0]="sdm_profile"; break;
	case 6 :	$risultato[0]="bike_profile"; break;
	case 7 :	$risultato[0]="zones_target"; break;
	case 8 :	$risultato[0]="hr_zone"; break;
	case 9 :	$risultato[0]="power_zone"; break;
	case 10 :	$risultato[0]="met_zone"; break;
	case 12 :	$risultato[0]="sport"; break;
	case 15 :	$risultato[0]="goal"; break;
	case 18 :	$risultato[0]="session"; 
			if ($fn>=0){
				$campo=new name_session($fn,$tf,$data); 
				$risultato[1]=$campo->getName_session();		
			}    break;
	case 19 :	$risultato[0]="lap"; 
			if ($fn>=0){
				$campo=new name_lap($fn,$tf,$data); 
				$risultato[1]=$campo->getName_lap();		
			}   break;
	case 20 :	$risultato[0]="record"; 
			if ($fn>=0){
				$campo=new name_record($fn,$tf,$data); 
				$risultato[1]=$campo->getName_record();		
			}  break;
	case 21 :	$risultato[0]="event"; 
			if ($fn>=0){
				$campo=new name_event($fn,$tf,$data); 
				$risultato[1]=$campo->getName_event();		
			}  break;
	case 22 :	$risultato[0]="source"; 
			if ($fn>=0){
				$campo=new name_source($fn,$tf,$data); 
				$risultato[1]=$campo->getName_source();		
			}   break; 
	case 23 :	$risultato[0]="device_info"; 
			if ($fn>=0){
				$campo=new name_dev_info($fn,$tf,$data); 
				$risultato[1]=$campo->getName_dev_info();		
			}   break;
	case 26 :	$risultato[0]="workout"; break;
	case 27 :	$risultato[0]="workout_step"; break;
	case 28 :	$risultato[0]="schedule"; break;
	case 29 :	$risultato[0]="location"; break; 
	case 30 :	$risultato[0]="weight_scale"; break;
	case 31 :	$risultato[0]="course"; break;
	case 32 :	$risultato[0]="course_point"; break;
	case 33 :	$risultato[0]="totals"; break;
	case 34 :	$risultato[0]="activity"; break;
	case 35 :	$risultato[0]="software"; break;
	case 37 :	$risultato[0]="file_capabilities"; break;
	case 38 :	$risultato[0]="mesg_capabilities"; break;
	case 39 :	$risultato[0]="field"; break;
	case 49 :	$risultato[0]="file_creator"; 
			if ($fn>=0){
				$campo=new name_file_creat($fn,$tf,$data); 
				$risultato[1]=$campo->getName_filecreat();		
			}  break;
	case 51 :	$risultato[0]="blood_pressure"; break;
	case 53 :	$risultato[0]="speed_zone"; break;
	case 55 :	$risultato[0]="monitoring"; break;
	case 72 :	$risultato[0]="training_file"; break;
	case 78 :	$risultato[0]="hrv"; break;
	case 79 :	$risultato[0]="user_data"; 
			if ($fn>=0){
				$campo=new name_user_data($fn,$tf,$data); 
				$risultato[1]=$campo->getName_userdata();		
			}  break;
	case 101 :	$risultato[0]="length"; break;
	case 103 :	$risultato[0]="monitoring_info"; break;
	case 104 :	$risultato[0]="battery"; break; 
	case 105 :	$risultato[0]="pad"; break;
	case 106 :	$risultato[0]="slave_device"; break;
	case 131 :	$risultato[0]="cadence_zone"; break;
	case 145 :	$risultato[0]="memo_glob";

	}

	return $risultato;
}

?>
