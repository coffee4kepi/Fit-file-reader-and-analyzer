<?php

//    Fit file reader and analyzer: profilo_source.php
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

class name_source{
	
	public $id;
	public $name;

	public function __construct($fn,&$tf,&$data){
		$this->id=$fn;
		switch($fn){
			case 0: $this->name="ant?"; $data="data_parent"; break;
			case 1: $this->name="ant+?"; $data="data_parent"; break;
			case 2: $this->name="bluetooth?"; $data="data_parent"; break;
			case 3: $this->name="bluetooth_low_energy?"; $data="data_parent"; break;
			case 4: $this->name="wifi?"; $data="data_parent"; break;
			case 5: $this->name="local?"; $data="data_parent"; break;
			case 253: $this->name="timestamp"; $tf=1; $data="data_parent"; break;
			default: $this->name="vuoto" ; $data="data_parent";
		}
	}

	public function getName_source(){
		return $this->name;
	}
	
}

?>
