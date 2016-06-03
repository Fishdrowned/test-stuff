<?php
$source = array(
    'grant_types' => array(
        'authorization_code' => array(
            'class' => 'oo',
            'access_token_ttl' => 3600,
        ),
        'xx' => '00',
    ),
);
$replace = array(
    'grant_types' => array(
        'authorization_code' => array(
            'access_token_ttl' => 315360000,
        ),
    ),
);

echo '<pre>';
var_export(array_replace_recursive(array(array(array($source))), array(array(array($replace)))));
