<?php

//    Fit file reader and analyzer: profilo_file_event.php
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

class name_event{
	
	public $id;
	public $name;

	public function __construct($fn,&$tf,&$data){
		$this->id=$fn;
		switch($fn){
			case 253: $this->name="timestamp"; $tf=1; $data="data_parent"; break;
			case 0: $this->name="event"; $data="data_event"; break;
			case 1: $this->name="event_type"; $data="data_event_type"; break;
			case 2: $this->name="data16"; $data="data_parent"; break;
			case 3: $this->name="data"; $data="data_parent"; break;
			case 4: $this->name="event_group"; $data="data_parent"; break;
			default: $this->name="vuoto" ; $data="data_parent";
		}
	}

	public function getName_event(){
		return $this->name;
	}
	
}

class data_event extends data_parent{
	
	public function __construct($n){
		$this->numero=$n;
		switch($n){
			case 0: $this->valore="timer"; break;
			case 3: $this->valore="workout"; break;
			case 4: $this->valore="workout_step"; break;
			case 5: $this->valore="power_down"; break;
			case 6: $this->valore="power_up"; break;
			case 7: $this->valore="off_course"; break;
			case 8: $this->valore="session"; break;
			case 9: $this->valore="lap"; break;
			case 10: $this->valore="course_point"; break;
			case 11: $this->valore="battery"; break;
			case 12: $this->valore="virtual_partner_pace"; break;
			case 15: $this->valore="speed_high_alert"; break;
			case 16: $this->valore="speed_low_alert"; break;
			case 19: $this->valore="power_high_alert"; break;
			case 20: $this->valore="power_low_alert"; break;
			case 22: $this->valore="battery_low"; break;
			case 23: $this->valore="time_duration_alert"; break;
			case 24: $this->valore="distance_duration_alert"; break;
			case 25: $this->valore="calorie_duration_alert"; break;
			case 26: $this->valore="activity"; break;
			case 28: $this->valore="lenght"; break;
			case 32: $this->valore="user_marker"; break;
			case 33: $this->valore="sport_point"; break;
			case 36: $this->valore="calibration"; break;
			default: $this->valore="evento non in lista , $n";
		}
		return true;
	}
}

class data_event_type extends data_parent{
	
	public function __construct($n){
		$this->numero=$n;
		switch($n){
			case 0: $this->valore="start"; break;
			case 1: $this->valore="stop"; break;
			case 2: $this->valore="consecutive_depreciated"; break;
			case 3: $this->valore="marker"; break;
			case 4: $this->valore="stop_all"; break;
			case 5: $this->valore="begin_depreciated"; break;
			case 6: $this->valore="end_depreciated"; break;
			case 7: $this->valore="end_all_depreciated"; break;
			case 8: $this->valore="stop_disable"; break;
			case 9: $this->valore="stop_disable_all"; break;
			default: $this->valore="tipo evento non in lista , $n";
		}
		return true;
	}
}

class data_event_grp extends data_parent{	//CLASSE NON UTILIZZATA, POCO CHIARO IL SIGNIFICATO
	
	public function __construct($n){
		$this->numero=$n;
		switch($n){

			default: $this->valore="tipo evento non in lista , $n";
		}
		return true;
	}
}

?>
