<?php

function jsonFnGet($data, $key, $default = null, $separator = '/')
{
    $key = explode($separator, $key);
    $tmp = &$data;
    foreach ($key as $subKey) {
        if (!isset($tmp[$subKey])) {
            return null;
        }
        $tmp = &$tmp[$subKey];
        if (is_string($tmp) && isset($tmp{0}) && $tmp{0} == '{') {
            $tmp = json_decode($tmp, true) ?: $tmp;
        }
    }
    return $tmp;
}

$a = ['x' => '{"a":123}'];
var_dump(jsonFnGet($a, 'x/a'));
