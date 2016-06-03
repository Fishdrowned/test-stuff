<?php
if (empty($_GET['openssl_random_pseudo_bytes'])) {
    $min = 0;
    $max = 4;
    $results = [];
    for ($i = 0, $count = 1e5; $i < $count; ++$i) {
        $v = mt_rand($min, $max);
        isset($results[$v]) ? ++$results[$v] : $results[$v] = 0;
    }
    ksort($results);
    var_dump($results);
    echo '<a href="?openssl_random_pseudo_bytes=1">mt_rand vs openssl_random_pseudo_bytes</a>';
    return;
}
use Phalcon\Text;
use Phalcon\Security\Random;

include __DIR__ . '/.include.php';

var_dump('Count', $count = 1e4);
Timer::start();
for ($i = 0; $i < $count; ++$i) {
    $rand = Text::random(Text::RANDOM_HEXDEC, 32);
}
var_dump('Phalcon\Text::random(Text::RANDOM_HEXDEC, 32)', Timer::stop(), $rand);

Timer::start();
$random = new Random();
for ($i = 0; $i < $count; ++$i) {
    $rand = $random->hex();
}
var_dump('Phalcon\Security\Random::hex()', Timer::stop(), $rand);

function phalconRandBin2Hex() {
    static $random;
    $random or $random = new Random();
    return bin2hex($random->bytes());
}

Timer::start();
for ($i = 0; $i < $count; ++$i) {
    $rand = phalconRandBin2Hex();
}
var_dump('phalconRandBin2Hex()', Timer::stop(), $rand);

function cachedPoolRand($length)
{
    static $pool, $end;
    $pool === null and $pool = array_merge(range(0, 9), range('a', 'f'));
    $end === null and $end = count($pool) - 1;

    $str = '';
    for ($i = 0; $i < $length; ++$i) {
        $str .= $pool[mt_rand(0, $end)];
    }
    return $str;
}
Timer::start();
for ($i = 0; $i < $count; ++$i) {
    $rand = cachedPoolRand(32);
}
var_dump('cachedPoolRand(32)', Timer::stop(), $rand);

function md5MtRand()
{
    return md5(mt_rand(0, PHP_INT_MAX));
}
Timer::start();
for ($i = 0; $i < $count; ++$i) {
    $rand = md5MtRand();
}
var_dump('md5MtRand()', Timer::stop(), $rand);

function opensslRandom()
{
    return bin2hex(openssl_random_pseudo_bytes(16));
}
Timer::start();
for ($i = 0; $i < $count; ++$i) {
    $rand = opensslRandom();
}
var_dump('opensslRandom()', Timer::stop(), $rand);

function md5OpensslRandom()
{
    return md5(openssl_random_pseudo_bytes(16));
}
Timer::start();
for ($i = 0; $i < $count; ++$i) {
    $rand = md5OpensslRandom();
}
var_dump('md5OpensslRandom()', Timer::stop(), $rand);
