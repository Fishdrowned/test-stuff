<?php
$authUser = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '';
$authPassword = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';
$availableUsers = is_file($authFile = $_SERVER['HOME'] . '/http-auth-users.php') ? include $authFile : [];
$hasUser = isset($availableUsers[$_SERVER['HTTP_HOST']][$authUser]);
if (!$hasUser || !password_verify($authPassword, $availableUsers[$_SERVER['HTTP_HOST']][$authUser])) {
    header('WWW-Authenticate: Basic realm="Auth required"');
    header('HTTP/1.1 401 Unauthorized');
    echo "Authorization required to access {$_SERVER['HTTP_HOST']}";
    exit;
} else {
    echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
    echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p>";
}
