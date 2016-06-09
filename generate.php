<?php

if (!isset($argv[1])) {
    echo 'Usage: php generate.php [SUBJECT]';
    exit(1);
}

file_put_contents(
    date('Y-m-d').'_'.str_replace(' ', '-', strtolower($argv[1])).'.md',
    '# '.$argv[1].PHP_EOL.PHP_EOL
);
