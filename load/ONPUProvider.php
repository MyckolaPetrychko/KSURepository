<?php
require_once('../settings.php');
				require_once('hasRow.php');
				require_once('BasicProvider.php');
				require_once('Data.php');
				
				
	class ONPUProvider extends BasicProvider{
		public $dom;
		public $html1;
		public $basic;

		public function load($url){
			include('../library/simple_html_dom.php');
		    error_reporting(E_ERROR | E_PARSE);
		    //$path = 'http://cisn.opu.ua/science/dissertations'; //search with connection to the internet
		    $path = $url;
		    $content = file_get_contents($path); //local search
		    //$html = file($path); //local search

		   $this->dom = new DOMDocument;
		   $this->dom->loadHTML($content);
  			$this->basic = new BasicProvider();
  			$this->basic->content = $content;
		    $this->html1= file_get_html($url);
		}

		public function parse(){
				$authors =  $this->dom->getElementById('content');

				$count = 0;
				#get number speciality
				$pattern = '/[\d]{2}\.[\d]{2}\.[\d]{2}/';
						preg_match_all($pattern, $this->basic->content, $row);
						$i=0;
						for (; $i < count($row[0]); $i++) { $speciality[$i] = $row[0][$i];// echo $speciality[$i].'<br>';
						}

					   
				 #get author
				$test = $authors->getElementsByTagName('a');
				$i = true;
				$j=0;
				$k = 0;
				foreach($test as $t)
				{
				    if($i)
					{
						if ($speciality[$j] == '01.05.02' || $speciality[$j] == '05.13.06' || $speciality[$j] == '05.13.23' ){
							$a[$k] = $t->nodeValue;
							//echo $a[$k].'<br>';
							$count++;
							$k++;
						}
						$j++;
				        $i = false; continue;    
				    }
				    $i = true;
				}


				#get href
				$refs = array();
				$href = $this->html1->find('a[_mce_href]');
				$i = 0;
				foreach($href as $ref)
				{
				    preg_match_all('/_mce_href=\".*\"/', $ref, $refs[$i]);
				    $i++;
				}
				$p=0; $n = 0; $m = 0;
				for($i = 0; $i < count($refs); $i++)
				    for($j = 0; $j < count($refs[$i]); $j++)
				    for($k = 0; $k < count($refs[$i][$j]); $k++)
					{  
						if ($m % 2 > 0) { 
							if ($speciality[$n] == '01.05.02' || $speciality[$n] == '05.13.06' || $speciality[$n] == '05.13.23' ){
								$re[$p] = $refs[$i][$j][$k]; //echo $re[$p].'<br>'; 
								$p++;
							}
							$n++;
						}
						 $m++;
					}

				#get title
				$tegstrong = $authors->getElementsByTagName('strong');
				$j = 0; $k = 0;
				      foreach ($tegstrong as $rows) {
							  if ($speciality[$j] == '01.05.02' || $speciality[$j] == '05.13.06' || $speciality[$j] == '05.13.23' ){
							   $title[$k] = $rows->nodeValue;
							  // echo $title[$k].'<br>';
							   $k++;
							 }
				          $j++;
				      }

				#get dates
				       $tmp = array();
						$patDate = '/[\d]{4}/';
						$tegli = $authors->getElementsByTagName('li');
				       $i = 0;
					   $k = 0;
				       foreach ($tegli as $rows) 
				       {
						if ($speciality[$i] == '01.05.02' || $speciality[$i] == '05.13.06' || $speciality[$i] == '05.13.23' ){
				               preg_match($patDate, $rows->nodeValue, $r);
				               $year[$k] = implode($r);	
							   //echo $year[$k].'<br>';
								$k++;			   
						   }
				           $i++;
				      }


				      $type = array();
					  $pattern = '/кандидата/';
					  $typeli = $authors->getElementsByTagName('li');
				
					 
				      $i = 0;
					  $k = 0;
					
				      foreach ($typeli as $rows) 
				       {
				       	
						if ($speciality[$i] == '01.05.02' || $speciality[$i] == '05.13.06' || $speciality[$i] == '05.13.23' ){
				               if (preg_match($pattern, $rows->nodeValue, $r)){
				               		$type[$k] = "Кандидатська";
				               }else {
				               		$type[$k] = "Докторська";
				               }
				     
							   //echo $year[$k].'<br>';
								$k++;			   
						   }
				           $i++;
				      }
				      
				      $_data = new Data($a, $title, $speciality, $year, [], $re, $type);
				      $this->basic->_data = $_data;

	}
}

				

	$onpu = new ONPUProvider();
	$onpu->load("onpu.html");
	$onpu->parse();
	$onpu->basic->save($pdo, "repo_onpu");


