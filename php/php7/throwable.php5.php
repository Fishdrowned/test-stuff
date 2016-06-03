<?php

if (!interface_exists('Throwable')) {
    interface Throwable
    {

        public function getMessage();

        public function getCode();

        public function getFile();

        public function getLine();

        public function getTrace();

        public function getTraceAsString();

        public function getPrevious();

        public function __toString();
    }

    class Error extends Exception implements Throwable
    {
    }
}

// set_error_handler is resumable
set_error_handler(function ($errNumber, $errStr, $errFile, $errLine) {
    var_dump(func_get_args());
    throw new ErrorException($errStr, $errNumber, $errNumber, $errFile, $errLine);
});

// set_exception_handler will terminate execution
set_exception_handler(function (Exception $e) {
    echo 'Caught by set_exception_handler, <pre>';
    echo $e->__toString();
});
function s(array $a)
{
}

try {
    echo PHP_VERSION, PHP_EOL;
    s(4);
    throw new Error('Error');
} catch (Exception $e) {
    echo 'Caught as Exception, <pre>';
    echo $e->__toString();
} catch (Throwable $e) {
    echo 'Caught as Throwable, <pre>';
    echo $e->__toString();
}
echo PHP_EOL;
echo 'Resumed';
