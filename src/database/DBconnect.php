<?php
function connect(){
    include __DIR__ . '/logs.php';
    $conn = new mysqli($dbserver, $dbuser, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}