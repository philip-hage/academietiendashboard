<?php

session_start();
$user = $_SESSION['user_id'];
if (!$user) {
    header("Location: ../../index.php");
    exit();
}


define('APPROOT', dirname(dirname(__FILE__)));
