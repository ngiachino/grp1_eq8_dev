<?php
function connect(){
    include (file_exists(__DIR__ . '/logs.local.php') ? __DIR__ . '/logs.local.php' : __DIR__ . '/logs.php');
    $conn = new mysqli($dbserver, $dbuser, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}