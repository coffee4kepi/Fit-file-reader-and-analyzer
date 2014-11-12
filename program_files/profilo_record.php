<?php

//    Fit file reader and analyzer: profilo_record.php
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

class name_record{
	
	public $id;
	public $name;

	public function __construct($fn,&$tf,&$data){
		$this->id=$fn;
		switch($fn){
			case 253: $this->name="timestamp"; $tf=1; $data="data_parent"; break;
			case 0: $this->name="lat [°]"; $data="data_posizione"; break;
			case 1: $this->name="long [°]"; $data="data_posizione"; break;
			case 2: $this->name="altitudine [m]"; $data="data_altitudine"; break;
			case 5: $this->name="distanza [m]"; $data="data_distanza"; break;
			case 6: $this->name="velocità [m/s]"; $data="data_speed"; break;
			case 7: $this->name="potenza [W]"; $data="data_parent"; break;
			case 8: $this->name="v-d-compresso"; $data="data_parent"; break;
			case 9: $this->name="pendenza [%]"; $data="data_ver"; break;
			case 10: $this->name="resistenza"; $data="data_parent"; break;
			case 11: $this->name="tempo_from_course"; $data="data_parent"; break;
			case 12: $this->name="cycle_length"; $data="data_parent"; break;
			case 13: $this->name="temperatura"; $data="data_parent"; break;
			case 17: $this->name="velocità_1s"; $data="data_parent"; break;
			case 18: $this->name="cycles"; $data="data_parent"; break;
			case 19: $this->name="total cycles"; $data="data_parent"; break;
			case 31: $this->name="accuratezza segnale [m]"; $data="data_parent"; break;
			case 33: $this->name="calorie [kcal]"; $data="data_parent"; break;
			case 42: $this->name="tipo attività"; $data="data_parent"; break;
			case 48: $this->name="time128"; $data="data_parent"; break;
			case 50: $this->name="zona"; $data="data_parent"; break;
			case 62: $this->name="device_index"; $data="data_parent"; break;
			default: $this->name="vuoto" ; $data="data_parent";
		}
	}

	public function getName_record(){
		return $this->name;
	}
	
}

class data_posizione extends data_parent{
	
	public function __construct($n){
		$this->numero=$n;
		$this->valore=$n*180/2147483648;
		return true;
	}
}

class data_altitudine extends data_parent{
	
	public function __construct($n){
		$this->numero=$n;
		$this->valore=$n/5-500;
		return true;
	}
}

class data_distanza extends data_parent{
	
	public function __construct($n){
		$this->numero=$n;
		$this->valore=$n/100;
		return true;
	}
}

class data_speed extends data_parent{
	
	public function __construct($n){
		$this->numero=$n;
		$this->valore=$n*3.6/1000;
		return true;
	}
}

?>
