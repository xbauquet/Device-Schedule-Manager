<?php
session_start();
require '../config.php';

$id = $_POST["id"];
$request = $DB->query('SELECT username FROM user WHERE id='.$id);
$info = $request->fetch();

$DB->exec('DELETE FROM user WHERE id='.$id);
$DB->exec('DELETE FROM events WHERE userId='.$id);
$_SESSION['selectedUser'] = 'unknowUser';
$_SESSION['infoDeletedUser'] = $info['username'];