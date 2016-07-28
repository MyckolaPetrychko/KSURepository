<?php
	class VernProvider extends BasicProvider{
		public function parse($url, $pdo, $table){
			
		//echo "File $f<br>$file<br><br>";
		
		$content = file_get_contents($url);
		
		$p1 = strpos($content, '<b>1.</b>');
		$content = substr($content, $p1);
		$p2 = strpos($content, '<!--!FORMAT=@insert_export-->');
		$content = substr($content, 0, $p2);
		$size = 0;
		 // number
		 if ($f < 10){
			 $pattern_n1 = '/\<b\>[\d]{1}\.\<\/b\>/';
			$pattern_n2 = '/\<b\>[\d]{2}\.\<\/b\>/';
			$number = array();
			preg_match_all($pattern_n1, $content, $row);
			preg_match_all($pattern_n2, $content, $row1);
			$i = 0; $j = 0;
			for (; $i < count($row[0]); $i++) { $number[$i] = substr(substr($row[0][$i], 0, 4), 3);  }
			for (; $i < count($row1[0]) + count($row[0]); $i++, $j++) { $number[$i] = substr(substr($row1[0][$j], 0, 5), 3); }
		 }else {
			 $pattern_n1 = '/\<b\>[\d]{2}\.\<\/b\>/';
			 preg_match_all($pattern_n1, $content, $row);
			 $i = 0; $j = 0;
			for (; $i < count($row[0]); $i++) { $number[$i] = substr(substr($row[0][$i], 0, 5), 3);  }
		 }
		
		
		
		// author and download
		$i = 0; 

		$author_count = 0;
		$download_count = 0;
		$tmp1 = $content;
		$p1 = strpos($content, '<a title');
		while($p1 > 0){
			if ($i){
				$p1 = strpos($content, '<a title=');
			}
			$content = substr($content, $p1);
			$p2 = strpos($content, '</a>');
			$tmp = substr($content, 0, $p2);
			$content = substr($content, $p2);
			
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
		//echo "<br>!!!$size<br><br>";
		
		// insert into db
		$opt = array(
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		);
		$pdo = new PDO('mysql:host=localhost', 'root', 'root', $opt) or die ("error");
		$stm1 = $pdo->prepare("use ksu");
		$stm1->execute();
		for ($j = 0; $j < $size; $j++){
					$p = addslashes($author[$j]);
					$p1 = addslashes($title[$j]);
					$p2 = addslashes($speciality[$j]);
					$p3 = addslashes($year[$j]);
					$p4 = addslashes($info[$j]);
					$p5 = addslashes($download[$j]);
					if (hasRow($p1, $pdo, $table) === true){
						$stm1 = $pdo->prepare("INSERT INTO `$table` VALUES(NULL, '$p','$p1', '$p2', '$p3', '$p4', '$p5')");
						$stm1->execute();
					}
					
					
		}
	
	}
}
