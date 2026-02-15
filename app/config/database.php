<?php

require_once __DIR__ . '/config.php';

$servername = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$database = DB_NAME;

$dsn = "mysql:host=$servername;dbname=$database;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed:" . $e->getMessage());
}
