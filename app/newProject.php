<?php
 
    $dbserver ='localhost';
    $dbuser = 'aouldamara';
    $password = 'cdp';
    $dbname = "aouldamara";
  
    $conn = new mysqli($dbserver, $dbuser, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $description = $_POST['description'];
        $id_manager = 2;
        $sql = "INSERT INTO projet (NOM_PROJET, ID_MANAGER, DESCRIPTION)
        VALUES ('$name','$id_manager','$description')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
?>