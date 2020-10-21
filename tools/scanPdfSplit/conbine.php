<?php
$file1 = 'file1.pdf';
$file2 = 'file2.pdf';
$combine = 'combine.pdf';

// Create output file
$command = "pdftk A={$file1} B={$file2} shuffle A Bend-1 output {$combine}";
exec($command);