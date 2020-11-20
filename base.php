<?php
$send = $_POST['send'];

$array = JSON_decode($send);

echo 1;



include 'sql.php';

$mys = new mysqli('localhost',$sql,$pass,$db);

$arr_count = count($array);

$name = $array[0][0];

$mys -> query("DELETE FROM `rsp` WHERE `name` = '$name'");

for($i=0;$i<$arr_count;$i++){
	$groups = $array[$i][1];
	$group = $array[$i][2];
	$week = $array[$i][3];
	$time = $array[$i][4];
	$pair = $array[$i][5];
	$date = time();
	$mys -> query("INSERT INTO `rsp`(`groups`, `group`, `week`, `time`, `pair`, `date`,`name`) VALUES ('$groups', '$group', '$week', '$time', '$pair', '$date', '$name')");
}


?>
