<?php

//    Fit file reader and analyzer: profilo_dev_info.php
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

class name_dev_info{
	
	public $id;
	public $name;

	public function __construct($fn,&$tf,&$data){
		$this->id=$fn;
		switch($fn){
			case 253: $this->name="timestamp"; $tf=1; $data="data_parent"; break;
			case 0: $this->name="device_index"; $data="data_parent"; break;
			case 1: $this->name="device_type"; $data="data_parent"; break;
			case 2: $this->name="manufacturer"; $data="data_manuf"; break;
			case 3: $this->name="serial_num"; $data="data_parent"; break;
			case 4: $this->name="product"; $data="data_prod"; break;
			case 5: $this->name="software_ver"; $data="data_ver"; break;
			case 6: $this->name="hardware_ver"; $data="data_ver"; break;
			case 7: $this->name="cum_operat_time [s]"; $data="data_parent"; break;
			case 10: $this->name="battery_voltage [V]"; $data="data_parent"; break;
			case 11: $this->name="battery_status"; $data="data_parent"; break;
			case 18: $this->name="sensor_position"; $data="data_parent"; break;
			case 19: $this->name="descriptor"; $data="data_parent"; break;
			case 20: $this->name="ant_transm_type"; $data="data_parent"; break;
			case 21: $this->name="ant_dev_num"; $data="data_parent"; break;
			case 22: $this->name="ant_network"; $data="data_parent"; break;
			case 25: $this->name="source_type"; $data="data_parent"; break;
			default: $this->name="vuoto" ; $data="data_parent";
		}
	}
	public function getName_dev_info(){
		return $this->name;
	}
	
}

?>
