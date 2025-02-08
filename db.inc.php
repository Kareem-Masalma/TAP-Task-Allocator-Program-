<?php
    define('DB_HOST', '176.119.254.176');
    define('DB_USER', 'web1220535_dbuser');
    define('DB_PASSWORD', 'Jd4_jm3$rr');
    define('DB_DATABASE', 'web1220535_db_schema_1220535');
    define('DB_DSN', 'mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE);
    $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
?>