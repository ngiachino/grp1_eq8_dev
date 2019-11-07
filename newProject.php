<?php
 
    $dbserver ='localhost';
    $dbuser = 'root';
    $password = '';
    $dbname = "cdp";
  
    $conn = new mysqli($dbserver, $dbuser, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    /*$sql = "INSERT INTO Projet (NOM_PROJET, ID_MANAGER, DESCRIPTION)
        VALUES ('ProjetTest', 1, 'ceci est un projet incroyable')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }*/
    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $description = $_POST['description'];
        $id_manager = 1;
        $sql = "INSERT INTO Projet (NOM_PROJET, ID_MANAGER, DESCRIPTION)
        VALUES ($name,$id_manager,$description)";
    }
?>