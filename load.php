<?php
header('Content-type: application/json;charset=utf-8');
$fp    = 'lst.txt';
$myfile = fopen($fp, "r");
$data = fgets($myfile);
fclose($myfile);
echo substr_count($data,"who_status");
?>
