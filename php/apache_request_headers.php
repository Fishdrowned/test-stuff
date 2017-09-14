<?php

if (function_exists('getallheaders')) {
    var_dump(getallheaders());
} else {
    var_dump('No getallheaders function');
}
