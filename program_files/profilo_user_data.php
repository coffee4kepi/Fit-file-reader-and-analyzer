<?php

//    Fit file reader and analyzer: profilo_user_data.php
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

class name_user_data{
	
	public $id;
	public $name;

	public function __construct($fn,&$tf,&$data){
		$this->id=$fn;
		switch($fn){
			case 253: $this->name="timestamp"; $tf=1; $data="data_parent"; break;
			case 0: $this->name="sconosciuto"; $data="data_parent"; break;
			case 1: $this->name="età"; $data="data_parent"; break;
			case 2: $this->name="altezza [cm]"; $data="data_parent"; break;
			case 3: $this->name="peso [kg]"; $data="data_peso"; break;
			case 4: $this->name="sesso"; $data="data_gender"; break;
			case 5: $this->name="sconosciuto"; $data="data_parent"; break;
			case 6: $this->name="sconosciuto"; $data="data_parent"; break;
			case 7: $this->name="sconosciuto"; $data="data_parent"; break;
			default: $this->name="vuoto" ; $data="data_parent";
		}
	}
	public function getName_userdata(){
		return $this->name;
	}
	
}

class data_peso extends data_parent{
	
	public function __construct($n){
		$this->numero=$n;
		$this->valore=$n/10;
		return true;
	}
}

class data_gender extends data_parent{
	
	public function __construct($n){
		$this->numero=$n;
		if ($n==1){
			$this->valore="uomo";
		}else{
			$this->valore="donna";
		}
		return true;
	}
}

?>
