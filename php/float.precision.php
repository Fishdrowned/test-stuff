<?php
var_export([ini_get('precision'), 123.45 - 123.44, 100000000123.45 - 123.44]);
/*[
    0 => '14',
    1 => 0.010000000000005116,
    2 => 100000000000.00999,
]*/

ini_set('precision', 13);
var_export([ini_get('precision'), 123.45 - 123.44, 100000000123.45 - 123.44]);
/*[
    0 => '13',
    1 => 0.010000000000005116,
    2 => 100000000000.00999,
]*/
