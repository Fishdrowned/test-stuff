<?php
include __DIR__ . '/.include.php';
$type = getRequest('type', 'string');
$rounds = 1000;
$stringParts = 1000;
$substring = str_pad('', 100, 'a');
Timer::start();
if ($type == 'string') {
	for ($i = 0; $i < $rounds; ++$i) {
		$result = '';
		for ($j = 0; $j < $stringParts; ++$j) {
			$result .= $substring;
		}
	}
} else {
	for ($i = 0; $i < $rounds; ++$i) {
		$result = array();
		for ($j = 0; $j < $stringParts; ++$j) {
			$result[] = $substring;
		}
		$result = implode('', $result);
	}
}
var_dump('Type = ' . $type, Timer::stop() . ' s', round(memory_get_peak_usage() / 1024, 2) . 'KiB', strlen($result));
