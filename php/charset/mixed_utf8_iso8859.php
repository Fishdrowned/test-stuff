<?php
$str = file_get_contents(__DIR__ . '/sample.json');
//$str1 = utf8_encode($str);
//var_dump($arr = json_decode($str1, true), json_last_error_msg());
//$isp = $arr['isp'];
$replaceStart = strpos($str, '"isp":"') + 7;
$replaceEnd = strpos($str, '"', $replaceStart);
$replaceLength = $replaceEnd - $replaceStart;
$isp = utf8_encode(substr($str, $replaceStart, $replaceLength));
$str2 = substr_replace($str, $isp, $replaceStart, $replaceLength);
echo $str2;
var_dump(json_decode($str2, true));
