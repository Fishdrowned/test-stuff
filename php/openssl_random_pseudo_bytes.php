<?php

function random($length = 16)
{
    $bytes = openssl_random_pseudo_bytes($length * 2);
    return substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $length);
}

var_dump(random(32));
