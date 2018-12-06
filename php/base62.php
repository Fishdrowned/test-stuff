<?php
function base62encode($val)
{
    $val = (int)abs($val);
    $base = 62;
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    do {
        $i = $val % $base;
        $str = $chars[$i] . $str;
        $val = ($val - $i) / $base;
    } while ($val > 0);
    return $str;
}

function base62decode($str)
{
    $chars = [
        0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9,
        'a' => 10, 'b' => 11, 'c' => 12, 'd' => 13, 'e' => 14, 'f' => 15, 'g' => 16, 'h' => 17, 'i' => 18,
        'j' => 19, 'k' => 20, 'l' => 21, 'm' => 22, 'n' => 23, 'o' => 24, 'p' => 25, 'q' => 26, 'r' => 27,
        's' => 28, 't' => 29, 'u' => 30, 'v' => 31, 'w' => 32, 'x' => 33, 'y' => 34, 'z' => 35,
        'A' => 36, 'B' => 37, 'C' => 38, 'D' => 39, 'E' => 40, 'F' => 41, 'G' => 42, 'H' => 43, 'I' => 44,
        'J' => 45, 'K' => 46, 'L' => 47, 'M' => 48, 'N' => 49, 'O' => 50, 'P' => 51, 'Q' => 52, 'R' => 53,
        'S' => 54, 'T' => 55, 'U' => 56, 'V' => 57, 'W' => 58, 'X' => 59, 'Y' => 60, 'Z' => 61,
    ];
    $value = 0;
    $base = 1;
    foreach (str_split(strrev($str), 1) as $digit) {
        if (!isset($chars[$digit])) {
            throw new UnexpectedValueException("Unexpected digit '{$digit}'");
        }
        $value += $chars[$digit] * $base;
        $base *= 62;
    }
    return $value;
}

function generateAvatarUrl($id)
{
    $hash = crc32($id) + 3e5;
    $path = substr_replace(substr(base62encode($hash), 0, 4), '/', 2, 0);
    $path = substr(base62encode(crc32($id) + 62), 0, 2);
    $fileName = base62encode($id);
    $url = 'uploads/avatar/' . $path . '/' . $fileName . '.png';
    return $url;
}

foreach ([100548841940001304, 393842, 3938425, 39384256, 1, 2, 3, 4, 62, 0] as $id) {
    $url = generateAvatarUrl($id);
    var_dump($id, $base62 = base62encode($id), base62decode($base62), $url);
}
