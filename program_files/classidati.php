

<?php

//    Fit file reader and analyzer: classidati.php
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

class field{


	//attributi
	public $size;
	public $name; 
	public $endian;
	public $type;

	//costruttore
	public function __construct($s,$n,$e,$t)
	{
		$this->size=$s;
		$this->name=$n;
		$this->endian=$e;
		$this->type=$t;
	}
	
	//metodo di set
	public function __set($campo,$valore)
	{
		$this->$campo = $valore;
	}

	//metodi di lettura
	public function __get($campo)
	{
		return $this->$campo;
	}

	
}

class field_type{
	public $code;
	public $size;
	public $unpack_var;
	public $null_val;

	public function __construct($c){
		$array=field_type_conv($c);
		$this->code=$c;
		$this->size=$array[0];
		$this->unpack_var=$array[1];
		$this->null_val=$array[2];
		
	}

	public function __get($campo){
		return $this->$campo;
	}
}

class fields{
	
	//attributi
	public $f_code;
	public $f_name;
	public $type;
	public $time_flag;
	public $conv_tab;
	public $data=[];
	
	//costruttore
	public function __construct($n,$t,$record_type){
		$this->f_code=$n;
		$this->time_flag=0;
		$this->conv_tab="data_parent";
		$this->f_name=file_type_field_name($record_type,$n,$this->time_flag,$this->conv_tab)[1];
		$this->type=new field_type($t);
	}

	//metodi
	public function __set($campo,$valore){
		$this->$campo=$valore;
		return true;
	}
	public function __get($campo){
		return $this->$campo;
	}
	public function getDataSize(){
		return count($this->data);
	}
	public function setNewData($n,$valore){
		$new_var=$this->conv_tab;
		$this->data[$n]=new $new_var($valore);
		return true;
	}
	public function getData($i){
		$result=$this->data[$i]->get_data_conv();
		echo "dato estratto : $result <br>";
		return $result;
	}
}

class record_normal{

	//attributi
	public $numfields;
	public $global_code_type;
	public $name;
	public $local_field_code;
	public $time_stamp=[];
	public $field=[];

	//costruttore
	public function __construct($n,$g,$lc)
	{
		$this->numfields=$n;
		$this->global_code_type=$g;
		$this->local_field_code;
		$dump=0;
		$this->name = file_type_field_name($g,-1,$dump,$dump,-1)[0];
	}
	
	//metodo di set
	public function __set($campo,$valore)
	{
		$this->$campo = $valore;
		return true;
	}
	public function addField($codice_campo,$codice_tipo,$record_type)
	{
		$this->field[]=new fields($codice_campo,$codice_tipo,$record_type);
		return true;

	}
	public function addTs($valore)
	{
		$this->time_stamp[]=$valore;
		return true;
	}

	//metodi di lettura
	public function __get($campo)
	{
		return $this->$campo;
	}

}

class file_header{

	//attributi
	public $size; //se normale o compressed timestamp
	public $ref;
	public $ver;
	public $data_size;
	public $crc;

	//costruttore
	public function __construct($s,$n,$e,$t,$c)
	{
		$this->size=$s;
		$this->ref=$n;
		$this->ver=$e;
		$this->data_size=$t;
		$this->crc=$c;
	}
	
	//metodo di set
	public function __set($campo,$valore)
	{
		$this->$campo = $valore;
	}

	//metodi di lettura
	public function __get($campo)
	{
		return $this->$campo;
	}
}

function data_readable($seconds){
	$data=new DateTime('1989-12-31 00:00:00+0000');
	$data->add(new DateInterval('PT'.$seconds.'S'));
	return $data->format('d-m-Y H:i:s');
}

function search_key(&$obj,$code,$rec_num,$tot){
	$key=-100;	
	for ($i=0;$i<$tot;$i++){
		if ($obj->record[$rec_num]->field[$i]->__get('f_code')==$code){
			$key=$i;
			break;	
		}
	}
	return $key;	
}

?>
