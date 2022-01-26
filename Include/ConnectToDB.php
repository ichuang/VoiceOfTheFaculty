<?php

// New PDO connection method

	$host = "localhost";
	$db   = "DLB";
	$user = "hereiam";
	$pass = "M\$Estro7";
	$charset = "utf8";

	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	$opt = [
	    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	    PDO::ATTR_EMULATE_PREPARES   => false,
	];
	$pdo = new PDO($dsn, $user, $pass, $opt);
	$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

?>
