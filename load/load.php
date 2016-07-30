<?php
	
				require_once('../settings.php');
				$stm1 = $pdo->prepare("use ksu");
				$stm1->execute();
				
				
				
				require('BasicProvider.php');
				require('hasRow.php');
				require('VernProvider.php');
				require('ShevchenkoProvider.php');
				require('ONPUProvider.php');
				
				$Vern = new VernProvider;
				$i = 1;
				while(file_exists("../data/nbuv/01.05.02/$i.html")){
					$Vern->parse("../data/nbuv/01.05.02/$i.html", $pdo, "repo_nbuv_math");
					$i++;
				}
				$i = 1;
				while(file_exists("../data/nbuv/05.13.23/$i.html")){
					$Vern->parse("../data/nbuv/05.13.23/$i.html", $pdo,  "repo_nbuv_intelligence");
					$i++;
				}
				$i = 1;
				while(file_exists("../data/nbuv/05.13.06/$i.html")){
					$Vern->parse("../data/nbuv/05.13.06/$i.html", $pdo, "repo_nbuv_it");
					$i++;
				}
				
			/*	$ONPU = new ONPUProvider;
				$ONPU->parse("http://cisn.opu.ua/science/dissertations", $pdo, '');
				
				$shev = new ShevchenkoProvider;
				$shev->parse("http://cyb.univ.kiev.ua/uk/library.dissertations.html", $pdo, '');*/
				
