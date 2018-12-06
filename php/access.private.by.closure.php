<?php

error_reporting(-1);

class SomePrivateStubs
{
    private $config = 'yy';

    public function getConfig()
    {
        return $this->config;
    }
}

$somePrivateStubs = new SomePrivateStubs();

var_dump($somePrivateStubs->getConfig());
$modifier = function () {
    var_dump('Set private property on line ' . __LINE__);
    $this->config = 'xx';
    var_dump(__LINE__);
};
$modifier->call($somePrivateStubs);

var_dump($somePrivateStubs->getConfig());
