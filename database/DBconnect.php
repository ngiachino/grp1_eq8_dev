<?php
function connect(){
    include (file_exists(__DIR__ . '/logs.local.php') ? __DIR__ . '/logs.local.php' : __DIR__ . '/logs.php');
    return new mysqli($dbserver, $dbuser, $password, $dbname);
}