<?php

//CLASSE PHP PER LA DECODIFICA DI UN FILE FIT.
//		IL COSTRUTTORE ACCETTA IL NOME DEL FILE E LO APRE E LO LEGGE
// 		I METODI SEROVONO PER ESTRARRE I DATI

		include 'profilo.php';
		include 'classidati.php';

	class fit_file{	

		public $record=[];

		public function __construct($path){

			$file=fopen($path,"rb");
			if ($file==false){
				print "problema con il file"; 
				return false;
			}

			//lettura del file binario a blocchi FILE_HEADER

			$size=fread($file,1);
			$ref=fread($file,1);
			$ver=fread($file,2);
			$data_size=fread($file,4);
			$dump=fread($file,4);
			$crc=fread($file,2);
			$file_hd=new file_header($size,$ref,$ver,$data_size,$crc);

			$corrisp_record_msg_loc=[];

			//leggo i record

			$ciclo=0;
			$byte_letti=0;
	
			$bytetot=unpack("V",$file_hd->__get('data_size'));
			while( $byte_letti<$bytetot[1] ){
			//while( $byte_letti<10000 ){

				$header=fread($file,1);
				$byte_letti=$byte_letti+1;
				$byte=[0,0,0,0,0,0,0,0];
				$byte=decbin(unpack("C",$header)[1]);
				$byte=substr("00000000",0,8 - strlen($byte)) . $byte; //aggiunge gli zeri mancanti per avere 8 bit completi


				if ($byte[0]==0){	//record "normale"
				
					$loc_mess_code=bindec(substr($byte,4,4));
	
					if ($byte[1]==1){//controllo se è un file di definizione

						//controllo se il codice sia già presente nell'array
						$new_code=array_key_exists($loc_mess_code,$corrisp_record_msg_loc);
						if (!$new_code){
						//fissa l'indice di lettura del record con l'ultimo codice locale fissato
						$corrisp_record_msg_loc[$loc_mess_code]=$ciclo; 
						}else{
							//var_dump($corrisp_record_msg_loc);
							$old_val=$corrisp_record_msg_loc[$loc_mess_code]; //back ultimo record con quel codice
							$code_shift=($loc_mess_code+20);
							$corrisp_record_msg_loc[$code_shift]=$old_val; //sposto il record in posizione di riposo
							$corrisp_record_msg_loc[$loc_mess_code]=$ciclo; //fisso il nuovo riferimento
							//echo "riuso il codice locale <br>"; //STRUTTURE DI CONTROLLO
							//var_dump($corrisp_record_msg_loc); echo "<br>";
						}				

							//LETTURA DEFINIZIONI ----------
							$dump=fread($file,1); //reserved
							$dump=fread($file,1); //architecture
							if (unpack("C",$dump)[1]==1) echo "CAMPO BIG-ENDIAN!!!<br>";
							$glb=unpack("v",fread($file,2)); //global code
							$numf=unpack("C",fread($file,1)); //number of fields
							$this->record[$ciclo]=new record_normal($numf[1],$glb[1],$loc_mess_code);
							$byte_letti=$byte_letti+5;
							for($i=0;$i<$numf[1];$i++){
								$n=unpack("C",fread($file,1)); 	//field code
								$dump=fread($file,1);		//field size (redundant)
								$dump=fread($file,1); 		//field type code
								//reading file type= last 5 bits dxs
								$byte=decbin(unpack("C",$dump)[1]);
								$byte=substr("00000000",0,8 - strlen($byte)) . $byte;
								$t=bindec(substr($byte,3,5));
								$assign=$this->record[$ciclo]->addField($n[1],$t,$glb[1]);
								$byte_letti=$byte_letti+3;
							}
							$ciclo++;
					}
					else{	//ALTRIMENTI SONO CAMPI DATI,ALLORA RIEMPIO I CAMPI DATI DEL RECORD GIUSTO
							$nrec=$corrisp_record_msg_loc[$loc_mess_code];
							$campi_da_leggere=$this->record[$nrec]->__get('numfields');
							for($i=0;$i<$campi_da_leggere;$i++){
								$nbyte=$this->record[$nrec]->field[$i]->type->__get('size');
								$dump=fread($file,$nbyte);
								$byte_letti=$byte_letti+$nbyte;
								//decodifica del dato da scrivere
								$unpack_code=$this->record[$nrec]->field[$i]->type->__get('unpack_var');
								$null=$this->record[$nrec]->field[$i]->type->__get('null_val');
								$num=unpack($unpack_code,$dump);
								if ( $num[1]==hexdec($null) ){
									$valore="campo nullo";
								}else{
									$valore=$num[1];
								}
								$n_new_data=$this->record[$nrec]->field[$i]->getDataSize();
								$assign=$this->record[$nrec]->field[$i]->setNewData($n_new_data,$valore);
								if (!$assign) {echo "problema assegnazione dato campo"; return false; }
							}
					}
				
				}
				else{
					$loc_mess_code=bindec(substr($byte,1,2));
					echo "formato time stamp, messaggio locale $loc_mess_code <br>";
					$nrec=$corrisp_record_msg_loc[$loc_mess_code];
					$time_stamp=bindec(substr($byte,3,8)); //lo devo trattare come un campo in più
					$assign=$this->record[$nrec]->addTs($time_stamp);
					if (!$assign) {echo "problema assegnazione time stamp"; return false;}
					$campi_da_leggere=$this->record[$nrec]->__get('numfields');
					for($i=0;$i<$campi_da_leggere;$i++){
						$nbyte=$this->record[$nrec]->field[$i]->type->__get('size');
						$dump=fread($file,$nbyte);
						$byte_letti=$byte_letti+$nbyte;
						//decodifica del dato da scrivere
						$unpack_code=$this->record[$nrec]->field[$i]->type->__get('unpack_var');
						$null=$this->record[$nrec]->field[$i]->type->__get('null_val');
						$num=unpack($unpack_code,$dump);
						if ( $num[1]==hexdec($null) ){
							$valore="campo nullo";
						}else{
							$valore=$num[1];
						}
						$n_new_data=$this->record[$nrec]->field[$i]->getDataSize();
						$assign=$this->record[$nrec]->field[$i]->setNewData($n_new_data,$valore);
						if (!$assign) {echo "problema assegnazione dato campo"; return false; }
					}
				}

			} //FINE DELLA LETTURA DEL FILE
	
			fclose($file);
			
			return true;}

		public function fit_stampa(){

			//stampo i record
			$totr=count($this->record);
			for($t=0;$t<$totr;$t++){
				$nc=$this->record[$t]->__get('numfields');
				echo "<table border=2><tr><td colspan='$nc'>RECORD $t ------------------ </td></tr>";
				$text=$this->record[$t]->__get('global_code_type');
				echo "<tr><td colspan='$nc'> global code type : $text , ";
				$text=$this->record[$t]->__get('name');
				echo "global code name : $text </td></tr>";
				echo "<tr><td colspan='$nc'>-------DATI---------</td></tr><tr>";
				for($i=0;$i<$nc;$i++){
					echo "<td><table>";
					$text1=$this->record[$t]->field[$i]->__get('f_code');
					$text2=$this->record[$t]->field[$i]->__get('f_name');
					$ndati=$this->record[$t]->field[$i]->getDataSize();
					echo "<tr><td nowrap> $text1 </td></tr><tr><td nowrap> $text2 </td></tr>";
					for($l=0;$l<$ndati;$l++){
						$text3=$this->record[$t]->field[$i]->data[$l]->get_data_conv();
						if ($this->record[$t]->field[$i]->__get('time_flag')==1){$text3=data_readable($text3);}
						echo " <tr><td nowrap> $text3 </td></tr>";
					}
					echo "</table></td>";
				}
				echo "</tr></table>";
			}
			return true;
		}
	
		public function getLAP(){

			//output del vettore
			//0 : lunghezza lap
			//1 : durata lap
			//2 : velocità media
			//4 : quota +
			//5 : quota -
			//6 : pendenza

			$lap=[];

			$totr=count($this->record); //cerco il record lap
			for ($i=0;$i<$totr;$i++){
				if ($this->record[$i]->__get('global_code_type')==19){
					$record_num=$i;
					break;
				}
			}
			$tot=count($this->record[$record_num]->field); //cerco i campi che interessano
			$num_lap=count($this->record[$record_num]->field[0]->data);
			$key_lenght=search_key($this,9,$record_num,$tot);
			$key_time=search_key($this,8,$record_num,$tot);
			$key_vel_media=search_key($this,13,$record_num,$tot);
			$key_ascesa=search_key($this,21,$record_num,$tot);
			$key_discesa=search_key($this,22,$record_num,$tot);

			for ($l=0;$l<$num_lap;$l++) {
				$lap[$l][0]=$this->record[$record_num]->field[$key_lenght]->data[$l]->get_data_conv();
				$lap[$l][1]=$this->record[$record_num]->field[$key_time]->data[$l]->get_data_conv();
				$lap[$l][2]=$this->record[$record_num]->field[$key_vel_media]->data[$l]->get_data_conv();
				$vel2_min=(int)((1/$lap[$l][2])*60);
				$vel2_sec=(int)(((1/$lap[$l][2])*60-(int)((1/$lap[$l][2])*60))*60);
				$lap[$l][3]=$vel2_min.":".$vel2_sec;
				if ($key_ascesa<0) $string=""; else{
					$lap[$l][4]=$this->record[$record_num]->field[$key_ascesa]->data[$l]->get_data_conv();
					$lap[$l][5]=$this->record[$record_num]->field[$key_discesa]->data[$l]->get_data_conv();
					$lap[$l][6]=($lap[$l][4]-$lap[$l][5])/$lap[$l][0]*100;
				}
			}

		return $lap;
		}

		public function getGPS(){
			//output del vettore
			//0 : runtime
			//1 : distanza
			//2 : velocità
			//4 : altitudine
			//5 : pendenza
			$totr=count($this->record); //cerco il record dati
			for ($i=0;$i<$totr;$i++){
				if ($this->record[$i]->__get('global_code_type')==20){
					$record_num=$i;
				}
			}

			//riconto il numero di campi
			$tot=count($this->record[$record_num]->field);
			//riconto il numero di dati
			$num_lap=count($this->record[$record_num]->field[0]->data);
		
			//ricerca delle chiavi
			$key_tempo=search_key($this,253,$record_num,$tot);
			$key_distanza=search_key($this,5,$record_num,$tot);
			$key_vel=search_key($this,6,$record_num,$tot);
			$key_altezza=search_key($this,2,$record_num,$tot);

			//inizializzazione
			$dati=[];

			//calcolo dei dati
			//il tempo: leggo i dati non convertiti, devo sottrarre il tempo del primo dato, che fa da riferimento
		
			//fisso il valore di riferimento temporale e riempio i vettori
			$tempo_rif=$this->record[$record_num]->field[$key_tempo]->data[0]->get_data_conv();		
			if ($key_altezza>0) $alt_media=0;
			for ($i=0;$i<$num_lap;$i++){
				$dist=$this->record[$record_num]->field[$key_distanza]->data[$i]->get_data_conv();
				$vel=$this->record[$record_num]->field[$key_vel]->data[$i]->get_data_conv();
				if ($key_altezza>0) $alt=$this->record[$record_num]->field[$key_altezza]->data[$i]->get_data_conv();
				$t=$this->record[$record_num]->field[$key_tempo]->data[$i]->get_data_conv();
			
				$dati[$i][0]=$t-$tempo_rif;
				$dati[$i][1]=$dist;
				if ($vel>0.5) $dati[$i][2]=$vel; else $dati[$i][2]=NULL; //vuoto se vel < di 0.5 km/h
				//$vel2_min=(int)((1/$vel)*60);
				//$vel2_sec=(int)(((1/$vel)*60-(int)((1/$vel)*60))*60);
				//$dati[$i][3]=$vel2_min.":".$vel2_sec;
				$dati[$i][3]=0;
				if ($key_altezza>0) {
					$dati[$i][4]=$alt;
					if ($i>0) {
						if (($dati[$i][1]-$dati[$i-1][1])>0) 
							$dati[$i][5]=($dati[$i][4]-$dati[$i-1][4])/($dati[$i][1]-$dati[$i-1][1])*100;
						else 
							$dati[$i][5]=0;
						if (abs($dati[$i][5])>150) $dati[$i][5]=NULL;
					} 
					else $dati[$i][5]=0;
				}
			}
		return $dati;
		}


	} //chiude la graffa della classe

?>



		



