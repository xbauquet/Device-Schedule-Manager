<table style="border:1px solid black; width:60%; margin:auto;">
	<tr>
		<th style="border:1px solid black; padding:10px;">User name</th>
		<th style="border:1px solid black; padding:10px;">Status</th>
		<th style="border:1px solid black; padding:10px;">Email</th>
	</tr>

<?php 
$r = $DB->query('SELECT * FROM user');
while($user = $r->fetch()){
	echo '<tr>';
		echo '<td style="border:1px solid black; padding:10px;">'.$user['username'].'</td>';
		echo '<td style="border:1px solid black; padding:10px;">'.$user['status'].'</td>';
		echo '<td style="border:1px solid black; padding:10px;">'.$user['mail'].'</td>';
	echo '</tr>';
			
			
} ?>

</table>