<?php

require_once __DIR__ . '/config.php';

// Set timezone to Amsterdam/Netherlands
date_default_timezone_set('Europe/Amsterdam');

$servername = "localhost";
$username = "root";
$password = "";

$conn = new PDO("mysql:host=$servername;dbname=academietien", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Set MySQL timezone to match PHP timezone
$conn->exec("SET time_zone = '+01:00'"); // CET timezone (winter time)
// Note: For automatic daylight saving time, you might want to use:
// $conn->exec("SET time_zone = '" . date('P') . "'");
