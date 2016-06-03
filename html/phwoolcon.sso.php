<?php
$secret = '123456';
$ssoServer = 'http://phwoolcon.dev/';
$notifyUrl = 'http://www.localhost.com/test/html/phwoolcon.sso.notify.php';
$initTime = time();
$initToken = md5(md5(1 . $initTime) . $secret);
$debug = true;
$ssoOptions = compact('ssoServer', 'notifyUrl', 'initTime', 'initToken', 'debug');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Phwoolcon SSO</title>
    <!--[if IE]>
    <script src="http://phwoolcon.dev/assets/base/js/ie/json2-20160501.min.js"></script>
    <![endif]-->
    <script src="http://phwoolcon.dev/assets/base/js/sso.js"></script>
</head>
<body>
<script>
    $p.sso.init(<?= json_encode($ssoOptions) ?>);
    $p.sso.check();
</script>
</body>
</html>
