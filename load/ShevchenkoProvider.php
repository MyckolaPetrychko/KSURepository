<?php
require_once('../settings.php');
				require_once('hasRow.php');
				require_once('BasicProvider.php');
				require_once('Data.php');
			
	class ShevchenkoProvider extends BasicProvider{
		private $dom;
		public $basic;

		public function load($url){
			error_reporting(E_ERROR | E_PARSE);
			$path = $url; //search with connection to the internet
			//$path = 'sheva.htm';
			$content = file_get_contents($path);
			$this->basic = new BasicProvider();
			$this->basic->content = $content;
			$this->dom = new DOMDocument;
			$this->dom->loadHTML($content);

		}

		public function parse(){
			
		#get auhors

		//require_once ('/settings.php');
       $tag1 = 'strong';
       $authors = $this->dom->getElementsByTagName($tag1);
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
       $finder = new DomXPath($this->dom);
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
	  
	  
	       $p1 = strpos($this->basic->content, '<div class="book_list_item"');
        $p2 = strpos($this->basic->content, '</div></div></div>');
		$newContent = substr($this->basic->content, $p1, $p2-$p1);
		preg_match_all('/href=\".*\"/', $newContent, $refs);
		$p = 0;
		for ($i = 0; $i < count($refs); $i++){
		for ($j = 0; $j < count($refs[$i]); $j++){
			$link[$p] = $refs[$i][$j];
			$p++;
		}
}
		#get title
       $b = $this->basic->content;
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

	$_data = new Data($a, $res, $spec, $year, [], $link, $type);
	$this->basic->_data = $_data;
	}
}

	$sheva = new ShevchenkoProvider();
	$sheva->load("http://cyb.univ.kiev.ua/uk/library.dissertations.html");
	//$sheva->load("sheva.htm");
	$sheva->parse();
	$sheva->basic->save($pdo, "repo_shevchenko");

 
