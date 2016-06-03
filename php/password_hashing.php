<?php

include __DIR__ . '/.include.php';

$value = '123456';
$hash = [
    10 => '$2y$10$VIEc.iL0881R0YP5yWEHI.NHvVSbhrBUkMyeqOuBcp0rVl313rE/G', // cost = 10
    8 => '$2y$08$JT3u4B1HUiFSR6045BDxEe5ADShZxpoDwkWbBdvDuNCvwF00yeLUW', // cost = 8

    '10-p' => '$2y$10$s0XqLcGRjmjre4ZoED74.O4rAIJCmXH39SedL5eXVEgzt5Pixb/5K', // cost = 10, pre hashed
    '8-p' => '$2y$08$cWKCDexJLD9os0J45HMJ.O.ip.Iv4Y.DtLH8w4bSeYcCjElTfFAT6', // cost = 8,  pre hashed

    7 => '$2y$07$N96NxYh1o1pZmsB36HfZwexN.pK9T1A6y5G6vcozf7HuVbuJsyPQ2', // cost = 7, pre hashed
    6 => '$2y$06$gHTFiWITalAX5qluN0FO1eCC/mIePQmeAYGyfv9o8Tj/tSm2t0iTm', // cost = 6, pre hashed
    5 => '$2y$05$dhSCs2naF7K4s3mpdeo8Je.5XOEhE8iUSqE8UhQb5qZxylRrC2tLe', // cost = 5, pre hashed
];
$hasher = new \Phalcon\Security();
$hasher->setWorkFactor(5);
$hasher->setDefaultHash($hasher::CRYPT_BLOWFISH_Y);
Timer::start();
for ($i = 0; $i < $count = 350; ++$i) {
//	password_hash($value, PASSWORD_BCRYPT, array('cost' => 10));
//	password_verify($value, $hash[10]);
//	password_needs_rehash($hash[10], PASSWORD_BCRYPT, array('cost' => 10));
//	hold_vars($preHashedValue = md5(md5($value) . $salt = 'd3f908'), $salt, password_hash($preHashedValue, PASSWORD_BCRYPT, array('cost' => 8)));
//	hold_vars($preHashedValue = md5(md5($value) . $salt = 'd3f908'), $salt, password_hash($preHashedValue, PASSWORD_BCRYPT, array('cost' => 7)));
//	hold_vars($preHashedValue = md5(md5($value) . $salt = 'd3f908'), $salt, password_hash($preHashedValue, PASSWORD_BCRYPT, array('cost' => 6)));
//	hold_vars($preHashedValue = md5(md5($value) . $salt = 'd3f908'), $salt, password_hash($preHashedValue, PASSWORD_BCRYPT, array('cost' => 5)));
//	hold_vars(password_verify('1b865502079ccc9dc572f0923ac64277', $hash[7]));
//	hold_vars(password_verify('1b865502079ccc9dc572f0923ac64277', $hash[6]));
    hold_vars($preHashedValue = md5(md5($value) . $salt = 'd3f908'), $salt, $hasher->hash($preHashedValue));
}
var_dump($time = Timer::stop(), $time / $count * 1000 . 'ms');
var_dump($_SERVER['hold_vars'], password_verify($_SERVER['hold_vars'][0], $_SERVER['hold_vars'][2]));

function hold_vars()
{
    $_SERVER['hold_vars'] = func_get_args();
}
