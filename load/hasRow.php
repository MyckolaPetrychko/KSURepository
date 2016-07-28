<?php
	function hasRow($p1, $pdo, $table){
			$stm1 = $pdo->prepare("use ksu");
			$stm1->execute();
			
			$stm = $pdo->prepare("SELECT `title` FROM `$table` WHERE `title` = '$p1'");
			$stm->execute();
			$row = $stm->fetch();
			if (isset($row['title'])) return false;
			else return true;
	}