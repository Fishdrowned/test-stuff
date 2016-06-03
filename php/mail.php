<?php
error_reporting(-1);
ini_set('display_errors', 'On');

$headers = array("From: fishdrowned@appgame.dev",
"Reply-To: replyto@example.com",
"X-Mailer: PHP/" . PHP_VERSION
);
$headers = implode("\r\n", $headers);
$didhappen = mail('chenshaoming@appgame.com', 'test', 'test', $headers);
var_dump($didhappen);
