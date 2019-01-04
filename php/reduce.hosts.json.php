<?php

if (empty($argv[1])) {
    echo "Usage: php {$argv[0]} <hosts.json>";
    exit(1);
}

if ((!$inputFile = realpath($argv[1])) || !file_exists($inputFile)) {
    echo "File `$argv[1]` does not exist";
    exit(1);
}

if (is_dir($inputFile)) {
    echo "`$argv[1]` is directory";
    exit(1);
}
$outputFile = dirname($inputFile) . '/' . 'reduced-' . basename($inputFile);

$raw = json_decode(file_get_contents($inputFile), true);

$reduced = [];

$hasShorterTerms = function ($k, $list) {
    $parts = explode('.', $k);
    while (isset($parts[2])) {
        array_shift($parts);
        if (isset($list[implode('.', $parts)])) {
            return true;
        }
    }
    return false;
};

foreach ($raw as $k => $v) {
    if ($hasShorterTerms($k, $raw)) {
        continue;
    }
    $reduced[$k] = 1;
}
ksort($reduced);

$output = "{";
$line = $newLine = "\n    ";
foreach ($reduced as $k => $v) {
    $kv = '"' . $k . '":1,';
    if (strlen($line . $kv) > 120) {
        $output .= $line;
        $line = $newLine;
    }
    $line .= $kv;
}
$output .= substr($line, 0, -1);
$output .= "\n}";

echo "Reduced to: {$outputFile}";
file_put_contents($outputFile, $output);
