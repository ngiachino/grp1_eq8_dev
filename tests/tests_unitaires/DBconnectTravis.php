<?php
function connectTravis(){
    include "credentialsTravis.php";
    $conn = new mysqli($dbserver, $dbuser, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>