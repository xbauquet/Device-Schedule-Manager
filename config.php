<?php
try{
	$DB = new PDO('mysql:host=localhost; dbname=platformCalendar', 
	'root', 
	'root', 
	array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8', 
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
	);
}
catch(PDOException $e){
	echo 'erreur';
	exit();
}