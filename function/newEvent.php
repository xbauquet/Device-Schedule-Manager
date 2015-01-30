<?php
session_start();
require '../config.php';

$tableEvents = $_SESSION['tableEvents'];
$dayStamp = $_POST['dayStamp'];

$test = TRUE;
foreach($tableEvents as $tableEvent){
	if($tableEvent['biginingDayTS'] == $dayStamp){
		for($eventNumber=0; $eventNumber< $tableEvent['numberOfEvents']; $eventNumber++){
			if( ($_POST["end"]<$tableEvent['events'][$eventNumber]['end'] 
				AND $_POST["end"]>=$tableEvent['events'][$eventNumber]['start']) 
				OR ( $_POST["start"]>=$tableEvent['events'][$eventNumber]['start'] 
				AND $_POST["start"]<$tableEvent['events'][$eventNumber]['end'])){
					$test = FALSE;
			}
		}
	}
}

if($test==TRUE){
	$req = $DB->prepare('INSERT INTO events (start, end, userId, deviceId) 
		VALUES(:start, :end, :userId, :deviceId)');
	$req->execute(array(
		'start' => $_POST["start"],
		'end' => $_POST["end"],
		'userId' => $_POST["userId"],
		'deviceId' => $_POST["deviceId"],
		));
}else if($test==FALSE){
	$_SESSION['error'] = 'slot';
}