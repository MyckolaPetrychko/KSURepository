<?php
	abstract class BasicProvider{
		abstract protected function parse($url, $pdo, $table);
		
	}