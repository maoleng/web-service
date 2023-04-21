<?php

use Libraries\migrations\Migration;

foreach (scandir('..\..\Libraries\helpers') as $filename) {
    $path = '..\..\Libraries\helpers'. '\\' . $filename;
    if (is_file($path)) {
        require $path;
    }
}

// Load classes
require_once('../../Libraries/AppLoader.php');
Libraries\AppLoader::load();
require_once '../../Libraries/migrations/Table.php';
require_once '../../Libraries/migrations/Migration.php';

$base_path = asset('database/migrations/tables');
$tables = scandir($base_path);
array_shift($tables);
array_shift($tables);

$is_refresh = (bool) array_search('--fresh', $argv, true);
if ($is_refresh && count($tables) !== 0) {
    (require asset('database/migrations/tables'.'\\'.$tables[0]))->fresh();
}

foreach ($tables as $table) {
    $migration = require asset('database/migrations/tables').'\\'.$table;
    $migration->up();
    echo "Creating table $migration->table...\n";
    $migration->migrate();
    echo "Created table $migration->table!\n";
}


