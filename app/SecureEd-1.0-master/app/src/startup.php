<?php

// Resolve every path from this file so startup behaves the same on Windows,
// macOS, Linux, and inside the Docker container.
$appRoot = dirname(__DIR__);
$GLOBALS['dbPath'] = $appRoot . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'persistentconndb.sqlite';

if (is_file($GLOBALS['dbPath']) && !unlink($GLOBALS['dbPath'])) {
    throw new RuntimeException('Unable to reset the SQLite database.');
}

$uploadsPath = $appRoot . DIRECTORY_SEPARATOR . 'uploads';
if (is_dir($uploadsPath)) {
    foreach (glob($uploadsPath . DIRECTORY_SEPARATOR . '*') as $upload) {
        if (is_file($upload) && !unlink($upload)) {
            throw new RuntimeException('Unable to clear the uploads directory.');
        }
    }
} else {
    mkdir($uploadsPath, 0775, true);
}

// config.php uses paths relative to the application root. Include it after
// changing to that directory instead of invoking a case-sensitive shell path.
$previousDirectory = getcwd();
chdir($appRoot);
require $appRoot . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';
chdir($previousDirectory);
$GLOBALS['dbPath'] = $appRoot . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'persistentconndb.sqlite';

$database = new SQLite3($GLOBALS['dbPath'], SQLITE3_OPEN_READONLY);
$tableCount = (int) $database->querySingle(
    "SELECT COUNT(*) FROM sqlite_master WHERE type = 'table'"
);
$database->close();

if ($tableCount < 6) {
    throw new RuntimeException('Database initialization did not create the expected tables.');
}
