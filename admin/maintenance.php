<?php 
session_start();
require '../config.php';

$startMaintenance = strtotime($_POST['startMaintenance']);
$endMaintenance = strtotime($_POST['endMaintenance']);
$deviceId = $_POST['deviceMaintenance'];
$information = $_POST['infoMaintenance'];

$timeDayTS = (21-7)*60*60;
$endDayMaintenance = $timeDayTS + $endMaintenance;

$DB->exec('INSERT INTO maintenance (firstDay, lastDay, deviceId, info) 
	VALUE ("'.$startMaintenance.'","'.$endMaintenance.'","'.$deviceId.'","'.$information.'")');

$r = $DB->query('SELECT id, start, end, userId, deviceId FROM events WHERE 
	start >='.$startMaintenance.' 
	AND end<='.$endDayMaintenance.' 
	AND deviceId='.$deviceId);
while($info = $r->fetch()){
	$events[] = $info;
}
if(isset($events)){
	foreach($events as $event){
		$DB->exec('DELETE FROM events WHERE id='.$event['id']);
		$r = $DB->query('SELECT mail FROM user WHERE id='.$event['userId']);
		while($userMail = $r->fetch()){
			$message = "Your reservation of the ".date("Y-m-d H:i:s", $event['start'])." for 
			the ".$_SESSION['deviceList'][$event['deviceId']]." had been delete because of a 
			maintenance on this device.\r\n Information about the maintenance: ".$information."\r
			\n We apologize for any inconvenience.";
			mail($userMail['mail'], 'Reservation deleted', $message);	
		}
		
	}
}
header('Location: ../index.php');