<?php

set_error_handler(function ($errNo, $errStr, $errFile, $errLine) {
    throw new ErrorException($errStr, $errNo, 1, $errFile, $errLine);
});

try {
    ob_start();
    try {
        include __DIR__ . '/bad_template.phtml';
    } catch (Exception $e) {
        ob_get_clean();
        throw new ErrorException($e->getMessage(), $e->getCode(), 1, $e->getFile(), $e->getLine(), $e);
    }
    $content = ob_get_clean();
    echo $content;
} catch (Exception $e) {
    echo $e, PHP_EOL;
}

ob_start();
include __DIR__ . '/good_template.phtml';
$content = ob_get_clean();
echo $content;
