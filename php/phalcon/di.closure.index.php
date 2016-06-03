<?php
error_reporting(-1);

set_error_handler(function ($errNo, $errStr, $errFile, $errLine) {
    $levels = [
        E_WARNING => 'Warning',
        E_NOTICE => 'Notice',
        E_STRICT => 'Strict',
        E_DEPRECATED => 'Deprecated',
    ];
    $errLevel = $errNo;
    isset($levels[$errNo]) and $errLevel = $levels[$errNo];
//    throw new ErrorException($errLevel . ' - ' . $errStr, $errNo, 1, $errFile, $errLine);
    var_dump($errLevel . ' - ' . $errStr, $errNo, 1, $errFile, $errLine);
});

class SomeStaticClass
{

    public static function someStaticMethod()
    {
        include __DIR__ . '/di.closure.php';
    }
}

SomeStaticClass::someStaticMethod();
