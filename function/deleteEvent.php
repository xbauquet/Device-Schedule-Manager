<?php
require '../config.php';

$id = $_POST["id"];
$DB->exec('DELETE FROM events WHERE id='.$id);