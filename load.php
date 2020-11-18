﻿<?php

function json_encode_cyr($str) {
	$arr_replace_utf = array('\u0410', '\u0430','\u0411','\u0431','\u0412','\u0432',
	'\u0413','\u0433','\u0414','\u0434','\u0415','\u0435','\u0401','\u0451','\u0416',
	'\u0436','\u0417','\u0437','\u0418','\u0438','\u0419','\u0439','\u041a','\u043a',
	'\u041b','\u043b','\u041c','\u043c','\u041d','\u043d','\u041e','\u043e','\u041f',
	'\u043f','\u0420','\u0440','\u0421','\u0441','\u0422','\u0442','\u0423','\u0443',
	'\u0424','\u0444','\u0425','\u0445','\u0426','\u0446','\u0427','\u0447','\u0428',
	'\u0448','\u0429','\u0449','\u042a','\u044a','\u042b','\u044b','\u042c','\u044c',
	'\u042d','\u044d','\u042e','\u044e','\u042f','\u044f');
	$arr_replace_cyr = array('А', 'а', 'Б', 'б', 'В', 'в', 'Г', 'г', 'Д', 'д', 'Е', 'е',
	'Ё', 'ё', 'Ж','ж','З','з','И','и','Й','й','К','к','Л','л','М','м','Н','н','О','о',
	'П','п','Р','р','С','с','Т','т','У','у','Ф','ф','Х','х','Ц','ц','Ч','ч','Ш','ш',
	'Щ','щ','Ъ','ъ','Ы','ы','Ь','ь','Э','э','Ю','ю','Я','я');
	$str1 = json_encode($str);
	$str2 = str_replace($arr_replace_utf,$arr_replace_cyr,$str1);
	return $str2;
	}


$name = $_POST['pr_name'];

include 'sql.php';

$mys = new mysqli('localhost',$sql,$pass,$sql);

$tbl = $mys -> query("SELECT * FROM `rsp` WHERE `name` = '$name'");

$i=0;

while($res_tbl = $tbl->fetch_assoc()){
	$arr[$i][0] = $res_tbl['name'];
	$arr[$i][1] = $res_tbl['groups'];
	$arr[$i][2] = $res_tbl['group'];
	$arr[$i][3] = $res_tbl['week'];
	$arr[$i][4] = $res_tbl['time'];
	$arr[$i][5] = $res_tbl['pair'];
	$i++;
}

$arr = json_encode_cyr($arr);

echo $arr;

?>