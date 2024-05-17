<?php

require_once __DIR__ . '/../vars.php';

$dsn = "mysql:host=" . APP_DB_HOST . ";port=" . APP_DB_PORT . ";dbname=" . APP_DB_NAME;
$pdo = new PDO($dsn, APP_DB_USER, APP_DB_PASSWORD);