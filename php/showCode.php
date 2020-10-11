<?php
/**
 * This is a useless snippet.
 * This program just display every line of codes in specified folder to the screen
 * (which we usually see in films :D).
 * Syntax
 *   php showCode.php --directory=<directory> --fileType=<file,extension> --wait=<50>
 * Here
 * + directory: The directory to find files inside. Default to current directory.
 * + fileType: Extension of file to be used, separated by comma. Default to "json,php,c,cpp,java"
 * + wait: Sleep time between display of two lines. Default to 50 milli seconds.
 */
$directory = '.';
$fileType = 'json,php,c,cpp,java';
$wait = 50;

$options = getopt(NULL, ['directory::', 'fileType::']);

$directory = array_key_exists('directory', $options) ? $options['directory'] : $directory;
$fileType = array_key_exists('fileType', $options) ? $options['fileType'] : $fileType;
$wait = array_key_exists('wait', $options) ? $options['wait'] : $wait;

$fileType = explode(',', $fileType);

$allFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

foreach ($fileType as $type) {
    $files = new RegexIterator($allFiles, "/\.php/");
    foreach ($files as $file) {
        $lines = file($file->getPathname());
        foreach ($lines as $line) {
            echo "$line";
            usleep($wait * 1000);
        }
    }
}