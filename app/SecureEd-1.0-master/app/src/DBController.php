<?php
    /*Ensures the database was initialized and obtain db link*/
    $GLOBALS['dbPath'] = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'persistentconndb.sqlite';
    global $db;
    $db = new SQLite3($GLOBALS['dbPath'], $flags = SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, $encryptionKey = "");

?>
