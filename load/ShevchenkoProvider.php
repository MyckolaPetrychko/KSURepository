<?php
require_once('BasicProvider.php');
	class ShevchenkoProvider extends BasicProvider{
		public function parse($url, $pdo, $table){
			error_reporting(E_ERROR | E_PARSE);
			$path = $url; //search with connection to the internet
			//$path = 'sheva.htm';
			$html = file_get_contents($path);
		   $dom = new DOMDocument;
		   $dom->loadHTML($html);

		#get auhors

		//require_once ('/settings.php');
       $tag1 = 'strong';
       $authors = $dom->getElementsByTagName($tag1);
		$i = 0;
       foreach ($authors as $author) {
           $a[$i] = $author->nodeValue."\t";
		  // echo $a[$i];
		  
		   if ($i < 9){
			   $n[$i] = substr($a[$i], 0, 1);
			   $a[$i] = substr($a[$i], 2);
			   
		   }else if ($i >= 9 && $i < 100) {
			   $n[$i] = substr($a[$i], 0, 2);
			   $a[$i] = substr($a[$i], 3);
			  
		   }else{
			   $n [$i]= substr($a[$i], 0, 3);
			   $a[$i] = substr($a[$i], 4);
			
		   }
	
		   $i++;
 
       }

		//#get all materials

       $classname="book_list_item";
       $finder = new DomXPath($dom);
       $spaner = $finder->query("//*[contains(@class, '$classname')]");
        
       // foreach ($spaner as $description) {
           // echo $description->nodeValue."\n", PHP_EOL;
           // echo "</br></br>";
       // }
		//
	//#get number speciality

        $pattern = '/[\d]{2}\.[\d]{2}\.[\d]{2}/';
		$str = array();
		$row;
		$i = 0;
		$type = array();
       foreach ($spaner as $rows) {
           preg_match($pattern, $rows->nodeValue, $row);
		   if (preg_match('/кандидат/', $rows->nodeValue, $row1)){
			   $type[$i] = "Кандидатська";
		   }else {
			   $type[$i] = "Докторська";
		   }
		   echo $type[$i]. ' ' . $i . '<br>';
		   $str[$i] = $row;
		   $i++;
       }
	   	
	   
	   $k = 0;
	  for($i = 0; $i < count($str); $i++){
	  for ($j = 0; $j < count($str[$i]); $j++) { $spec[$k] =  $str[$i][$j]; $k++; }
	  }

		//#get year
        $pattern = '/[\d]{4}/';
		$str = array();
		$row;
		$i = 0;
       foreach ($spaner as $rows) {
           preg_match($pattern, $rows->nodeValue, $row);
		   $str[$i] = $row;
		   $i++;
       }
	   $k = 0;
		  for($i = 0; $i < count($str); $i++){
				for ($j = 0; $j < count($str[$i]); $j++){ $year[$k] = $str[$i][$j]; $k ++; }
		  }
	  
	  
	       $p1 = strpos($html, '<div class="book_list_item"');
        $p2 = strpos($html, '</div></div></div>');
		$newContent = substr($html, $p1, $p2-$p1);
		preg_match_all('/href=\".*\"/', $newContent, $refs);
		$p = 0;
		for ($i = 0; $i < count($refs); $i++){
		for ($j = 0; $j < count($refs[$i]); $j++){
			$link[$p] = $refs[$i][$j];
			$p++;
		}
}
		#get title
       $b = $html;
       $p2 = '</strong>';
       $p1 = '</a>';
       $k = 0;
       do{
               $num1 = strpos($b, $p2);
               $b = substr($b, $num1);
               $num2 = strpos($b, $p1);
               if($num1 === false) break;
               $res[$k] = substr($b, 0, $num2);
               $b = substr($b, $num2);
               $k++;
       }while($num1);
	   
	    $stm1 = $pdo->prepare("use ksu");
		$stm1->execute();
		
		$stm = $pdo->prepare("SELECT `link` FROM `repo_shevchenko`");
		$stm->execute();
		$i = 0;

		for ($j = 0; $j < count($n); $j++){
	
					$p = addslashes($a[$j]);
					$p1 = addslashes($res[$j]);
					$p2 = addslashes($spec[$j]);
					$p3 = addslashes($link[$j]);
					if ($p2 == '01.05.02' || $p2 == '05.13.06' || $p2 == '05.13.23'){
						$p2 = $p2 . '/' . $type[$j];
						if (hasRow($p1, $pdo, 'repo_shevchenko') === true){
								$stm1 = $pdo->prepare("INSERT INTO `repo_shevchenko` VALUES(NULL, '$p','$p1', '$p3', '$p2', '$year[$j]')");
								$stm1->execute();
							
						}
					}
		}	
	}
}

 