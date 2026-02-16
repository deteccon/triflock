<?php
require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

define("DB_HOST", $_ENV['DB_HOST']);
define("DB_USER", $_ENV['DB_USER']);
define("DB_PASSWORD", $_ENV['DB_PASSWORD']);
define("DB_NAME", $_ENV['DB_NAME']);

define("MAIL_HOST", $_ENV['MAIL_HOST']);
define("MAIL_USERNAME", $_ENV['MAIL_USERNAME']);
define("MAIL_PASSWORD", $_ENV['MAIL_PASSWORD']);
define("MAIL_PORT", $_ENV['MAIL_PORT']);

define("SENDER_MAIL", $_ENV['SENDER_MAIL']);

define("BASE_URL", "http://localhost:8000/public");
define("APP_NAME", "Triflock");
