<?php
header('content-type: text/plain');
$str = 'uploads/mission/20170705/安卓线上测试包1-30-appgame-appgame_cps_001-1499250141547-signed.apk';
echo $str, PHP_EOL;
echo PHP_EOL;

echo 'Locale: ', setlocale(LC_ALL, 0), PHP_EOL;
echo basename($str), PHP_EOL;
setlocale(LC_ALL, 'en_US.UTF-8');
echo 'Locale: ', setlocale(LC_ALL, 0), PHP_EOL;
echo basename($str), PHP_EOL;
