<?php
function benchSimpleCall()
{
}

function benchSimpleCallWithArgs($v)
{
}

function benchSimpleCallWithArgsAndReturn($v)
{
    return $v;
}

if (PHP_VERSION_ID > 70006) {
    include __DIR__ . '/type.hint.functions.php';
} else {
    function benchSimpleCallWithStaticTypeHintArgs($v)
    {
        return $v;
    }
}
