<?php 
// Get results of the events function
// ----------------------------------
$thead = $results[0];
$times = $results[1];
$tableEvents = $results[2];
?>
<div id="events">
	<table id="eventsTable" >
		<thead>
			<tr>
				<th></th>
				<?php 
				// Display name and date of days of the curent week on the schedul
				// ---------------------------------------------------------------
				foreach ($thead as $head): ?>
					<th <?php if($head[2]==strtotime(date('Y-m-d'))){ 
							echo 'style="color:red; text-align:center;"';
						}else{ echo 'style= text-align:center;"';} ?> >
						<?php echo $head[1]; ?> 
					</th>
				<?php endforeach; ?>
			</tr>
		</thead>
		<tbody>
			<tr class="trEvent">
				<td class="time">
				<?php 
				// Display the hour column
				// -----------------------
				foreach($times as $timeTab){
					echo "<div style='height:40px;'>".$timeTab."</div>";
				}?>
				</td>
				<?php 
				//---------------------------------------------------
				// For test
				//
				//echo '<pre>'; print_r($tableEvents); echo '</pre>';
				//---------------------------------------------------
				// Counter for 
				$i=1;
				$_SESSION['tableEvents'] = $tableEvents;					
				foreach($tableEvents as $tableEvent){
				
					// Verification of maintenance date
					// --------------------------------
					if(isset($tableEvent['maintenance'])){
						// size of the maintenance "event" corresponding of the entire day
						$mPixelSize = (21-7)*4*10;
						echo '<td class="timesTab" id="'.$thead[$i][2].'">';
						$i = $i +1;
						// Display the maintenance on the day
						// ----------------------------------
						echo'
						<div class="maintenanceEvent" 
							style="margin-top:0px; height:'.$mPixelSize.'px; position:absolute;">
							<div>From '.date("Y-m-d",$tableEvent['maintenance']['firstDay']).'</br> 
								to '.date("Y-m-d",$tableEvent['maintenance']['lastDay']).'</div>
								</br></br>
							<div >'.$tableEvent['maintenance']['info'].'</div>
						</div>
						</td>';
													
					// Events if no maintenance
					// ------------------------
					}else{
						/* Add the class eventAddable for days from today. This appart avoid the 
						modification of events (add or delete) for previous days. */
						if($tableEvent['biginingDayTS'] < $_SESSION['todayTS']){
							$tableEventClass = 'timesTab';
						}else{
							$tableEventClass = 'timesTab eventAddable';
						}
						echo '<td class="'.$tableEventClass.'" id="'.$thead[$i][2].'">';
						$i = $i +1;
						
						// Making an array for the display of margin of events overlapping.
						// ----------------------------------------------------------------
						$marginArray = array();
						$k = 0;
						for($j=0; $j<$tableEvent['numberOfEvents']; $j++){
							$marginArray[$j] = $k;
							$k++;
							if($k==$tableEvent['maxOverlapping']){
								$k=0;
							}
						}
						//----------------------
						// For test
						//print_r($marginArray);
						//----------------------
						
						for($eventNumber=0; 
							$eventNumber< $tableEvent['numberOfEvents']; 
							$eventNumber++){
							
							$eventStart = $tableEvent['events'][$eventNumber]['start'];
							$eventEnd = $tableEvent['events'][$eventNumber]['end'];
							$eventPixelSize = $tableEvent['events'][$eventNumber]['pixelSize'];
							$eventId = $tableEvent['events'][$eventNumber]['id'];
							$marginTop = ($tableEvent['events'][$eventNumber]['qhStart']*10)-281;
							
							// Recovery of the device name with its id 
							$deviceName = $_SESSION['deviceList']
											[$tableEvent['events'][$eventNumber]['deviceId']];
							// Recovery of the user name with its id 
							$request = $DB->query('SELECT username 
										FROM user 
										WHERE id='.$tableEvent['events'][$eventNumber]['userId']);
							while($info = $request->fetch()){
								$return[] = $info;
							}
							$userName = $return[0]['username'];
							unset($return);

							/* Add the class "deletable" to events of the connected user that able
							the deletation of his events */
							if($_SESSION['userId'] != $tableEvent['events'][$eventNumber]['userId'] 
								AND $testStatus == 'user' OR $eventStart < $_SESSION['todayTS']){
								$classDate = 'calendarEventDateOtherUser';	
								$classEvent = 'calendarEvent';
							}else{
								$classDate = 'calendarEventDate';	
								$classEvent = 'calendarEvent deletable';
							}

							/* Prepare the width and the margin-left of the event if is overlapping 
							with other events or not */
							if(isset($tableEvent['maxOverlapping']) 
								AND $tableEvent['maxOverlapping']!=0){
								$width = 13.3 / $tableEvent['maxOverlapping'];
								$margin = $width * $marginArray[$eventNumber];
							}else{
								$width = 13.3;
								$margin = 0;
							}
							// Display the event
							echo'
							<div class="'.$classEvent.'" id="'.$eventId.'" 
								style="margin-top:'.$marginTop.'px; height:'.$eventPixelSize.'px; 
								position:absolute; width: '.$width.'%; margin-left:'.$margin.'%; ">
								<div class="'.$classDate.'" id="'.$eventId.'Date" >
									<span>'.date('H', $eventStart).':'.date('i', $eventStart).' - 
										'.date('H', $eventEnd).':'.date('i', $eventEnd).'</span>
								</div>
								<div class="eventTitle" id="'.$eventId.'Title">
									'.$deviceName.'</div>
								<div class="eventContent" id="'.$eventId.'Content">
									'.$userName.'</div>
							</div>';
							}
						echo '</td>';
						}
					}?>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- For javascript dialog -->
	<div id="dialog" title="Delete event"></div>
	<div id="ajax"></div>

	<?php 
	// Dialog for adding new events
	// ----------------------------
	if(isset($_GET['mode'])): ?>
	<div id="dialogNewEvent" title="New event">
		<?php
		echo '<p>'.$_SESSION['user'].'</p><p>'.$_GET['mode'].'</p>';
		$deviceId = array_search($_GET['mode'], $_SESSION['deviceList']);
		?>
		<form action="">
			<input type="hidden" name="newEventDeviceId" id="newEventDeviceId" 
				value="<?php echo $deviceId; ?>"/>
			<input type="hidden" name="newEventUsername" id="newEventUserId" 
				value="<?php echo $_SESSION['userId']; ?>"/>
        	Start:
        	<select name="newEventStart" id="newEventStart">
        		<?php 
        		$listHours = array('7:00', '7:15', '7:30', '7:45', '8:00', '8:15', '8:30', '8:45', 
        			'9:00', '9:15', '9:30', '9:45', '10:00', '10:15', '10:30', '10:45', '11:00', 
        			'11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15',
        			'13:30', '13:45', '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30',
        			'15:45', '16:00','16:15' ,'16:30' ,'16:45' ,'17:00', '17:15', '17:30', '17:45',
        			'18:00', '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00',
        			'20:15', '20:30', '20:45');
        		foreach($listHours as $hour){
        			echo '<option value="'.$hour.'">'.$hour.'</option>';
        		}
        		?>
        	</select></br>
        	End: 
        	<select name="newEventEnd" id="newEventEnd">	
        		<?php 
        		foreach($listHours as $hour){
        			echo '<option value="'.$hour.'">'.$hour.'</option>';
        		}
        		?>
        	</select>
		</form>
	</div>
	<?php endif; ?>
	
