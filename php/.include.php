<?php
error_reporting(-1);

function array_get(&$array, $key, $default = null, $separator = '.')
{
    $tmp =& $array;
    foreach (explode($separator, $key) as $segment) {
        if (!isset($tmp[$segment])) {
            return $default;
        }
        $tmp =& $tmp[$segment];
    }

    return $tmp;
}

/**
 * Safely get child value from an array or an object
 *
 * @param array|object $array     Subject array or object
 * @param              $key
 * @param mixed        $default   Default value if key not found in subject
 * @param string       $separator Key level separator, default '/'
 *
 * @return mixed
 */
function fnGet(&$array, $key, $default = null, $separator = '/')
{
    if (false === $subKeyPos = strpos($key, $separator)) {
        if (is_object($array)) {
            return property_exists($array, $key) ? $array->$key : $default;
        }
        return isset($array[$key]) ? $array[$key] : $default;
    } else {
        $firstKey = substr($key, 0, $subKeyPos);
        if (is_object($array)) {
            $tmp = property_exists($array, $firstKey) ? $array->$firstKey : null;
        } else {
            $tmp = isset($array[$firstKey]) ? $array[$firstKey] : null;
        }
        if ($tmp === null) {
            return $default;
        }
        return fnGet($tmp, substr($key, $subKeyPos + 1), $default, $separator);
    }
}

function getRequest($key, $default = null)
{
    static $_pathInfo;
    if ($_pathInfo === null) {
        $data = explode('/', trim(fnGet($_SERVER, 'PATH_INFO', '/'), '/'));
        for ($i = 0, $count = count($data); $i < $count; $i += 2) {
            $_REQUEST[fnGet($data, $i)] = fnGet($data, $i + 1);
        }
    }
    return fnGet($_REQUEST, $key, $default);
}

function newFnGet(&$array, $key, $default = null, $separator = '.', $hasObject = false)
{
    $tmp =& $array;
    if ($hasObject) {
        foreach (explode($separator, $key) as $subKey) {
            if (isset($tmp->$subKey)) {
                $tmp =& $tmp->$subKey;
            } else if (is_array($tmp) && isset($tmp[$subKey])) {
                $tmp =& $tmp[$subKey];
            } else {
                return $default;
            }
        }
        return $tmp;
    }
    foreach (explode($separator, $key) as $subKey) {
        if (isset($tmp[$subKey])) {
            $tmp =& $tmp[$subKey];
        } else {
            return $default;
        }
    }
    return $tmp;
}

if (!function_exists('random_bytes')) {
    function random_bytes($length)
    {
        return openssl_random_pseudo_bytes($length);
    }
}

/**
 * Show execution trace for debugging
 *
 * @param bool $exit  Set to true to exit after show trace.
 * @param bool $print Set to true to print trace
 *
 * @return string
 */
function showTrace($exit = true, $print = true)
{
    $e = new Exception;
    if ($print) {
        echo '<pre>', $e->getTraceAsString(), '</pre>';
    }
    if ($exit) {
        exit;
    }
    return $e->getTraceAsString();
}

class Timer
{
    protected static $_times;

    public static function start()
    {
        return static::$_times[0] = explode(' ', microtime());
    }

    public static function stop()
    {
        static::$_times[1] = explode(' ', microtime());
        return (static::$_times[1][0] - static::$_times[0][0]) + (static::$_times[1][1] - static::$_times[0][1]);
    }
}
