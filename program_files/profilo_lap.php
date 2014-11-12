<?php

//    Fit file reader and analyzer: profilo_lap.php
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

class name_lap{
	
	public $id;
	public $name;

	public function __construct($fn,&$tf,&$data){
		$this->id=$fn;
		switch($fn){
			case 254: $this->name="msg_index"; $data="data_parent"; break;
			case 253: $this->name="timestamp"; $tf=1; $data="data_parent"; break;
			case 0: $this->name="event"; $data="data_event"; break;
			case 1: $this->name="event_type"; $data="data_event_type"; break;
			case 2: $this->name="start_time"; $tf=1; $data="data_parent"; break;
			case 3: $this->name="start_lat"; $data="data_posizione"; break;
			case 4: $this->name="start_long"; $data="data_posizione"; break;
			case 5: $this->name="end_lat"; $data="data_posizione"; break;
			case 6: $this->name="end_long"; $data="data_posizione"; break;
			case 7: $this->name="total_elapsed_time"; $data="data_time_min"; break;
			case 8: $this->name="total_timer_time"; $data="data_time_min"; break;
			case 9: $this->name="total_distance [m]"; $data="data_distanza"; break;
			case 10: $this->name="numero pedalate/passi"; $data="data_parent"; break;
			case 11: $this->name="calorie totali"; $data="data_parent"; break;
			case 13: $this->name="vel media"; $data="data_speed"; break;
			case 14: $this->name="vel max"; $data="data_speed"; break;
			case 15: $this->name="pulsazioni medie"; $data="data_parent"; break;
			case 16: $this->name="pulsazioni massime"; $data="data_parent"; break;
			case 17: $this->name="passo medio"; $data="data_parent"; break;
			case 18: $this->name="passo migliore"; $data="data_parent"; break;
			case 19: $this->name="potenza media"; $data="data_parent"; break;
			case 20: $this->name="potenza massima"; $data="data_parent"; break;
			case 21: $this->name="ascesa [m]"; $data="data_parent"; break;
			case 22: $this->name="discesa [m]"; $data="data_parent"; break;
			case 23: $this->name="intensità"; $data="data_parent"; break;
			case 24: $this->name="lap_trigger"; $data="data_lap_trigger"; break;
			case 25: $this->name="sport"; $data="data_sport"; break;
			case 26: $this->name="event_grp"; $data="data_parent"; break;
			case 32: $this->name="num_lengths"; $data="data_parent"; break;
			case 33: $this->name="norm_power"; $data="data_parent"; break;
			case 39: $this->name="sub_sport"; $data="data_parent"; break;
			case 40: $this->name="num_active_length"; $data="data_parent"; break;
			case 41: $this->name="total_work"; $data="data_parent"; break;
			case 42: $this->name="quota media"; $data="data_altitudine"; break;
			case 43: $this->name="quota massima"; $data="data_altitudine"; break;
			case 44: $this->name="accuratezza gps"; $data="data_parent"; break;
			case 45: $this->name="pendenza media"; $data="data_ver"; break;
			case 46: $this->name="pend media +"; $data="data_ver"; break;
			case 47: $this->name="pend media -"; $data="data_ver"; break;
			case 48: $this->name="pend max +"; $data="data_ver"; break;
			case 49: $this->name="pend max -"; $data="data_ver"; break;
			case 50: $this->name="temp media"; $data="data_parent"; break;
			case 51: $this->name="temp max"; $data="data_parent"; break;
			case 52: $this->name="tot_mov_time"; $data="data_parent"; break;
			case 61: $this->name="numero ripetizione"; $data="data_parent"; break;
			case 62: $this->name="quota minima"; $data="data_altitudine"; break;
			case 63: $this->name="pulsazioni minime"; $data="data_parent"; break;
			case 71: $this->name="wkt_step_index"; $data="data_parent"; break;
			case 74: $this->name="opponent score"; $data="data_parent"; break;
			case 75: $this->name="numero bracciate"; $data="data_parent"; break;
			case 76: $this->name="zona num"; $data="data_parent"; break;
			case 83: $this->name="player_score"; $data="data_parent"; break;
			default: $this->name="vuoto" ; $data="data_parent";
		}
	}

	public function getName_lap(){
		return $this->name;
	}
	
}

class data_time_min extends data_parent{

	public function __construct($n){
		$this->numero=$n;
		$n=$n/1000;
		$sec=$n-(int)($n/60)*60;
		$min=($n-$sec)/60;
		$this->valore="$min:$sec";
		return true;
	}
}

class data_sport extends data_parent{
	
	public function __construct($n){
		$this->numero=$n;
		switch($n){
			case 0: $this->valore="generic"; break;
			case 1: $this->valore="running"; break;
			case 2: $this->valore="cycling"; break;
			case 3: $this->valore="transition"; break;
			case 5: $this->valore="swimming"; break;
			case 18: $this->valore="multisport"; break;
			case 254: $this->valore="all"; break;
			default: $this->valore="da inserire, numero $n";
		}
		return true;
	}
}

class data_lap_trigger extends data_parent{
	
	public function __construct($n){
		$this->numero=$n;
		switch($n){
			case 0: $this->valore="manual"; break;
			case 1: $this->valore="time"; break;
			case 2: $this->valore="distance"; break;
			case 3: $this->valore="start_pos"; break;
			case 4: $this->valore="lap_pos"; break;
			case 5: $this->valore="waypoint_pos"; break;
			case 6: $this->valore="marked_pos"; break;
			case 7: $this->valore="session_end"; break;
			default: $this->valore="da inserire, numero $n";
		}
		return true;
	}
}

?>
