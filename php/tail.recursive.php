<?php
function factorial($n, $acc)
{
    if ($n == 0) {
        return $acc;
    }
    return factorial($n - 1, $acc + $n);
}

var_dump(factorial(250, 1));

function factorial2($n, $accumulator = 1) {
    if ($n == 0) {
        return $accumulator;
    }

    return function() use($n, $accumulator) {
        return factorial2($n - 1, $accumulator + $n);
    };
}

function trampoline($callback, $params) {
    $result = call_user_func_array($callback, $params);

    while (is_callable($result)) {
        $result = $result();
    }

    return $result;
}

var_dump(trampoline('factorial2', array(10000)));

var_dump(memory_get_usage(), memory_get_peak_usage());
