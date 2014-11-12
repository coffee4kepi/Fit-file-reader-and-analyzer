<?php

//    Fit file reader and analyzer: profilo_session.php
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

class name_session{
	
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
			case 5: $this->name="sport"; $data="data_sport"; break;
			case 6: $this->name="sub_sport"; $data="data_parent"; break;
			case 7: $this->name="total_elapsed_time"; $data="data_time_min"; break;
			case 8: $this->name="total_timer_time"; $data="data_time_min"; break;
			case 9: $this->name="total_distance [m]"; $data="data_distanza"; break;
			case 10: $this->name="numero pedalate/passi"; $data="data_parent"; break;
			case 11: $this->name="calorie totali"; $data="data_parent"; break;
			case 14: $this->name="vel media"; $data="data_speed"; break;
			case 15: $this->name="vel max"; $data="data_speed"; break;
			case 16: $this->name="pulsazioni medie"; $data="data_parent"; break;
			case 17: $this->name="pulsazioni massime"; $data="data_parent"; break;
			case 18: $this->name="cadenza media"; $data="data_parent"; break;
			case 19: $this->name="cadenza massima"; $data="data_parent"; break;
			case 20: $this->name="potenza media"; $data="data_parent"; break;
			case 21: $this->name="potenza massima"; $data="data_parent"; break;
			case 22: $this->name="ascesa tot [m]"; $data="data_parent"; break;
			case 22: $this->name="discesa tot [m]"; $data="data_parent"; break;
			case 23: $this->name="intensità"; $data="data_parent"; break;
			case 24: $this->name="lap_trigger"; $data="data_lap_trigger"; break;
			case 25: $this->name="first_lap_index"; $data="data_parent"; break;
			case 26: $this->name="num_laps"; $data="data_parent"; break;
			case 27: $this->name="event_grp"; $data="data_parent"; break;
			case 28: $this->name="trigger"; $data="data_parent"; break;
			case 32: $this->name="num_lengths"; $data="data_parent"; break;
			case 36: $this->name="int_factor"; $data="data_parent"; break;
			case 33: $this->name="norm_power"; $data="data_parent"; break;
			case 46: $this->name="num_active_length"; $data="data_parent"; break;
			case 48: $this->name="total_work"; $data="data_parent"; break;
			case 49: $this->name="quota media"; $data="data_altitudine"; break;
			case 50: $this->name="quota massima"; $data="data_altitudine"; break;
			case 51: $this->name="accuratezza gps"; $data="data_parent"; break;
			case 52: $this->name="pendenza media"; $data="data_ver"; break;
			case 53: $this->name="pend media +"; $data="data_ver"; break;
			case 54: $this->name="pend media -"; $data="data_ver"; break;
			case 55: $this->name="pend max +"; $data="data_ver"; break;
			case 56: $this->name="pend max -"; $data="data_ver"; break;
			case 57: $this->name="temp media"; $data="data_parent"; break;
			case 58: $this->name="temp max"; $data="data_parent"; break;
			case 59: $this->name="tot_mov_time"; $data="data_parent"; break;
			case 69: $this->name="avg_lap_time"; $tf=1; $data="data_parent"; break;
			case 71: $this->name="quota minima"; $data="data_altitudine"; break;
			case 70: $this->name="best_lap_index"; $data="data_parent"; break;
			case 83: $this->name="opponent score"; $data="data_parent"; break;
			case 82: $this->name="player_score"; $data="data_parent"; break;
			default: $this->name="vuoto" ; $data="data_parent";
		}
	}

	public function getName_session(){
		return $this->name;
	}
}

?>
