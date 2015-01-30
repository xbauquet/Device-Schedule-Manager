<?php 
require 'config.php';
/* -----------------------------------------------------------
 * Choossing Date
----------------------------------------------------------- */
function choosingDateFct($choosingDate){
	global $DB;
	if(!isset($choosingDate) AND !isset($_SESSION['choosingDate'])){
		$_SESSION['choosingDate'] = date('Y-m-d');
	}else if(isset($_POST['choosingDate'])){
		$_SESSION['choosingDate'] = date($choosingDate);
	}
}

/* -----------------------------------------------------------
 * Selected user for admin part
----------------------------------------------------------- */
function selectedUserFct($selectedUser){
	global $DB;
	$req = $DB->query('SELECT id, username FROM user WHERE username="'.$selectedUser.'"');
	while($info = $req->fetch()){
		$return[] = $info;
	}
	if($return != NULL){
		$_SESSION['selectedUser']=$selectedUser;
		$_SESSION['selectedUserId']=$return[0]['id'];
	}else{
		$_SESSION['error']='unknowUser'; echo '<script>window.location.reload();</script>';
	}
}

/* -----------------------------------------------------------
 * Identification verification
----------------------------------------------------------- */
function identificationVerif(){
	global $DB;
	$req = $DB->query('SELECT password, status FROM user WHERE username="'.$_SESSION['user'].'"');
	while($info = $req->fetch()){
		$userInfo[] = $info;
	}
	if($userInfo[0]['password'] == $_SESSION['password']){
		if($userInfo[0]['status'] == 'admin'){ return 'admin'; }
		if($userInfo[0]['status'] == 'user'){ return 'user'; }
	}else{
		session_destroy();
		header('Location:index.php');
	}
}

/* -----------------------------------------------------------
 * Events function
----------------------------------------------------------- */
function events($newDate, $userId, $deviceId){
	global $DB;
	//timestamp for 7 days
	$sevenDayTS = (7*24*60*60)-1;

	//choosing date
	$myDate = new DateTime($newDate);
	$myDay = $myDate -> format('d');
	$myMonth = $myDate -> format('m');
	$myYear = $myDate -> format('Y');
	//timestamp of my date
	$myDateTS = strtotime(strval($newDate));

	// timestamp of the first day of the week
	// name of my day
	$myDayName = $myDate -> format('D');
	// calculate of the timestamp to substract to the timestamp of my day
	switch(strtoupper($myDayName)){
		case "SUN" : $n = 0;
			break;
		case "MON" : $n = 1;
			break;
		case "TUE" : $n = 2;
			break;
		case "WED" : $n = 3;
			break;
		case "THU" : $n = 4;
			break;
		case "FRI" : $n = 5;
			break;
		case "SAT" : $n = 6;
			break;
	}
	// timestamp for 1 day
	$oneDayTS = 24*60*60;
	$beginingOfWeekTS = $myDateTS - ($n * $oneDayTS);
	// timestamp of the end of the week 
	$endOfWeekTS = $beginingOfWeekTS + $sevenDayTS;
	
	// Head of the future events tab
	$thead = array(
		"1"=> array("1" => "Sun. ".date("j/m", $beginingOfWeekTS), "2" => $beginingOfWeekTS),
		"2"=> array("1" => "Mon. ".date("j/m", $beginingOfWeekTS+(1*$oneDayTS)),
			"2" => $beginingOfWeekTS+(1*$oneDayTS)),
		"3"=> array("1" => "Tue. ".date("j/m", $beginingOfWeekTS+(2*$oneDayTS)),
			"2" => $beginingOfWeekTS+(2*$oneDayTS)),
		"4"=> array("1" => "Wed. ".date("j/m", $beginingOfWeekTS+(3*$oneDayTS)),
			"2" => $beginingOfWeekTS+(3*$oneDayTS)),
		"5"=> array("1" => "Thu. ".date("j/m", $beginingOfWeekTS+(4*$oneDayTS)),
			"2" => $beginingOfWeekTS+(4*$oneDayTS)),
		"6"=> array("1" => "Fri. ".date("j/m", $beginingOfWeekTS+(5*$oneDayTS)),
			"2" => $beginingOfWeekTS+(5*$oneDayTS)),
		"7"=> array("1" => "Sat. ".date("j/m", $beginingOfWeekTS+(6*$oneDayTS)),
			"2" => $beginingOfWeekTS+(6*$oneDayTS))
	);
	// Tab of times
	$times = array();
	// from 7 to 21h 
	for($i=7; $i<21 ;$i++){
		$times[$i]=$i.'h00';
	}
	
	// Tab of events 
	$tableEvents = array();
	for($i=0; $i<7; $i++){
		$beginingDayTS = $beginingOfWeekTS + ($i*$oneDayTS);
		$endDayTS = $beginingDayTS + $oneDayTS - 1;
		if($beginingDayTS == strtotime(date('Y-m-d'))){
			$class = "todayEvents"; }
		else{
			$class = "otherDayEvents"; }
	
		$tableEvents[$i]['class'] = $class;
		$tableEvents[$i]['biginingDayTS'] = $beginingDayTS;
		$eventNumber=0;
		
		// Maintenance
		if($deviceId!=NULL){
			$r = $DB->query('SELECT * FROM maintenance WHERE 
				firstDay<='.$beginingDayTS.' 
				AND lastDay>='.$beginingDayTS.' 
				AND deviceId='.intval($deviceId));
			while($info = $r->fetch()){
				$maintenance[] = $info; }
			$r->closeCursor();
		}
		if(isset($maintenance)){
			$tableEvents[$i]['maintenance']['id'] = $maintenance[0]['id'];
			$tableEvents[$i]['maintenance']['info'] = $maintenance[0]['info'];
			$tableEvents[$i]['maintenance']['firstDay'] = $maintenance[0]['firstDay'];
			$tableEvents[$i]['maintenance']['lastDay'] = $maintenance[0]['lastDay'];
			unset($maintenance);
		}else{
			if($userId!=NULL){
				$r = $DB->query('SELECT * FROM events WHERE 
					start>='.$beginingDayTS.' 
					AND end<='.$endDayTS.' 
					AND userId='.$userId.' 
					ORDER BY start');
				while($info = $r->fetch()){
					$events[] = $info; }
				$r->closeCursor();
			}else if($deviceId!=NULL){
				$r = $DB->query('SELECT * FROM events WHERE 
					start>='.$beginingDayTS.' 
					AND end<='.$endDayTS.' 
					AND deviceId='.$deviceId.' 
					ORDER BY start');
				while($info = $r->fetch()){
					$events[] = $info; }
				$r->closeCursor();
			}
			if(isset($events)){
			$j=0;
			$maxOverlapping=0;
			while($j<count($events)){
				// event information
				$tableEvents[$i]['events'][$eventNumber]['id'] = $events[$j]['id'];
				$tableEvents[$i]['events'][$eventNumber]['deviceId'] = $events[$j]['deviceId'];
				$tableEvents[$i]['events'][$eventNumber]['userId'] = $events[$j]['userId'];
				$tableEvents[$i]['events'][$eventNumber]['start'] = $events[$j]['start'];
				$tableEvents[$i]['events'][$eventNumber]['end'] = $events[$j]['end'];
				// quart hour saving
				$lapTimeEvents = ($events[$j]['end'] - $events[$j]['start']) /60 /60; // in hours
				$tableEvents[$i]['events'][$eventNumber]['numQuartHours'] = ceil($lapTimeEvents*4);
				// pixel size saving
				$eventPixelSize = ceil($lapTimeEvents * 4) * 10; // 10 pixel for each quart d'heure
				$tableEvents[$i]['events'][$eventNumber]['pixelSize'] = $eventPixelSize;
				// first quart hour of the event saving
				$firstQuartHour = (date('H', $events[$j]['start'])*4) 
								+ (date('i', $events[$j]['start'])/15);
				$tableEvents[$i]['events'][$eventNumber]['qhStart'] = ceil($firstQuartHour);
				// incrementation
				
				$overlapping = 1;
				for($k=$j+1; $k<count($events); $k++){
					
					if($events[$k]['start'] >= $events[$j]['start'] 
						AND $events[$k]['start'] <= $events[$j]['end'] 
						OR $events[$k]['end'] >= $events[$j]['start'] 
						AND $events[$k]['end'] <= $events[$j]['end']){
							$overlapping++;	
					}
					if($maxOverlapping < $overlapping AND $overlapping > 1){
						$maxOverlapping=$overlapping;
					}
				}
				$eventNumber++;
				$j++;
			}
			unset($events);
			}
			$tableEvents[$i]['numberOfEvents'] = $eventNumber;
			if(isset($maxOverlapping)){
				$tableEvents[$i]['maxOverlapping'] = $maxOverlapping;
				unset($maxOverlapping);
			}
		}
	}
	return array($thead, $times,$tableEvents);
}

