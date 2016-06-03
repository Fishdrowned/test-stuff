<?php
if (isset($argv[1])) {
    define('DS', DIRECTORY_SEPARATOR);
    $target = $argv[1];
    $target{0} == DS or $target = __DIR__ . DS . $target;
    if (!is_dir($target)) {
        echo "Error: Target directory '{$argv[1]}' does not exist!\n";
        exit(1);
    }
    if (ini_get('phar.readonly')) {
        $iniFile = php_ini_loaded_file();
        echo "Error: phar.readonly is on. Please turn it off in {$iniFile}\n";
        exit(1);
    }
    $packageName = isset($argv[2]) ? $argv[2] : basename($target);
    substr($packageName, -5) == ($ext = '.phar') or $packageName .= $ext;
    $outputPath = isset($argv[3]) ? $argv[3] : getcwd();
    $outputPath{0} == DS or $outputPath = __DIR__ . DS . $outputPath;
    is_dir($outputPath) or mkdir($outputPath, 0777, true);
    $outputFile = $outputPath . DS . $packageName;
    is_file($outputFile) and unlink($outputFile);

    $phar = new Phar($outputFile, 0, $packageName);
    $phar->buildFromDirectory($target);
    $phar->setStub("<?php echo '{$packageName}
'; __HALT_COMPILER();");
} else {
    $script = isset($argv[0]) ? $argv[0] : basename(__FILE__);
    echo "Usage: {$script} <dir> [package_name] [<save_dir>]
Build a phar package from directory.
    <dir>           The target directory to package
    package_name    The package name, default base name of <dir>
    <save_dir>      The directory to save the phar package, default current dir
";
}
