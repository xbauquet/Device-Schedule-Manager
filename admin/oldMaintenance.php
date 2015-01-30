<table class="tab">
	<tr>
		<th>First day</th>
		<th>Last day</th>
		<th>Device</th>
		<th>Information</th>
	</tr>
<?php 
$req = $DB->query('SELECT * FROM maintenance WHERE lastDay <'.strtotime(date('Y-m-d')) );
while($info = $req->fetch()){
	echo '
	<tr>
		<td style="width:110px;">
			'.date('Y-m-d', $info['firstDay']).'
		</td>
		<td style="width:110px;">
			'.date('Y-m-d', $info['lastDay']).'
		</td>
		<td>
			'.$_SESSION['deviceList'][$info['deviceId']].'
		</td>
		<td>
			'.$info['info'].'
		</td>
		</form>
	</tr>
	';
}
?>
</table>