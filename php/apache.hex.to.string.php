<?php

class ApacheHexStringConverter
{
    public static function convert($input, &$output)
    {
        if (!isset($input{0})) {
            return;
        }
        if (substr($input, 0, 2) == '\\x') {
            $hex = substr($input, 2, 2);
            $output .= chr(hexdec($hex));
            return static::convert(substr($input, 4), $output);
        } else {
            $nextPosition = strpos($input, '\\x');
            if ($nextPosition === false) {
                $output .= $input;
                return;
            } elseif ($nextPosition) {
                $output .= substr($input, 0, $nextPosition);
                return static::convert(substr($input, $nextPosition), $output);
            } else {
                return static::convert($input, $output);
            }
        }
    }
}

$input = str_replace(["\n", "\r"], '', $_GET['input']);
var_dump($input);
ApacheHexStringConverter::convert($input, $output);
var_dump($output);
