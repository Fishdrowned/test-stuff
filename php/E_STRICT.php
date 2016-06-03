<?php

function &anyFunction($flag) {
	if ($flag) {
		return $flag;
	}
	return false;
}
$byRef = &anyFunction(0);
$byRef = &anyFunction(1);
