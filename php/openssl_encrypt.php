<?php
include __DIR__ . '/.include.php';

var_dump('Loop: ' . $loop = 1e5);
var_dump('Cipher: ' . $cipher = 'aes-128-cfb');
$key = 'oK3FsPtiekTJ#4DgcIdU';
$key = '123456';
$key = 'BnIv15w06qnvibLuuRfVSP9qb9MLPKFg';
var_dump('Key: ' . $key);
var_dump('IV size: ', $ivSize = openssl_cipher_iv_length($cipher));
$data = json_encode(['abc' => 'def', 'xxx1' => 'ooo', 'xxx2' => 'ooo', 'xxx3' => 'ooo', 'xxx4' => 'ooo']);

$encrypted = $iv = '';
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $iv = substr(base64_encode(random_bytes($ivSize)), 0, $ivSize);
    $encrypted = $iv . openssl_encrypt($data, $cipher, $key, 0, $iv);
}
var_dump(Timer::stop());
var_dump('Encrypted: ' . $encrypted, 'IV: ' . $iv);

$decrypted = '';
Timer::start();
for ($i = 0; $i < $loop; ++$i) {
    $iv = substr($encrypted, 0, $ivSize);
    $decrypted = openssl_decrypt(substr($encrypted, $ivSize), $cipher, $key, 0, $iv);
}
var_dump(Timer::stop());
var_dump('Decrypted: ' . $decrypted);
