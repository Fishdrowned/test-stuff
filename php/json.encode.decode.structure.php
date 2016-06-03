<?php
$array = array(
	3 => 3,
	4 => 4,
	1 => 1,
);

var_dump('Original:', $array, 'New (encoded => decoded):', $new = json_decode(json_encode($array), true));
var_dump('end($new):', end($new));
$new[2] = 2;
var_dump('Inserted new element:', $new);
var_dump('end($new):', end($new));
var_dump('Decode string:', json_decode('我擦泪'));
