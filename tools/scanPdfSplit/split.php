<?php
/**
 * Split pdf file by information specified in a csv file.
 * Syntax
 *   php split.php --source=<source.pdf> --csv=<split.csv>
 */
$source = 'source.pdf';
$csv = 'split.csv';

$longOptions = [
    'source::',
    'csv::'
];
$options = getopt(NULL, $longOptions);
$source = $options['source'] ?? $source;
$csv = $options['csv'] ?? $csv;

if(0 === strpos(PHP_OS, 'WIN')) {
    setlocale(LC_CTYPE, 'C');
}

$handle = fopen($csv, 'r');

// Read header
fgetcsv($handle);

$fileInfos = [];
$max = 0;
while (($data = fgetcsv($handle)) !== FALSE) {
    $title = $data[0];
    $from = $data[1];
    $to = $data[2] ? $data[2] : $from;
    if ($to > $max) {
        $max = $to;
    }
    $fileInfos[] = [$title, $from, $to];
}
$digit = strlen((string) $max);

foreach ($fileInfos as $data) {
    $title = $data[0];
    $from = $data[1];
    $to = $data[2];
    $leadFrom = sprintf("%0{$digit}d", $from);
    $leadTo = sprintf("%0{$digit}d", $to);
    $command = "pdftk A={$source} cat A{$from}-{$to} output {$leadFrom}_{$leadTo}_{$title}.pdf";
    exec($command);
}

fclose($handle);
echo "DONE.\n";