<?php
	class BasicProvider{

		protected $content;
		protected $_data;

		protected function load($url){
			$content = file_get_contents($url);
		}

		protected function parse(){}
		
		public function save($pdo, $table){
			$stm1 = $pdo->prepare("use ksu");
			$stm1->execute();
			
			$i = 0;
		
			if (empty($this->_data->info)){

				for ($j = 0; $j < count($this->_data->speciality); $j++){
				
					if ($this->_data->speciality[$j] == '01.05.02' || $this->_data->speciality[$j] == '05.13.06' || $this->_data->speciality[$j] == '05.13.23' ){

						$p = addslashes($this->_data->author[$i]);
						$p1 = addslashes($this->_data->title[$i]);
						$p2 = addslashes($this->_data->download[$i]);
						$p3 = addslashes($this->_data->speciality[$j])  . '/' . $this->_data->type[$i];
						$p4 = $this->_data->year[$i];
						if (hasRow($p1, $pdo, $table) === true){
							
							$stm1 = $pdo->prepare("INSERT INTO `$table` VALUES(NULL, '$p','$p1', '$p2', '$p3', '$p4')");
							$stm1->execute();
						}
						$i++;
					}
				
				}
			}else{

				for ($j = 0; $j < count($this->_data->speciality); $j++){
							$p = addslashes($this->_data->author[$j]);
							$p1 = addslashes($this->_data->title[$j]);
							$p2 = addslashes($this->_data->speciality[$j]) . '/' . $this->_data->type[$j];
							$p3 = addslashes($this->_data->year[$j]);
							$p4 = addslashes($this->_data->info[$j]);
							$p5 = addslashes($this->_data->download[$j]);
							echo $this->_data->type[$j]. ' ' .$this->_data->author[$j] .'<br>';
							if (hasRow($p1, $pdo, $table) === true){
								if (!empty($this->_data->author[$j])){
									$stm1 = $pdo->prepare("INSERT INTO `$table` VALUES(NULL, '$p','$p1', '$p2', '$p3', '$p4', '$p5')");
									$stm1->execute();
								}
							}
				}

			}
			
		}	
	}
