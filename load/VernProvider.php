<?php
require_once('../settings.php');
				require_once('hasRow.php');
				require_once('BasicProvider.php');
				require_once('Data.php');
				
	
	class VernProvider extends BasicProvider{
		public $basic;
		private $url;

		public function load($url){
			$this->basic = new BasicProvider();
			$this->basic->content = file_get_contents($url);
			$this->url = $url;
		}

		public function parse(){

		$p1 = strpos($this->basic->content, '<b>1.</b>');
		$this->basic->content = substr($this->basic->content, $p1);
		$p2 = strpos($this->basic->content, '<!--!FORMAT=@insert_export-->');
		$this->basic->content = substr($this->basic->content, 0, $p2);
		$size = 0;
		 // number
		 if ($f < 10){
			 $pattern_n1 = '/\<b\>[\d]{1}\.\<\/b\>/';
			$pattern_n2 = '/\<b\>[\d]{2}\.\<\/b\>/';
			$number = array();
			preg_match_all($pattern_n1, $this->basic->content, $row);
			preg_match_all($pattern_n2, $this->basic->content, $row1);
			$i = 0; $j = 0;
			for (; $i < count($row[0]); $i++) { $number[$i] = substr(substr($row[0][$i], 0, 4), 3);  }
			for (; $i < count($row1[0]) + count($row[0]); $i++, $j++) { $number[$i] = substr(substr($row1[0][$j], 0, 5), 3); }
		 }else {
			 $pattern_n1 = '/\<b\>[\d]{2}\.\<\/b\>/';
			 preg_match_all($pattern_n1, $this->basic->content, $row);
			 $i = 0; $j = 0;
			for (; $i < count($row[0]); $i++) { $number[$i] = substr(substr($row[0][$i], 0, 5), 3);  }
		 }
		
		
		
		// author and download
		$i = 0; 

		$author_count = 0;
		$download_count = 0;
		$tmp1 = $this->basic->content;
		$p1 = strpos($this->basic->content, '<a title');
		
		while($p1 > 0){
			if ($i){
				$p1 = strpos($this->basic->content, '<a title=');
			}
			$this->basic->content = substr($this->basic->content, $p1);
			$p2 = strpos($this->basic->content, '</a>');
		
			$tmp = substr($this->basic->content, 0, $p2);
			$this->basic->content = substr($this->basic->content, $p2);
			
			if ( strpos($tmp, ".$") > 0) {
				$author[$author_count] = $tmp;
				//echo $author[$author_count].'<br>';
				$author_count++;$size++;
			}else if( strpos($tmp, "$") > 0){
				$author[$author_count] = $tmp;
				//echo $author[$author_count].'<br>';
				$author_count++;$size++;
			}else if(strpos($tmp, "_FILE_DOWNLOAD") > 0){
				$download[$download_count] = $tmp;
				//echo $download[$download_count].'<br>';
				$download_count++;
			}
			else {}
			
			$i++;
		}
		
		
		
		// speciality
		$pattern = '/[\d]{2}\.[\d]{2}\.[\d]{2}/';
		preg_match_all($pattern, $tmp1, $row);
		$i=0;
		for (; $i < count($row[0]); $i++) { $speciality[$i] = $row[0][$i]; }
		
		
		// year
		$tmp2 = $tmp1;
		$c = '<b><font color="red"';
		$pattern = '/[\d]{4}/';
		$p1 = strpos($tmp1, $c);
		if (!$p1) { $c = '</b>:'; $p1 = strpos($tmp1, $c);}
		$i=0;
		while($p1 > 0){
			if ($i){
				$p1 = strpos($tmp1, $c);
			}
			$tmp1 = substr($tmp1, $p1);
			$p2 = strpos($tmp1, '<img');
			$tmp = substr($tmp1, 0, $p2);
			$tmp1 = substr($tmp1, $p2);
			preg_match($pattern, $tmp, $row);
			$year[$i] = $row[0];
			//echo $year[$i].'<br>';
			$i++;
		}
		
		
		// title 
		$tmp3 = $tmp2;
		$p1 = strpos($tmp2, '<br><a title');
		$i=0;
		$pattern = '/\<b\>.*\<\/b\>/';
		while($p1 > 0){
			if ($i){
				$p1 = strpos($tmp2, '<br><a title');
			}
			$tmp2 = substr($tmp2, $p1);
			$p2 = strpos($tmp2, '<font color="red"');
			if (!$p2) $p2 = strpos($tmp2, '<p style');
			$tmp = substr($tmp2, 0, $p2);
			$tmp2 = substr($tmp2, $p2);
			preg_match($pattern, $tmp, $row);
			$title[$i] = $row[0];
			//echo $title[$i].'<br>';
			$i++;
		}
		
		// additional information
		$tmp4 = $tmp3;
		$pattern = '/ \/.*\./';
		$c = '<font color="red"';
		
		$p1 = strpos($tmp3, $c);
		if (!$p1) { $c = '</b>:'; $p1 = strpos($tmp3, $c); $pattern = '/:.*\./'; }
		$i=0;
		while($p1 > 0){
			if ($i){
				$p1 = strpos($tmp3, $c);
			}
			$tmp3 = substr($tmp3, $p1);
			$p2 = strpos($tmp3, '<p style');
			$tmp = substr($tmp3, 0, $p2);
			$tmp3 = substr($tmp3, $p2);
			preg_match($pattern, $tmp, $row);
			$info[$i] = substr($row[0], 2);
			//echo $info[$i].'<br>';
			$i++;
		}
		
		
		// type
		$a =  '<a title';
		
		
		$pattern = "/канд./";
		$p1 = 1;
		$i=0;
		$type = array();
		

		$c = "<p style=\"text-align:justify;";
		while($p1 > 0){
			$p1 = strpos($tmp4, $a);

			$tmp4 = substr($tmp4, $p1);
			
			$p2 = strpos($tmp4, $c);
		
			$tmp = substr($tmp4, 0, $p2);
			$tmp4 = substr($tmp4, $p2);
	
			
			if (preg_match($pattern, $tmp, $row)){
				if (!empty($author[$i])){
					$type[$i] = "Кандидатська";
					$i++;
				}
			}else {
				if (!empty($author[$i])){
					$type[$i] = "Докторська";
					$i++;
				}
			}	

		}
		

		$_data = new Data($author, $title, $speciality, $year, $info, $download, $type);
		$this->basic->_data = $_data;
		
	}
}



$i = 1;
while(file_exists("../data/nbuv/01.05.02/$i.html")){
	$Vern = new VernProvider();
	$Vern->load("../data/nbuv/01.05.02/$i.html");
	$Vern->parse();
	$Vern->basic->save($pdo, "repo_nbuv_math");
	$i++;
}
$i = 1;
while(file_exists("../data/nbuv/05.13.06/$i.html")){
	$Vern = new VernProvider();
	$Vern->load("../data/nbuv/05.13.06/$i.html");
	$Vern->parse();
	$Vern->basic->save($pdo, "repo_nbuv_it");
	$i++;
}
$i = 1;
while(file_exists("../data/nbuv/05.13.23/$i.html")){
	$Vern = new VernProvider();
	$Vern->load("../data/nbuv/05.13.23/$i.html");
	$Vern->parse();
	$Vern->basic->save($pdo, "repo_nbuv_intelligence");
	$i++;
}
