<?php
	class ONPUProvider extends BasicProvider{
		public function parse($url, $pdo, $table){
		include('library/simple_html_dom.php');
    error_reporting(E_ERROR | E_PARSE);
    //$path = 'http://cisn.opu.ua/science/dissertations'; //search with connection to the internet
    $path = $url;
    $html = file_get_contents($path); //local search
    //$html = file($path); //local search

   $dom = new DOMDocument;
   $dom->loadHTML($html);
    $html1= file_get_html($url);

$authors = $dom->getElementById('content');

$count = 0;
#get number speciality
$pattern = '/[\d]{2}\.[\d]{2}\.[\d]{2}/';
		preg_match_all($pattern, $html, $row);
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
$href = $html1->find('a[_mce_href]');
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
	  
	  
		require_once ('settings.php');
	   
	  	   
	    $stm1 = $pdo->prepare("use ksu");
		$stm1->execute();
		
		$i = 0;

		for ($j = 0; $j < count($speciality); $j++){
				if ($speciality[$j] == '01.05.02' || $speciality[$j] == '05.13.06' || $speciality[$j] == '05.13.23' ){
					$p = addslashes($a[$i]);
					$p1 = addslashes($title[$i]);
					$p2 = addslashes($re[$i]);
					$p3 = addslashes($speciality[$j]);
					if (hasRow($p1, $pdo, 'repo_ONPU') === true){
						$stm1 = $pdo->prepare("INSERT INTO `repo_ONPU` VALUES(NULL, '$p','$p1', '$p2', '$p3', '$year[$i]')");
						$stm1->execute();
					}
					$i++;
				}
				
		}
	}
}

