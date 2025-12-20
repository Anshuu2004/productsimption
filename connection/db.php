<?php
// connection/db.php

// Parse the config file
$config = parse_ini_file(__DIR__ . '/../config.ini', true);
if ($config === false) {
    die('Error: Unable to read the configuration file.');
}

// Get database credentials from config
$db_config = $config['database'];
$host = $db_config['host'];
$db   = $db_config['db'];
$user = $db_config['user'];
$pass = $db_config['pass'];
$charset = $db_config['charset'];

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('DB Connection failed: ' . $e->getMessage());
}
