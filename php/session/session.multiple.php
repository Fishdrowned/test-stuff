<?php

include dirname(__DIR__) . '/.include.php';

ini_set('session.use_cookies', 0);
session_save_path(__DIR__ . '/data');
for ($i = 1, $count = 3; $i <= $count; ++$i) {
    var_dump('Loop ' . $i);
    session_id('sid' . $i);
    var_dump(getSessionStatus());
    session_start();
    var_dump(getSessionStatus());
    var_dump($_SESSION);
    $_SESSION['i'] = $i;
    $i == 2 and $_SESSION['xx'] = $i;
    session_write_close();
    var_dump(getSessionStatus());
    unset($_SESSION);
    echo '<hr>';
}

function getSessionStatus()
{
    $statuses = [
        PHP_SESSION_DISABLED => 'Session disabled',
        PHP_SESSION_NONE => 'Session none exists',
        PHP_SESSION_ACTIVE => 'Session active',
    ];
    return $statuses[session_status()];
}
