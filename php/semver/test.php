<?php
use Composer\Semver\VersionParser;

include __DIR__ . '/vendor/autoload.php';

$parser = new VersionParser();
$versions = [
    '1.2.4-xx',                 // Invalid version string "1.2.4-xx"
    '0.1.1-dev-86297814',       // Invalid version string "0.1.1-dev-86297814"
    '0.1.1-dev+86297814',       // 0.1.1.0-dev
    '1.0.5-phwoolcon-eab085b',  // Invalid version string "1.0.5-phwoolcon-eab085b"
    '1.0.5+phwoolcon-eab085b',  // 1.0.5.0
    '1.0.5+phwoolcon-123456',   // 1.0.5.0
    'v1.0.0-alpha1',            // 1.0.0.0-alpha1
    '0.0.1-dev+base-e6663614',  // 0.0.1.0-dev
];
foreach ($versions as $version) {
    try {
        var_dump($parser->normalize($version));
    } catch (Exception $e) {
        echo '<pre>', $e->__toString(), '</pre>';
    }
}
