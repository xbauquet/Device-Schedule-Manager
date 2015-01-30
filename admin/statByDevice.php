<?php 
include('phpGraph/phpGraph.php');

if(isset($_POST['year'])){
	$year = $_POST['year'];
}else{
	$year = date("Y");
}
// Select a year
echo '<form action="#" method="post" class="form-inline">
	<input type="text" class="form-control" autocomplete="off" name="year" placeholder="'.$year.'"/>
	<input type="submit" class="btn btn-default" value="Ok"/>
</form>
';

//gestion des années bisextiles
if(idate("L", strtotime($year."-1-1"))==1){
	$lastDayOfMonth = array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
}else{
	$lastDayOfMonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
}
$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 
	'September', 'October', 'November', 'December');

$eventGraph = array();
$maintenanceGraph = array();

// encre poru chaque device
foreach($_SESSION['deviceList'] as $device){
echo '<a href="#'.$device.'" style="color:black; margin-left:15px; font-size:1.5em;">'.$device.'</a>';
}

foreach($_SESSION['deviceList'] as $device){
echo '<div id="'.$device.'" style="background-color:#EFEFEF; padding:10px; margin-bottom: 10px; 
	border-radius: 10px;">';
	echo '<h3>'.$device.'</h3>';
	$deviceId = array_search($device, $_SESSION['deviceList']);
	for($i=0; $i<12; $i++){
		$startMonthTS = strtotime($year."-".($i+1)."-1");
		$endMonthTS = strtotime($year."-".($i+1)."-".$lastDayOfMonth[$i]) + (24*60*60) -1;
		
		// select events
		$eventsHours = 0;
		$request = $DB->query('SELECT start, end FROM events WHERE 
			deviceId='.$deviceId.' 
			AND start>='.$startMonthTS.' 
			AND end<='.$endMonthTS);
		while($info = $request->fetch()){
			$eventsHours += ((($info['end'] - $info['start'])/60)/60);
		}
		$eventGraph[substr($months[$i], 0, 3)] = $eventsHours;
		
		//select maintenances
		$maintenancesHours = 0;
		$request = $DB->query('SELECT firstDay, lastDay FROM maintenance WHERE 
			deviceId='.$deviceId.' 
			AND firstDay>='.$startMonthTS.' 
			AND firstDay<='.$endMonthTS.'			
			
			OR deviceId='.$deviceId.' 
			AND lastDay<='.$endMonthTS.'
			AND lastDay>='.$startMonthTS.'
			
			OR deviceId='.$deviceId.' 
			AND firstDay<='.$startMonthTS.'
			AND lastDay>='.$endMonthTS);
			
		while($inf = $request->fetch()){
			$inf['lastDay'] = $inf['lastDay'] + (24*60*60);
		
			if($inf['firstDay'] <= $startMonthTS AND $inf['lastDay'] >= $endMonthTS){
				$maintenancesHours += ((($endMonthTS - $startMonthTS)/60)/60);
			}else if($inf['firstDay'] <= $startMonthTS AND $inf['lastDay'] <= $endMonthTS){
				$maintenancesHours += ((($inf['lastDay'] - $startMonthTS)/60)/60);
			}else if($inf['firstDay'] >= $startMonthTS AND $inf['lastDay'] >= $endMonthTS){
				$maintenancesHours += ((($endMonthTS - $inf['firstDay'])/60)/60);
			}else{
				$maintenancesHours += ((($inf['lastDay'] - $inf['firstDay'])/60)/60);
			}
		}
		$maintenanceGraph[substr($months[$i], 0, 3)] = $maintenancesHours;
	}
	
	$G = new phpGraph();
	echo '<div style="width:50%; float:left;">';
	echo $G->draw($eventGraph,array(
				'stroke' => '#EDBD63', 'title' => 'Reservation in hours - '.$year));
	echo '</div>';			
	echo '<div style="width:50%; float:right;">';
	echo $G->draw($maintenanceGraph,array(
				'stroke' => '#BDDCED', 'title' => 'Maintenance in hours - '.$year));
	echo '</div>';
	
	// Table 
	echo '<table style="width:91%; border: 1px solid black; margin:auto;"><tr> 
		<th style="width:7%; border: 1px solid black;"></th>'; 
	foreach($months as $month){
		echo '<th style="width:7%; border: 1px solid black;">'.$month.'</th>';
	}
	echo '</tr><tr><td style="width:7%; border: 1px solid black;">Reservation</td>';
	foreach($eventGraph as $event){
		echo '<td style="width:7%; border: 1px solid black;">'.$event.'</td>';
	}
	echo '</tr><tr><td style="width:7%; border: 1px solid black;">Maintenance</td>';
	foreach($maintenanceGraph as $maintenance){
		echo '<td style="width:7%; border: 1px solid black;">'.$maintenance.'</td>';
	}
	echo '</tr></table>';
echo '</div>';
}
?>