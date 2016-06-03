<?php
$url = 'http://wechat.appgame.com/passport.php?hauth.done=Weixin&dev=1';
var_dump(urlencode($url), rawurlencode($url), http_build_query(array('x' => $url)));
