<?php

//    Fit file reader and analyzer: profilo_file_id.php
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

class name_file_id{
	
	public $id;
	public $name;

	public function __construct($fn,&$tf,&$data){
		$this->id=$fn;
		switch($fn){
			case 0: $this->name="type"; $data="data_file_id"; break;
			case 1: $this->name="manufacturer"; $data="data_manuf"; break;
			case 2: $this->name="product"; $data="data_prod"; break;
			case 3: $this->name="serial_num"; $data="data_parent"; break;
			case 4: $this->name="time_created"; $tf=1; $data="data_parent"; break;
			case 5: $this->name="name"; $data="data_parent"; break;
			default: $this->name="vuoto" ; $data="data_parent";
		}
	}

	public function getName_fileid_fielddef(){
		return $this->name;
	}
	
}

class data_manuf extends data_parent{
	
	public function __construct($n){
		$this->numero=$n;
		switch($n){
			case 1: $this->valore="garmin"; break;
			case 2: $this->valore="garmin_fr_405"; break;
			case 3: $this->valore="zephyr"; break;
			case 4: $this->valore="dayton"; break;
			case 13: $this->valore="dynastream_oem"; break;
			default: $this->valore="da inserire, numero $n";
		}
		return true;
	}
}

class data_file_id extends data_parent{
	
	public function __construct($n){
		$this->numero=$n;
		switch($n){
			case 1: $this->valore="device"; break;
			case 2: $this->valore="settings"; break;
			case 3: $this->valore="sport"; break;
			case 4: $this->valore="activity"; break;
			case 5: $this->valore="workout"; break;
			case 6: $this->valore="course"; break;
			case 7: $this->valore="schedules"; break;
			case 9: $this->valore="weight"; break;
			case 10: $this->valore="totals"; break;
			case 11: $this->valore="goals"; break;
			case 14: $this->valore="blood_pressure"; break;
			case 15: $this->valore="monitoring_a"; break;
			case 20: $this->valore="activity_summary"; break;
			case 28: $this->valore="monitoring_daily"; break;
			case 32: $this->valore="monitoring_b"; break;
			default: $this->valore="attività non in lista, $n <br>";
		}
		return true;
	}
}

class data_prod extends data_parent{
	
	public function __construct($n){
		$this->numero=$n;
		switch($n){
			case 1446: $this->valore="forerunner 310xt 4t"; break;
			case 1482: $this->valore="forerunner 10"; break;
			case 65534: $this->valore="garmin connect"; break;
			default: $this->valore="device non in lista , $n";
		}
		return true;
	}
}

?>
