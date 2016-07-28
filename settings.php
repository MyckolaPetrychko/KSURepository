<?php
	define(HOST, 'localhost');
	define(USER, 'root');
	define(PASSWORD, 'root');
	define(DBNAME, 'ksu');

	$dsn = 'mysql:host=localhost;dbname=user;charset=utf-8';
	$opt = array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	);
	$pdo = new PDO('mysql:host=localhost', 'root', 'root', $opt) or die ("error");