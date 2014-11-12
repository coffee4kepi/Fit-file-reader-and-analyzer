<?php

//    Fit file reader and analyzer: profilo_file_creator.php
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

class name_file_creat{
	
	public $id;
	public $name;

	public function __construct($fn,&$tf,&$data){
		$this->id=$fn;
		switch($fn){
			case 0: $this->name="software_ver"; $data="data_ver"; break;
			case 1: $this->name="hardware_ver"; $data="data_ver"; break;
			default: $this->name="vuoto" ; $data="data_parent";
		}
	}

	public function getName_filecreat(){
		return $this->name;
	}
	
}

class data_ver extends data_parent{
	
	public function __construct($n){
		$this->numero=$n;
		$this->valore=$n/100;
		return true;
	}
}

?>
